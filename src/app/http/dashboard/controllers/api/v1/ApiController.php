<?php

namespace Entities\Dashboard\Controllers\Api\V1;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Models\CardModel;
use Entities\Dashboard\Classes\Base\DashboardController;
use Entities\Payments\Classes\ArInvoices;

class ApiController extends DashboardController
{
    public function getModuleData(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('GET'))
        {
            return false;
        }

        $objParams = $objData->Data->Params;

        if (!$this->validate($objParams, [
            "uuid" => "required|uuid",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $widgets = [];

        if (isset($objParams["widgets"]))
        {
            $addons = explode("|", $objParams["widgets"]);
            foreach($addons as $currAddon)
            {
                $widgets[$currAddon] = $this->loadWidgetData($currAddon, $objParams["uuid"]);
            }
        }

        return $this->renderReturnJson(true, ["widgets" => $widgets], "We made it.");
    }

    protected function loadWidgetData($widgetId, $userUuid) : array
    {
        switch($widgetId)
        {
            case "transactions":
                return $this->loadTransactionWidgetData($userUuid);
            case "contacts":
                return $this->loadContactsWidgetData($userUuid);
            case "shares":
                return $this->loadSharesWidgetData($userUuid);
            case "visitors":
                return $this->loadVisitorsWidgetData($userUuid);
        }
    }

    protected function loadTransactionWidgetData() : array
    {
        $arInvoiceResults = null;

        $beginningOfYear = date("Y-01-01 00:00:00");
        $beginningOfMonth = date("Y-m-01 00:00:00");
        $currentMonth = date("m");
        $widgets = [];
        $objWhereClause = "";

//        if (userCan("manage-platforms"))
//        {
//            $objWhereClause = "SELECT SUM(gross_value) as total_gross FROM `ezdigital_v2_financial`.`ar_invoice` WHERE created_on > '{$beginningOfYear}'";
//            $arInvoiceResults = Database::getSimple($objWhereClause, "gross_value");
//        }
        if (userCan("manage-system"))
        {
            $objWhereClause = "SELECT SUM(gross_value) as total_gross, (SELECT SUM(gross_value) FROM `ezdigital_v2_financial`.`ar_invoice` WHERE company_id = " . $this->app->objCustomPlatform->getCompanyId() . " AND created_on > '{$beginningOfMonth}') as last_month FROM `ezdigital_v2_financial`.`ar_invoice` WHERE company_id = " . $this->app->objCustomPlatform->getCompanyId() . " AND created_on > '{$beginningOfYear}'";
            $arInvoiceResults = Database::getSimple($objWhereClause, "gross_value");
        }
        elseif (userCan("view-card-purchases"))
        {
            $objWhereClause = "SELECT SUM(gross_value) as total_gross FROM `ezdigital_v2_financial`.`ar_invoice` WHERE user_id = " . $this->app->getActiveLoggedInUser()->getId() . " AND created_on > '{$beginningOfYear}'";
            $arInvoiceResults = Database::getSimple($objWhereClause, "gross_value");
        }

        $widgets["gross_month"] = $arInvoiceResults->Data->First()->total_gross;
        $widgets["last_month"] = $arInvoiceResults->Data->First()->last_month;
        $widgets["avg_month"] = $arInvoiceResults->Data->First()->total_gross / $currentMonth;

        return $widgets;
    }

    protected function loadContactsWidgetData(): array
    {
        $arContactsResults = null;

        $beginningOfMonth = date("Y-01-01 00:00:00");
        $widgets = [];

//        if (userCan("manage-platforms"))
//        {
//            $objWhereClause = "SELECT COUNT(*) as total_contacts FROM `ezdigital_v2_main`.`mobiniti_contact` mc LEFT JOIN `ezdigital_v2_main`.`mobiniti_contact_user_rel` mcur ON mcur.mobiniti_contact_id = mc.id LEFT JOIN `ezdigital_v2_main`.`user` ur ON ur.user_id = mcur.user_id";
//            $arContactsResults = Database::getSimple($objWhereClause, "gross_value");
//        }
        if (userCan("manage-system"))
        {
            $objWhereClause = "SELECT COUNT(*) as total_contacts FROM `ezdigital_v2_main`.`mobiniti_contact` mc LEFT JOIN `ezdigital_v2_main`.`mobiniti_contact_user_rel` mcur ON mcur.mobiniti_contact_id = mc.id LEFT JOIN `ezdigital_v2_main`.`user` ur ON ur.user_id = mcur.user_id WHERE mc.company_id = " . $this->app->objCustomPlatform->getCompanyId() . "";
            $arContactsResults = Database::getSimple($objWhereClause, "gross_value");
        }
        elseif (userCan("view-card-purchases"))
        {
            $objWhereClause = "SELECT COUNT(*) as total_contacts FROM `ezdigital_v2_main`.`mobiniti_contact` mc LEFT JOIN `ezdigital_v2_main`.`mobiniti_contact_user_rel` mcur ON mcur.mobiniti_contact_id = mc.id WHERE mcur.user_id = " . $this->app->getActiveLoggedInUser()->getId() . "";
            $arContactsResults = Database::getSimple($objWhereClause, "gross_value");
        }

        $widgets["total_contacts"] = $arContactsResults->Data->First()->total_contacts;

        return $widgets;
    }

    protected function loadSharesWidgetData() : array
    {
        return [];
    }

    protected function loadVisitorsWidgetData() : array
    {
        return [];
    }

    public function socketListen(ExcellHttpModel $objData) : bool
    {
        $cardResult = (new Cards())->getByUuid($objData->Data->Params["_"]);

        if ($cardResult->Result->Count !== 1)
        {
            return false;
        }

        $card = $cardResult->Data->First();

        // spin up socket

        // send socket URL back?

        $host = "127.0.0.1";

        $port = 9090;
        // No Timeout
        set_time_limit(0);

        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

        //$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");

        if (!socket_bind($socket, $host, $port)) {
            die('Unable to bind socket: '. socket_strerror(socket_last_error()) . PHP_EOL);
        }

        $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

        $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");

        $input = socket_read($spawn, 1024) or die("Could not read input\n");

        // clean up input string
        $input = trim($input);
        echo "Client Message : ".$input;

        // reverse client input and send back
        $output = strrev($input) . "\n";

        socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
        // close sockets

        socket_close($spawn);
        socket_close($socket);
    }
}