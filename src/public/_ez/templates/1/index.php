<?php
/**
 * ENGINECORE _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

if ($app->getActiveLoggedInUser()->user_id === 1000)
{
    require PUBLIC_DATA . "_ez/index.php";
}
else
{
    require PUBLIC_DATA . "_ez/templates/1/oldTemplate.php";
}

?>