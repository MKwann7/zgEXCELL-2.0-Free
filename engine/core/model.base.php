<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

if (!defined('App')) { die('Illegal Access'); }

class AppModel
{
    protected $EntityName = "";

    protected $ModelName = "";

    protected $PropertyCount = 0;

    protected $Properties = array();

    private $Definitions = array();

    public $Errors = array();

    public function __construct($strEntityName, $strModelName)
    {
        if ( empty(App::$objAppModules[$strEntityName]))
        {
            $this->Errors["main"] = $strEntityName . " entity not found.";
            return;
        }

        $this->EntityName = $strEntityName;

        if ( empty(App::$objAppModules[$strEntityName]["Models"][$strModelName]) )
        {
            $this->Errors["main"]["setup"] = $strModelName . " model not found in " . $strEntityName . " entity.";
            return;
        }

        $this->ModelName = $strModelName;

        $strModelRequest = App::$objAppModules[$strEntityName]["Models"][$strModelName];

        $strModelRequestPath = AppCore . "modules/" . $strEntityName . "/models/" . $strModelRequest ."Model.json";

        if ( is_file($strModelRequestPath))
        {
            $objCurrentModule = json_decode(file_get_contents($strModelRequestPath),true);

            foreach( $objCurrentModule["Properties"] as $currModelKey => $currModelData)
            {
                $this->Properties[$currModelKey] = null;
            }

            $this->Definitions = $objCurrentModule["Properties"];

            $this->PropertyCount = count($objCurrentModule["Properties"]);
        }
    }

    public function __get($strName)
    {
        if (isset($this->Properties[$strName]))
        {
            return $this->Properties[$strName];
        }
    }

    public function __set($strName, $objValue)
    {
        if ( $strName == "ChildEntities" )
        {
            $this->{$strName} = $objValue;
        }
        return false;
    }

    function Add($strName, $objValue)
    {
        if ( empty($this->Definitions[$strName]) )
        {
            $this->Errors["model"]["integrity"][] = $strName . " is not in the model.";
            return false;
        }

        if ( !$this->validate($strName, $objValue) )
        {
            return false;
        }

        $this->Properties[$strName] = $objValue;
    }

    public function validate($strName = null, $objValue = null)
    {
        if ( $strName != null && $strName == null)
        {
            $this->Errors[$strName]["setup"] = $objValue . " was not passed in.";
            return false;
        }

        $blnModelPassesValidation = true;

        if ( $strName == null && $objValue == null )
        {
            foreach($this->Properties as $currKey => $currPropertyValue)
            {
                if(!$this->validate_item($currKey, $currPropertyValue))
                {
                    $blnModelPassesValidation = false;
                }
            }
        }
        else
        {
            if(!$this->validate_item($strName, $objValue))
            {
                $blnModelPassesValidation = false;
            }
        }

        return $blnModelPassesValidation;
    }

    private function validate_item($strName, $objValue)
    {
        unset($this->Errors[$strName]);

        if (!empty($this->Definitions[$strName]["required"]) && empty($objValue) )
        {
            $this->Errors[$strName]["required"] = $strName . " is required.";
        }

        if ( empty($objValue) )
        {
            return true;
        }

        switch($this->Definitions[$strName]["type"])
        {
            case "int":
                if (!isInteger($objValue))
                {
                    $this->Errors[$strName]["type"] = $objValue . " is not an integer.";
                    return false;
                }
                break;
            case "decimal":
                if (!isDecimal($objValue))
                {
                    $this->Errors[$strName]["type"] = $objValue . " is not an decimal.";
                    return false;
                }
                break;
            case "datetime":
                if (!isDateTime($objValue))
                {
                    $this->Errors[$strName]["type"] = $objValue . " is not an datetime.";
                    return false;
                }
                break;
            case "varchar":
                if (is_numeric ($objValue) && !is_string($objValue))
                {
                    $this->Errors[$strName]["type"] = $objValue . " is not an string.";
                    return false;
                }
                break;
            case "json":
                if (!$this->is_json($objValue, $strName))
                {
                    return false;
                }
                break;
        }

        if ( !empty($this->Definitions[$strName]["length"]) && floatval($this->Definitions[$strName]["length"]) > 0)
        {
            if ( strlen($objValue) > floatval($this->Definitions[$strName]["length"]) )
            {
                $this->Errors[$strName]["length"] = $objValue . " is too long. Limit is " . $this->Definitions[$strName]["length"] . "characters.";
                return false;
            }
        }
        return true;
    }

    private function is_json($objValue, $strName)
    {
        // decode the JSON data
        try
        {
            $strJsonString = "";

            if ( is_array($objValue) )
            {

                $strJsonString = json_encode(Core::Base64Encode($objValue));
            }
            else
            {
                $strJsonString = $objValue;
            }

            $result = json_decode($strJsonString);
            $error  = "";

            switch ( json_last_error() )
            {
                case JSON_ERROR_NONE:
                    break;
                case JSON_ERROR_DEPTH:
                    $error = 'The maximum stack depth has been exceeded.';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error = 'Invalid or malformed JSON.';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $error = 'Control character error, possibly incorrectly encoded.';
                    break;
                case JSON_ERROR_SYNTAX:
                    $error = 'Syntax error, malformed JSON.';
                    break;
                // PHP >= 5.3.3
                case JSON_ERROR_UTF8:
                    $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                    break;
                // PHP >= 5.5.0
                case JSON_ERROR_RECURSION:
                    $error = 'One or more recursive references in the value to be encoded.';
                    break;
                // PHP >= 5.5.0
                case JSON_ERROR_INF_OR_NAN:
                    $error = 'One or more NAN or INF values in the value to be encoded.';
                    break;
                case JSON_ERROR_UNSUPPORTED_TYPE:
                    $error = 'A value of a type that cannot be encoded was given.';
                    break;
                default:
                    $error = 'Unknown JSON error occured.';
                    break;
            }

            if ( $error !== "" )
            {
                $this->Errors[$strName]["type"] = "JSON: " . $error;
                return false;
            }

            return true;
        }
        catch(Exception $ex)
        {
            $this->Errors[$strName]["type"] = "JSON: " . $ex->getMessage();
            return false;
        }
    }
}