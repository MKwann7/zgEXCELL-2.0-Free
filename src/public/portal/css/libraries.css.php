<?php

use App\Website\Website;

$strBodyId = $this->app->objHttpRequest->Data->Params['page'];

$arActiveCssLibraries = [
    "vendor" => array(
        "jquery" => [
            "form" => true,
            "main" => true,
            "ui" => true,
        ],
        "lodash" => true,
        "modernizr" => true,
        "vue" => true
    )
];

header('Content-Type:text/css');
header('Cache-Control: public, max_age=3600');

foreach($this->app->arCssLibraries->vendor as $strVenderName => $arVenderLibraries)
{
    foreach($arVenderLibraries as $strLibraryPath => $strLibraryFileNames)
    {
        $arLibraryPaths = explode("/", $strLibraryPath);
        if( !empty($arActiveCssLibraries["vendor"][$strVenderName]) && $arActiveCssLibraries["vendor"][$strVenderName] === true)
        {
            foreach($strLibraryFileNames as $strLibraryFileName)
            {
                $strJsFilePath = AppVendors . $strVenderName . "/" . $strLibraryPath . "/min/" . $strLibraryFileName;

                if (is_file($strJsFilePath))
                {
                    echo "/* ".$strVenderName . " " .$strLibraryPath . " " . $strLibraryFileName . " */" . PHP_EOL . PHP_EOL;
                    require $strJsFilePath;
                    echo PHP_EOL . PHP_EOL;
                }
            }
        }
        elseif( !empty($arActiveCssLibraries["vendor"][$strVenderName]) && is_array($arActiveCssLibraries["vendor"][$strVenderName]))
        {
            foreach($strLibraryFileNames as $strLibraryFileName)
            {
                if( !empty($arActiveCssLibraries["vendor"][$strVenderName]) &&
                !empty($arActiveCssLibraries["vendor"][$strVenderName][$arLibraryPaths[0]]) &&
                $arActiveCssLibraries["vendor"][$strVenderName][$arLibraryPaths[0]] === true)
                {
                    $strJsFilePath = AppVendors . $strVenderName . "/" . $strLibraryPath . "/min/" . $strLibraryFileName;

                    if (is_file($strJsFilePath))
                    {
                        echo "/* ".$strVenderName . " " .$strLibraryPath . " " . $strLibraryFileName . " */" . PHP_EOL . PHP_EOL;
                        require $strJsFilePath;
                        echo PHP_EOL . PHP_EOL;
                    }
                }
            }
        }
    }
}

$objWebsite = new Website($this->app);

$objPageVenders = $objWebsite->GetVendorsForPage($strBodyId);

foreach($objPageVenders as $arVenderLibraryName => $arVenderLibraryCollection)
{
    foreach($arVenderLibraryCollection as $strLibraryPath => $arVenderLibraries)
    {
        if (!empty($arVenderLibraries->CSS))
        {
            foreach($arVenderLibraries->CSS as $strLibraryFilePath => $strLibraryFileNames)
            {
                foreach($strLibraryFileNames as $strLibraryFileName)
                {
                    $strCssFilePath = AppVendors . $arVenderLibraryName . "/" . $strLibraryFilePath . "/min/" . $strLibraryFileName;
                    if (is_file($strCssFilePath))
                    {
                        echo "/* ".$arVenderLibraryName . " " .$strLibraryPath . " " . $strLibraryFileName . " */" . PHP_EOL . PHP_EOL;
                        require $strCssFilePath;
                        echo PHP_EOL . PHP_EOL;
                    }
                }
            }
        }
    }
}

echo $objWebsite->GetPageStyle($strBodyId) . PHP_EOL;

?>