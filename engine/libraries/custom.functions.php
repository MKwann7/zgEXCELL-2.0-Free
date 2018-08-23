<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

// Custom Escape String
function escapeString($str)
{
    $search = array("\\","\0","\n","\r","\x1a","'",'"');
    $replace = array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
    return str_replace($search,$replace,$str);
}

function zgPrint($array,$style = null,$left = '0px',$top = '0px')
{
    //if (!zgRoleCheck('Superadmin')) { return; }
    if ( $style == false ) {
        echo '<div class="zgPrint_div" style="left:'.$left.';top:'.$top.';">';
    }
    echo '<pre style="font-size:10px;line-height:12px;font-weight:bold;">';
    if ( is_array($array) || is_object($array) ) {
        print_r($array);
    } elseif ( is_string(strval($array)) || is_bool($array) ) {
        echo strval($array);
    } else {
        echo 'Blank Variable/Array';
    }
    echo '</pre>';
    if ( $style == false  ) {
        echo '</div>';
    }
}

function zgTrace()
{
    $e = new Exception();
    $trace = explode("\n", $e->getTraceAsString());
    // reverse array to make steps line up chronologically
    $trace = array_reverse($trace);
    array_shift($trace); // remove {main}
    array_pop($trace); // remove call to this method
    $length = count($trace);
    $result = array();

    for ($i = 0; $i < $length; $i++)
    {
        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
    }

    return "\t" . implode("\n\t", $result);
}

function isInteger($strInput)
{
    return(ctype_digit(strval($strInput)));
}

function isDateTime($strInput)
{
    if (empty($strInput))
    {
        return false;
    }

    $strDate = date('Y-m-d H:i:s', strtotime($strInput));

    return ( DateTime::createFromFormat('Y-m-d G:i:s', $strDate) !== FALSE);
}

function isDecimal( $strInput )
{
    return is_numeric( $strInput ) && floor( $strInput ) != $strInput;
}