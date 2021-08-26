<?php

namespace Entities\Tickets\Classes\Journey;

use App\Core\AppEntity;
use App\Utilities\Database;
use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Transaction\ExcellTransaction;
use Entities\Tickets\Models\JourneyModel;

class Journeys extends AppEntity
{
    public $strEntityName       = "Tickets";
    public $strDatabaseTable    = "journey";
    public $strDatabaseName     = "Crm";
    public $strMainModelName    = JourneyModel::class;
    public $strMainModelPrimary = "journey_id";

    public function __construct()
    {
        parent::__construct();
    }

    public function getFullJourneyById($journeyId) : ExcellTransaction
    {
        $journey = $this->getRecursiveJourneysByIds([$journeyId]);

        return new ExcellTransaction(($journey->Count() === 1), "Success.", $journey);
    }

    private function getRecursiveJourneysByIds($journeyIds) : ExcellCollection
    {
        $objWhereClause = "
            SELECT jny.*,
            (SELECT COUNT(*) FROM `ezdigital_v2_crm`.`journey` jny2 WHERE jny2.parent_id = jny.journey_id) AS child_journey_count,
            (SELECT GROUP_CONCAT(jny2.journey_id) FROM `ezdigital_v2_crm`.`journey` jny2 WHERE jny2.parent_id = jny.journey_id) AS child_journey_ids
            FROM `ezdigital_v2_crm`.`journey` jny ";

        $objWhereClause .= "WHERE jny.journey_id IN (".implode(",", $journeyIds).")";

        $journeyResult = Database::getSimple($objWhereClause, "journey_id");
        $journeyResult->Data->HydrateModelData(JourneyModel::class, true);

        if ($journeyResult->Result->Count === 0)
        {
            return new ExcellCollection();
        }

        $journeyResult->Data->Foreach(function($currJourney)
        {
            if ($currJourney->child_journey_count === 0) { return; }

            $currJourney->AddUnvalidatedValue("children", $this->getRecursiveJourneysByIds(explode(",", $currJourney->child_journey_ids)));

            return $currJourney;
        });

        return $journeyResult->Data;
    }
}