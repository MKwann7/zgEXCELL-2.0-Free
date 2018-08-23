<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */
if (!defined('App')) { die('Illegal Access'); }

class PageModule extends AppModule
{
    public static $strEntityName = "pages";
    public static $strDatabaseName = "page";
    public static $strMainModelName = "zgPage";
    public static $strMainModelPrimary = "page_id";

    public static function GetById($intEntityRowId)
    {
        $objPageRequest = parent::GetById($intEntityRowId);

        if ( $objPageRequest["Result"]["success"] == false || $objPageRequest["Result"]["rows"] == 0 )
        {
            return $objPageRequest;
        }

        $arPageBlockPages = array();

        foreach($objPageRequest[ucwords(static::$strEntityName)] as $currKey => $currData)
        {
            $arPageBlockPages[] = static::$strMainModelPrimary . " = " . $currData->page_id;
        }

        $strPageBlockQuery = "SELECT * FROM page_block WHERE " . implode(" || ",$arPageBlockPages) . " ORDER BY sort_order ASC";

        $objPageBlockResult = Core::GetComplex(App::$objCoreData, $strPageBlockQuery,'block_data','block_data','page_block_id');

        if ( $objPageBlockResult["Result"]["success"] == false || $objPageBlockResult["Result"]["rows"] == 0 )
        {
            return $objPageRequest;
        }

        $objTest = array();

        foreach ($objPageBlockResult["Data"] as $currKey => $currData)
        {
            $objTest["PageBlocks"][] = App::CreateModel(static::$strEntityName, "zgPageBlock", $currData);
        }

        $objPageRequest[ucwords(static::$strEntityName)][0]->ChildEntities = $objTest;

        return $objPageRequest;
    }

    public static function GetAllActivePages()
    {
        $strGetAllActivePagesQuery = "SELECT page_id, page_parent_id, status, unique_url, uri_request_list, title, type, menu_order, menu_visibility, menu_name, ddr_widget, page_data 
                                      FROM `page` 
                                      WHERE 
                                        status = 'published' AND 
                                        ( type = 'page' OR type = 'link' OR type = 'admin' OR type LIKE 'dynamic%' )";

        $objAllPages = Core::GetComplex(App::$objCoreData, $strGetAllActivePagesQuery,'page_data','page_data','page_id');

        if ( $objAllPages["Result"]["success"] == false || $objAllPages["Result"]["rows"] == 0 )
        {
            return $objAllPages;
        }

        foreach($objAllPages["Data"] as $currKey => $currData)
        {
            $objAllPages[ucwords(static::$strEntityName)][] = App::CreateModel(static::$strEntityName, static::$strMainModelName, $currData);
        }

        unset($objAllPages["Data"]);

        return $objAllPages;
    }

}