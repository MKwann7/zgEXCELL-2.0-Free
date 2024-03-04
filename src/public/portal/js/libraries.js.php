<?php

use App\Website\Website;

$strBodyId = $this->app->objHttpRequest->Data->Params['page'];

$arActiveJavaScriptLibraries = [
    "vendor" => array(
        "jquery" => [
            "main" => true,
            "ui" => true,
            "form" => true,
            "ui-touch-punch" => true,
        ],
        "lodash" => true,
        "modernizr" => true,
        "slim" => true,
        "vue" => true,
        "grapick" => true,
    )
];

header('Content-Type:text/javascript');
header('Cache-Control: public, max_age=3600');

foreach($this->app->arJavaScriptLibraries->vendor as $strvendorName => $arvendorLibraries)
{
    foreach($arvendorLibraries as $strLibraryPath => $strLibraryFileNames)
    {
        $arLibraryPaths = explode("/", $strLibraryPath);
        if( !empty($arActiveJavaScriptLibraries["vendor"][$strvendorName]) && $arActiveJavaScriptLibraries["vendor"][$strvendorName] === true)
        {
            foreach($strLibraryFileNames as $strLibraryFileName)
            {
                $strJsFilePath = APP_VENDORS . $strvendorName . "/" . $strLibraryPath . "/min/" . $strLibraryFileName;

                if (is_file($strJsFilePath))
                {
                    echo "/* ".$strvendorName . " " .$strLibraryPath . " " . $strLibraryFileName . " */" . PHP_EOL . PHP_EOL;
                    require $strJsFilePath;
                    echo PHP_EOL . PHP_EOL;
                }
            }
        }
        elseif( !empty($arActiveJavaScriptLibraries["vendor"][$strvendorName]) && is_array($arActiveJavaScriptLibraries["vendor"][$strvendorName]))
        {
            foreach($strLibraryFileNames as $strLibraryFileName)
            {
                if( !empty($arActiveJavaScriptLibraries["vendor"][$strvendorName]) && !empty($arActiveJavaScriptLibraries["vendor"][$strvendorName][$arLibraryPaths[0]]) && $arActiveJavaScriptLibraries["vendor"][$strvendorName][$arLibraryPaths[0]] === true)
                {
                    $strJsFilePath = APP_VENDORS . $strvendorName . "/" . $strLibraryPath . "/min/" . $strLibraryFileName;

                    if (is_file($strJsFilePath))
                    {

                        echo "/* ".$strvendorName . " " .$strLibraryPath . " " . $strLibraryFileName . " */" . PHP_EOL . PHP_EOL;
                        require $strJsFilePath;
                        echo PHP_EOL . PHP_EOL;
                    }
                }
            }
        }
    }
}

$objWebsite = new Website($this->app);

$objPagevendors = $objWebsite->GetVendorsForPage($strBodyId);

foreach($objPagevendors as $arvendorLibraryName => $arvendorLibraryCollection)
{
    foreach($arvendorLibraryCollection as $strLibraryPath => $arvendorLibraries)
    {
        if (!empty($arvendorLibraries->JS))
        {
            foreach($arvendorLibraries->JS as $strLibraryFilePath => $strLibraryFileNames)
            {
                foreach($strLibraryFileNames as $strLibraryFileName)
                {
                    $strJsFilePath = APP_VENDORS . $arvendorLibraryName . "/" . $strLibraryFilePath . "/min/" . $strLibraryFileName;
                    if (is_file($strJsFilePath))
                    {
                        echo "/* ".$arvendorLibraryName . " " .$strLibraryPath . " " . $strLibraryFileName . " */" . PHP_EOL . PHP_EOL;
                        require $strJsFilePath;
                        echo PHP_EOL . PHP_EOL;
                    }
                }
            }
        }
    }
}

?>