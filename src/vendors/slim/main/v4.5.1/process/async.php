<?php

// Uncomment if you want to allow posts from other domains
// header('Access-Control-Allow-Origin: *');

require_once(__DIR__ . '/slim.php');

$objLoggedInUser = $app->getActiveLoggedInUser();

logText("Slim.SaveFile.Process.log","User: " . $objLoggedInUser->first_name ?? "");

$slim = new Slim($app);

// Get posted data, if something is wrong, exit
try {
    $images = $slim
        ->setFiles($_FILES)
        ->setPost($_POST)
        ->getImages();
}
catch (Exception $e) {

    // Possible solutions
    // ----------
    // Make sure you're running PHP version 5.6 or higher

    $slim->outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'Unknown'
    ));

    return;
}

// No image found under the supplied input name
if ($images === false) {

    // Possible solutions
    // ----------
    // Make sure the name of the file input is "slim[]" or you have passed your custom
    // name to the getImages method above like this -> Slim::getImages("myFieldName")

    $slim->outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No data posted'
    ));

    return;
}

// Should always be one image (when posting async), so we'll use the first on in the array (if available)
$image = array_shift($images);

// Something was posted but no images were found
if (!isset($image)) {

    // Possible solutions
    // ----------
    // Make sure you're running PHP version 5.6 or higher

    $slim->outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No images found'
    ));

    return;
}

// If image found but no output or input data present
if (!isset($image['output']['data']) && !isset($image['input']['data'])) {

    // Possible solutions
    // ----------
    // If you've set the data-post attribute make sure it contains the "output" value -> data-post="actions,output"
    // If you want to use the input data and have set the data-post attribute to include "input", replace the 'output' String above with 'input'

    $slim->outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No image data'
    ));

    return;
}



// if we've received output data save as file
if (isset($image['output']['data'])) {

    // get the name of the file
    $name = 'mainImage.jpg';

    // get the crop data for the output image
    $data = $image['output']['data'];

    logText("Slim.SaveFile.Process.log","Upload Image Output: " . $image["output"]["name"] ?? "");
    logText("Slim.SaveFile.Process.log","Upload Image name: " . json_encode($name));
    logText("Slim.SaveFile.Process.log","Upload Image params: " . json_encode($objParams));

    // If you want to store the file in another directory pass the directory name as the third parameter.
    // $file = Slim::saveFile($data, $name, 'my-directory/');

    // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
    // $file = Slim::saveFile($data, $name, 'tmp/', false);

    $intEntityName = $objParams->entity_name;
    $intEntityId = $objParams->entity_id;
    $intUserId = $objParams->user_id;
    $strClass = $objParams->class;

    $input = $slim->saveFile($data, $name, $intEntityName, $intEntityId, $intUserId, $strClass, false);
}

// if we've received input data (do the same as above but for input data)
if (isset($image['input']['data'])) {

    // get the name of the file
    $name = 'mainImage.jpg';

    // get the crop data for the output image
    $data = $image['input']['data'];

    logText("Slim.SaveFile.Process.log","Upload Image Input" . json_encode($image));
    logText("Slim.SaveFile.Process.log","Upload Image name" . json_encode($name));
    logText("Slim.SaveFile.Process.log","Upload Image data" . json_encode($data));

    // If you want to store the file in another directory pass the directory name as the third parameter.
    // $file = Slim::saveFile($data, $name, 'my-directory/');

    // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
    // $file = Slim::saveFile($data, $name, 'tmp/', false);

    $intEntityName = $objParams->entity_name;
    $intEntityId = $objParams->entity_id;
    $intUserId = $objParams->user_id;
    $strClass = $objParams->class;

    $input = $slim->saveFile($data, $name, $intEntityName, $intEntityId, $intUserId, $strClass, false);
}



//
// Build response to client
//
$response = array(
    'status' => SlimStatus::SUCCESS
);

logText("Slim.Process.log", "output: " . json_encode($output ?? []));
logText("Slim.Process.log", "input: " . json_encode($input ?? []));

if (isset($output) && isset($input)) {

    $response['output'] = array(
        'file' => $output['name'],
        'path' => $output['path']
    );

    $response['input'] = array(
        'file' => $input['name'],
        'path' => $input['path']
    );

}
else {
    $response['file'] = isset($output) ? $output['name'] : $input['name'];
    $response['path'] = isset($output) ? $output['path'] : $input['path'];
}


// Return results as JSON String
$slim->outputJSON($response);


