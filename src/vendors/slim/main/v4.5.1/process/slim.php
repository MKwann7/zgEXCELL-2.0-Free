<?php

abstract class SlimStatus {
    const FAILURE = 'failure';
    const SUCCESS = 'success';
}

class Slim {

    public static function getImages($inputName = 'slim') {

        $values = Slim::getPostData($inputName);

        // test for errors
        if ($values === false) {
            return false;
        }

        // determine if contains multiple input values, if is singular, put in array
        $data = array();
        if (!is_array($values)) {
            $values = array($values);
        }

        // handle all posted fields
        foreach ($values as $value) {
            $inputValue = Slim::parseInput($value);
            if ($inputValue) {
                logText("Slim.Image.Process.log", "Name: " .  $inputValue["output"]["name"] ?? "Empty");
                array_push($data, $inputValue);
            }
        }

        // return the data collected from the fields
        return $data;

    }

    // $value should be in JSON format
    private static function parseInput($value) {

        // if no json received, exit, don't handle empty input values.
        if (empty($value)) {return null;}

        // The data is posted as a JSON String so to be used it needs to be deserialized first
        $data = json_decode($value);

        // shortcut
        $input = null;
        $actions = null;
        $output = null;
        $meta = null;

        if (isset ($data->input)) {

            $inputData = null;
            if (isset($data->input->image)) {
                $inputData = Slim::getBase64Data($data->input->image);
            }
            else if (isset($data->input->field)) {
                $filename = $_FILES[$data->input->field]['tmp_name'];
                if ($filename) {
                    $inputData = file_get_contents($filename);
                }
            }

            $input = array(
                'data' => $inputData,
                'name' => $data->input->name,
                'type' => $data->input->type,
                'size' => $data->input->size,
                'width' => $data->input->width,
                'height' => $data->input->height,
            );

        }

        if (isset($data->output)) {
            
            $outputDate = null;
            if (isset($data->output->image)) {
                $outputData = Slim::getBase64Data($data->output->image);
            }
            else if (isset ($data->output->field)) {
                logText("Slim.Image.Process.log", "FieldName: " . $data->output->field);
                $filename = $_FILES[$data->output->field]['tmp_name'];

                logText("Slim.Image.Process.log", "FileName" . $filename);
                if ($filename) {
                    logText("Slim.Image.Process.log", "FileData: FOUND");
                    $outputData = file_get_contents($filename);
                }
                else
                {
                    logText("Slim.Image.Process.log", "FileData: EMPTY");
                }
            }
            
            $output = array(
                'data' => $outputData,
                'name' => $data->output->name,
                'type' => $data->output->type,
                'width' => $data->output->width,
                'height' => $data->output->height
            );
        }

        if (isset($data->actions)) {
            $actions = array(
                'crop' => $data->actions->crop ? array(
                    'x' => $data->actions->crop->x,
                    'y' => $data->actions->crop->y,
                    'width' => $data->actions->crop->width,
                    'height' => $data->actions->crop->height,
                    'type' => $data->actions->crop->type
                ) : null,
                'size' => $data->actions->size ? array(
                    'width' => $data->actions->size->width,
                    'height' => $data->actions->size->height
                ) : null
            );
        }

        if (isset($data->meta)) {
            $meta = $data->meta;
        }

        // We've sanitized the base64data and will now return the clean file object
        return array(
            'input' => $input,
            'output' => $output,
            'actions' => $actions,
            'meta' => $meta
        );
    }

    // $path should have trailing slash
    public static function saveFile($data, $name, $entityType = 'user', $entityId = 1000, $intUserId = 1000, $strClass = "editor", $uid = true)
    {
        logText("Slim.SaveFile.Process.log", "saveFile: [START]");
        // Let's put a unique id in front of the filename so we don't accidentally overwrite older files
        $arFilePath = explode(".", $name);
        $strFileExtension = end($arFilePath);
        $strTempFileNameAndPath = APP_STORAGE . 'uploads/'. sha1(microtime()) . "." . $strFileExtension;

        // Save Tempfile
        file_put_contents($strTempFileNameAndPath, $data);

        logText("Slim.SaveFile.Process.log", "saveFile: [POST] " . $strTempFileNameAndPath);

        try
        {
            $strPostUrl = "https://app.ezcardmedia.com/upload-image/{$entityType}s/" . $entityId;
            logText("Slim.SaveFile.Process.log", "POST URL = " . $strPostUrl);
            $objHttp = new App\Utilities\Http\Http();
            $objFileForCurl = curl_file_create($strTempFileNameAndPath);
            $objHttpRequest = $objHttp->newRawRequest(
                "post",
                $strPostUrl,
                [
                    "file" => $objFileForCurl,
                    "user_id" => $intUserId,
                    "image_class" => $strClass
                ]
            )
                ->setOption(CURLOPT_CAINFO, '/etc/ssl/ca-bundle.crt')
                ->setOption(CURLOPT_SSL_VERIFYPEER, false);

            $objHttpResponse = $objHttpRequest->send();

            unlink($strTempFileNameAndPath);
        }
        catch(\Exception $ex)
        {
            logText("Slim.SaveFile.Process.log", "Error: " . $ex);
        }

        logText("Slim.SaveFile.Process.log", "Response: " . json_encode($objHttpResponse));

        if ( $objHttpResponse->statusCode !== 200 )
        {
            logText("Slim.SaveFile.Process.log","Upload Image to Media Server Did Not Return a 200 - " . $objHttpResponse->statusCode);
            return false;
        }

        $objDeletionResponse = json_decode($objHttpResponse->body);

        if ($objDeletionResponse->success == false)
        {
            logText("Slim.SaveFile.Process.log","Upload Image to Media Server Failed: " . json_encode($objDeletionResponse));
            return false;
        }

        // return the files new name and location
        return array(
            'name' => $name,
            'path' => $objDeletionResponse->link
        );
    }

    public static function outputJSON($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * http://stackoverflow.com/a/2021729
     * Remove anything which isn't a word, whitespace, number
     * or any of the following characters -_~,;[]().
     * If you don't need to handle multi-byte characters
     * you can use preg_replace rather than mb_ereg_replace
     * @param $str
     * @return string
     */
    public static function sanitizeFileName($str) {
        // Basic clean up
        $str = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $str);
        // Remove any runs of periods
        $str = mb_ereg_replace("([\.]{2,})", '', $str);
        return $str;
    }

    /**
     * Gets the posted data from the POST or FILES object. If was using Slim to upload it will be in POST (as posted with hidden field) if not enhanced with Slim it'll be in FILES.
     * @param $inputName
     * @return array|bool
     */
    private static function getPostData($inputName) {

        $values = array();

        if (isset($_POST[$inputName])) {
            $values = $_POST[$inputName];

            logText("Slim.Async.Process.log", "POST: " . json_encode($values));
        }
        else if (isset($_FILES[$inputName])) {
            logText("Slim.Async.Process.log", "FILES: " . json_encode($inputName));
            // Slim was not used to upload this file
            return false;
        }

        return $values;
    }

    /**
     * Saves the data to a given location
     * @param $data
     * @param $path
     */
    private static function save($data, $path) {
        file_put_contents($path, $data);
    }

    /**
     * Strips the "data:image..." part of the base64 data string so PHP can save the string as a file
     * @param $data
     * @return string
     */
    private static function getBase64Data($data) {
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    }

}
