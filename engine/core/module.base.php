<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

if (!defined('App')) { die('Illegal Access'); }

class AppModule
{
    public static $strEntityName = "";
    public static $strDatabaseName = "";
    public static $strMainModelName = "";
    public static $strMainModelPrimary = "";

    public static function GetById($intEntityRowId)
    {
        if ( empty(static::$strEntityName) || empty(static::$strMainModelName) )
        {
            return null;
        }

        $objEntityModel = App::GetModel(static::$strEntityName, static::$strMainModelName);

        $objEntityModel->Add(static::$strEntityName, $intEntityRowId);

        if (!$objEntityModel->validate())
        {
            return null;
        }

        $strGetEntityByIdQuery = "SELECT *  FROM `" . static::$strDatabaseName . "` WHERE " . static::$strMainModelPrimary . " = " . $intEntityRowId . " LIMIT 1";

        $objEntityResult = Core::GetComplex(App::$objCoreData, $strGetEntityByIdQuery,'page_data','page_data','page_id');

        if ( $objEntityResult["Result"]["success"] == false || $objEntityResult["Result"]["rows"] == 0 )
        {
            return $objEntityResult;
        }

        foreach($objEntityResult["Data"] as $currKey => $currData)
        {
            $objEntityResult[ucwords(static::$strEntityName)][] = App::CreateModel(static::$strEntityName, static::$strMainModelName, $currData);
        }

        unset($objEntityResult["Data"]);

        return $objEntityResult;
    }

    public static function GetRows($strWhereClause)
    {
        $strGetEntityByIdQuery = "SELECT * FROM `" . static::$strDatabaseName . "` WHERE " . $strWhereClause . " LIMIT 1";

        $objEntityResult = Core::GetComplex(App::$objCoreData, $strGetEntityByIdQuery,'page_data','page_data','page_id');

        if ( $objEntityResult["Result"]["success"] == false || $objEntityResult["Result"]["rows"] == 0 )
        {
            return $objEntityResult;
        }

        foreach($objEntityResult["Data"] as $currKey => $currData)
        {
            $objEntityResult[ucwords(static::$strEntityName)][] = App::CreateModel(static::$strEntityName, static::$strMainModelName, $currData);
        }

        unset($objEntityResult["Data"]);


        return $objEntityResult;
    }
}