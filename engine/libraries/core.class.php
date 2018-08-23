<?php
/**
 * SHELL _site_core Extention for zgEXCELL DMT 2.0
 * These Scripts are Copyright by zgWebSolutions 2017+
 * Any Alteration of these Codes will result in a violation of the legal use of this software
 * and result in Legal Action from zgWebSolutions against the violators.
 */
if (!defined('App')) { die('Illegal Access'); }

class Core
{
    public static function GetSimple($objCoreData, $strMySqlQuery, $strColumnSort = null)
    {
        mysqli_report(MYSQLI_REPORT_STRICT);

        if ( empty($strMySqlQuery))
        {
            return array(
                'Result' => array(
                    "success" => false,
                    "rows"    => 0,
                    "message" => 'Empty query string passed in',
                    "trace" => zgTrace()
                )
            ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
        }

        try
        {
            $objZgXlDb = new mysqli($objCoreData["Database"]['Host'], $objCoreData["Database"]['User'], $objCoreData["Database"]['Password'], $objCoreData["Database"]['Name']);

            if ( $objZgXlDb->connect_errno > 0 )
            {
                return array(
                    'Result' => array(
                        "success" => false,
                        "rows"    => 0,
                        "message" => 'There was an error connecting to the database [' . $objZgXlDb->error . ']',
                        "query" => $strMySqlQuery,
                        "trace" => zgTrace()
                    )
                ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
            }

            $objQueryResult = null;

            if ( !$objQueryResult = $objZgXlDb->query($strMySqlQuery) )
            {
                $strUpdateError = $objZgXlDb->error;

                $objZgXlDb->close();

                return array(
                    'Result' => array(
                        "success" => false,
                        "rows"    => 0,
                        "message" => 'There was an error running the query [' . $strUpdateError . ']',
                        "query" => $strMySqlQuery,
                        "trace" => zgTrace()
                    )
                );  // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
            }

            if ( $objQueryResult->num_rows == 0 )
            {
                $objZgXlDb->close();

                return array(
                    'Result' => array(
                        "success" => true,
                        "rows"    => 0,
                        "message" => "No rows found.",
                        "query" => $strMySqlQuery,
                        "trace" => zgTrace()
                    )
                ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
            }

            $objQueryResultArray = array();
            $objQueryResultArray['Data'] = array();

            if ( !empty($strColumnSort) )
            {
                while ( $objQueryResultDataset = $objQueryResult->fetch_assoc() )
                {
                    $objQueryResultArray['Data'][$objQueryResultDataset[$strColumnSort]] = $objQueryResultDataset;
                }
            }
            else
            {
                while ( $objQueryResultDataset = $objQueryResult->fetch_assoc() )
                {
                    $objQueryResultArray['Data'][] = $objQueryResultDataset;
                }
            }

            $objZgXlDb->close();

            $intResultCount = count($objQueryResultArray);

            $objQueryResultArray['Result'] = array(
                "success" => true,
                "rows"    => $intResultCount,
                "message" => "This query ran successfully"
            );

        }
        catch(Exception $ex)
        {
            if (!empty($objZgXlDb))
            {
                $strUpdateError = $objZgXlDb->error;
                $objZgXlDb->close();
            }
            else
            {
                $strUpdateError = $ex->getMessage();
            }

            return array(
                'Result' => array(
                    "success" => false,
                    "rows"    => 0,
                    "message" => "An error has occurred: ". $strUpdateError,
                    "query" => $strMySqlQuery,
                    "trace" => zgTrace()
                )
            ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
        }
        return $objQueryResultArray;
    }

    public static function GetComplex($objCoreData, $strMySqlQuery, $strJsonColumn = 'data', $strJsonOutput = 'jsondata', $strColumnSort = '')
    {
        if ( ( is_array($strJsonColumn) && !is_array($strJsonOutput) ) || ( !is_array($strJsonColumn) && is_array($strJsonOutput) ) )
        {
            return array(
                'Result' => array(
                    "success" => false,
                    "rows"    => 0,
                    "message" => 'JSON Column or Output should be either both arrays or both strings',
                    "trace" => zgTrace()
                )
            ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
        }

        if ( ( is_array($strJsonColumn) && is_array($strJsonOutput) ) && count($strJsonColumn) != count($strJsonOutput)  )
        {
            return array(
                'Result' => array(
                    "success" => false,
                    "rows"    => 0,
                    "message" => 'JSON Column or Output need to be equal length arrays or both strings',
                    "trace" => zgTrace()
                )
            ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
        }

        $objQueryResultArray = self::GetSimple($objCoreData, $strMySqlQuery, $strColumnSort);

        if ( $objQueryResultArray["Result"]["success"] != true || $objQueryResultArray["Result"]["rows"] == 0 )
        {
            return $objQueryResultArray;
        }

        foreach ( $objQueryResultArray["Data"] as $key => $da )
        {
            if ( !is_array($strJsonOutput) )
            {
                $objJsonDecodedObject = json_decode($da[$strJsonColumn], true);

                $objQueryResultArray["Data"][$key][$strJsonOutput] = self::UnBase64Encode($objJsonDecodedObject);

                if ($strJsonColumn != $strJsonOutput)
                {
                    unset($objQueryResultArray["Data"][$key][$strJsonColumn]);
                }
            }
            else
            {
                $intJsonColumnCount = count($strJsonOutput);

                for ( $currJsonColumnIndex = 0; $currJsonColumnIndex < $intJsonColumnCount; $currJsonColumnIndex++ )
                {
                    $objJsonDecodedObject = json_decode($da[$strJsonColumn[$currJsonColumnIndex]], true);

                    $objQueryResultArray["Data"][$key][$strJsonOutput[$currJsonColumnIndex]] = self::UnBase64Encode($objJsonDecodedObject);

                    if ($strJsonColumn != $strJsonOutput)
                    {
                        unset($objQueryResultArray["Data"][$key][$strJsonColumn[$currJsonColumnIndex]]);
                    }
                }
            }
        }

        return $objQueryResultArray;
    }

    public static function Update($objCoreData, $strMySqlQuery)
    {

        if (empty($strMySqlQuery))
        {
            return array(
                'Result' => array(
                    "success" => false,
                    "rows" => 0,
                    "message" => 'Empty query string passed in.',
                    "trace" => zgTrace()
                )
            ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
        }

        mysqli_report(MYSQLI_REPORT_STRICT);

        try
        {

            $objZgXlDb = new mysqli($objCoreData["Database"]['Host'], $objCoreData["Database"]['User'], $objCoreData["Database"]['Password'], $objCoreData["Database"]['Name']);

            if ( $objZgXlDb->connect_errno > 0 )
            {
                $strUpdateError = $objZgXlDb->error;

                $objZgXlDb->close();

                return array(
                    'Result' => array(
                        "success" => false,
                        "rows" => 0,
                        "message" => 'There was an error connecting to the database [' . $strUpdateError . ']',
                        "trace" => zgTrace()
                    )
                ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
            }

            $objQueryResult = null;

            if ( ! $objQueryResult = $objZgXlDb->query($strMySqlQuery) )
            {
                $strUpdateError = $objZgXlDb->error;

                $objZgXlDb->close();

                return array(
                    'Result' => array(
                        "success" => false,
                        "rows" => 0,
                        "message" => 'There was an error updating the database [' . $strUpdateError . ']',
                        "query" => $strMySqlQuery,
                        "trace" => zgTrace()
                    )
                );  // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
            }

            $objZgXlDb->close();

            $objQueryResultArray = array();

            $objQueryResultArray['Result'] = array(
                "success"=> true,
                "rows" => 0,
                "message" => "This query ran successfully"
            );

            $objQueryResultArray['Data'] = null;

            return $objQueryResultArray;
        }
        catch(Exception $ex)
        {
            $strUpdateError = $objZgXlDb->error;

            $objZgXlDb->close();

            return array(
                'Result' => array(
                    "success" => false,
                    "rows"    => 0,
                    "message" => "An error has occurred: " . $strUpdateError,
                    "query" => $strMySqlQuery,
                    "trace" => zgTrace()
                )
            ); // $array[1] == 'Error-ID'; $array[2] == 'Error-Text'
        }
    }

    public static function UnBase64Encode($ay)
    {
        $temp_array =  array();

        if ( is_array($ay) )
        {
            foreach ($ay as $ky => $dy )
            {
                if ( is_array($dy) )
                {
                    $temp_array[$ky] = self::UnBase64Encode($dy);
                }
                else
                {
                    $temp_array[$ky] = base64_decode($dy);
                }
            }
        }
        else
        {
            $temp_array = array( 'zgError', 'X', 'This Datafield was not an array.' );
        }

        return $temp_array;
    }

    public static function Base64Encode($ay)
    {
        $temp_array =  array();

        if ( is_array($ay) )
        {
            foreach ($ay as $ky => $dy )
            {
                if ( is_array($dy) )
                {
                    $temp_array[$ky] = self::Base64Encode($dy);
                }
                else
                {
                    $temp_array[$ky] = base64_encode($dy);
                }
            }
        }
        else
        {
            $temp_array = array( 'zgError', 'X', 'This Datafield was not an array.' );
        }

        return $temp_array;
    }

    public static function ForceUtf8( $str, $inputEnc='WINDOWS-1252' )
    {
        $objChunkedString = str_split($str,1);
        $strNewString = "";

        foreach($objChunkedString as $strIndividualCharacter)
        {
            $intAsciiNumber = ord($strIndividualCharacter);
            // Remove non-ascii & non html characters
            if ( ( $intAsciiNumber >= 32 && $intAsciiNumber <= 123 ) || $intAsciiNumber == 160 )
            {
                if ( $intAsciiNumber == 160 )
                {
                    $strNewString .= chr(32);
                }
                else
                {
                    $strNewString .= $strIndividualCharacter;
                }
            }
        }

        return $strNewString;
    }
}