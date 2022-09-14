<?php

namespace Http\Emails\Controllers;

use App\Utilities\Excell\ExcellHttpModel;
use Http\Emails\Controllers\Base\EmailController;
use Entities\Emails\Classes\Emails;

class IndexController extends EmailController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        return true;
    }

    public function sendEmailTest(ExcellHttpModel $objData) : bool
    {
        (new Emails())->SendEmail(
            "EZcard Test <test@ezcard.com>",
            ["Micah Zak <micah@zakgraphix.com>"],
            "This is a test",
            "<p>Here is your password reset email.</p><p>Here is the details.</p>"
        );

        die("Done!");
    }

    public function sendEmailFromCard(ExcellHttpModel $objData) : bool
    {
        $objData->Data->PostData->email;
        $objData->Data->PostData->msg;
        $objData->Data->PostData->id;

        //$obj

        $strSubject = "";
        $strMessage = "";

        (new Emails())->SendEmail(
            "EZcard Test <test@ezcard.com>",
            ["Micah Zak <micah@zakgraphix.com>"],
            "This is a test",
            "<p>Here is your password reset email.</p><p>Here is the details.</p>"
        );
    }
}