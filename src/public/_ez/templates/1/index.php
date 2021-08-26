<?php
/**
 * ENGINECORE _site_core Extention for zgWeb.Solutions Web.CMS.App
 */

if ($app->getActiveLoggedInUser()->user_id === 1000)
{
    require PublicData . "_ez/index.php";
}
else
{
    require PublicData . "_ez/templates/1/oldTemplate.php";
}

?>