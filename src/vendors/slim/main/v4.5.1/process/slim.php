<?php

abstract class SlimStatus {
    const FAILURE = 'failure';
    const SUCCESS = 'success';
}

class Slim {

    private array $post = [];
    private array $files = [];
    public function __construct(
        private \App\Core\App $app,
        private string $userUuid
    ) {
    }

    public function setFiles(array $files) : self
    {
        $this->files = $files;
        return $this;
    }

    public function setPost(array $post) : self
    {
        $this->post = $post;
        return $this;
    }

    public function getImages(string $inputName = 'slim')
    {
        $values = $this->getPostData($inputName);

        // test for errors
        if ($values === false) {
            return false;
        }

        // determine if contains multiple input values, if is singular, put in array
        $data = [];
        if (!is_array($values)) {
            $values = array($values);
        }

        // handle all posted fields
        foreach ($values as $value) {
            $inputValue = $this->parseInput($value);
            if ($inputValue) {
                array_push($data, $inputValue);
            }
        }

        // return the data collected from the fields
        return $data;

    }

    // $value should be in JSON format
    private function parseInput($value)
    {
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
                $inputData = $this->getBase64Data($data->input->image);
            }
            else if (isset($data->input->field)) {
                $filename = $this->files[$data->input->field]['tmp_name'];
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
                $outputData = $this->getBase64Data($data->output->image);
            }
            else if (isset ($data->output->field)) {
                logText("Slim.Image.Process.log", "FieldName: " . $data->output->field);
                $filename = $this->files[$data->output->field]['tmp_name'];

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

    public function saveFile($data, $name, $entityType = 'user', $entityId = 1000, $intUserId = 1000, $strClass = "editor", $uid = true)
    {
        $arFilePath = explode(".", $name);
        $strFileExtension = end($arFilePath);
        $strTempFileNameAndPath = APP_TMP . 'uploads/'. sha1(microtime()) . "." . $strFileExtension;

        if (!is_dir(APP_TMP . 'uploads/')) {
            mkdir(APP_TMP . 'uploads/');
        }

        file_put_contents($strTempFileNameAndPath, $data);

        if (!file_get_contents($strTempFileNameAndPath)) {
            die("We didn't write the tmp file correctly.");
        }

        return $this->postFileToMediaServer($strTempFileNameAndPath, $name, $entityType, $entityId, $intUserId, $strClass);
    }

    public function postFileToMediaServer(
        string $filenameAndPath,
        string $name,
        string $entityType,
        string $entityId,
        mixed    $intUserId,
        string $strClass,
        int $parentId = null
    ) {
        ini_set('memory_limit', '-1');
        set_time_limit(500);

        try {
            $postUrl = $this->app->getCustomPlatform()->getFullMediaDomainName(true) . "/upload-image";
            $objHttp = new App\Utilities\Http\Http();

            $objHttp->setDefaultHeaders([
                "Authorization" => "Bearer {$this->userUuid}"
            ]);

            $curlFileObject = curl_file_create($filenameAndPath);

            $objHttpRequest = $objHttp->newFormRequest(
                "post",
                $postUrl,
                [
                    "file" => $curlFileObject,
                    "entity_id" => $entityId,
                    "entity_name" => $entityType,
                    "user_id" => $intUserId,
                    "image_class" => $strClass,
                    "parent_id" => $parentId ?? "X"
                ]
            )
                ->setOption(CURLOPT_CAINFO, '/etc/ssl/certs/ca-certificates.crt')
                ->setOption(CURLOPT_SSL_VERIFYPEER, false);

            $objHttpResponse = $objHttpRequest->send();

        } catch(\Exception $ex) {
            logText("Slim.SaveFile.Process.log", "Error: " . $ex->getMessage());
        }

        if ($objHttpResponse->statusCode !== 200) {
            logText("Slim.SaveFile.Process.log","Upload Image to Media Server Did Not Return a 200 - " . $objHttpResponse->statusCode);
            logText("Slim.SaveFile.Process.log","Error in Body: " . $objHttpResponse->body);
            return false;
        }

        $objDeletionResponse = json_decode($objHttpResponse->body);

        if ($objDeletionResponse->success == false) {
            logText("Slim.SaveFile.Process.log","Upload Image to Media Server Failed: " . json_encode($objDeletionResponse));
            return false;
        }

        // return the files new name and location
        return array(
            'name' => $name,
            'path' => $objDeletionResponse->data->image,
            'id' => $objDeletionResponse->data->image_id,
            'type' => $objDeletionResponse->data->type,
        );
    }

    public function outputJSON($data) : bool
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        die;
        return true;
    }

    public function sanitizeFileName($str) {
        // Basic clean up
        $str = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $str);
        // Remove any runs of periods
        $str = mb_ereg_replace("([\.]{2,})", '', $str);
        return $str;
    }

    private function getPostData(string $inputName) {

        $values = [];

        if (isset($this->post[$inputName])) {
            $values = $this->post[$inputName];
        }
        else if (isset($this->files[$inputName])) {
            return false;
        }

        return $values;
    }

    private function save($data, $path) {
        file_put_contents($path, $data);
    }

    private function getBase64Data($data) {
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    }

}
