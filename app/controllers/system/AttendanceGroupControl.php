<?php

namespace Application\controllers\system;

use ActiveTypes;
use Application\abstracts\ControlDefaultFunctions;
use Application\models\AttendanceGroup;

class AttendanceGroupControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = AttendanceGroup::class;
    protected $TABLE_NAME = "attendance_groups";
    protected $TABLE_PRIMARY_ID = "attendance_group_id";
    protected $SEARCH_LOOKUP = ["attendance_group_id", "year", "period", [
        "table" => "clients",
        "primary" => "client_id",
        "into" => ['name', 'branch']]];

    protected $CATEGORY = \ActivityLogCategories::ATTENDANCE_GROUP;


    public $FILTER_LOOKUP = [];

    public function getAllPeriodsWhereEmployeeEmployed($employee_id, $options = [])
    {
        global $CONNECTION;


        if (count($options) > 0) {
            if (is_null($options['year'])) {
                unset($options['year']);
            }

            if (is_null($options['period'])) {
                unset($options['period']);
            }
        }

        $condition = $CONNECTION->ConditionToQ($options, " AND ");

        $condition = empty($condition) ? "" : " AND " . $condition;

        $query = "SELECT DISTINCT(a.period) as temp, a.*  FROM `attendance_groups` as a WHERE a.year IN (SELECT DISTINCT(b.year) FROM attendance_groups as b WHERE b.client_id IN (SELECT c.client_id FROM deployed_employees as c WHERE c.employment_id IN (SELECT d.employment_id FROM employments as d WHERE d.employee_id = '". $employee_id ."'))) " . $condition;

        $results = $CONNECTION->query($query, true);

        return $this->NewArrayInstance($results, true);
    }

    public function edit($id, $record) {
        $edit = $this->editRecord($id, $record);

        if ($edit->code === 200) {
            if ($record['active'] == ActiveTypes::ACTIVE->value) {
                $this->unsetOtherAsUnActive($id);
            }
        }
    }

    private function unsetOtherAsUnActive($id)
    {
        $record = $this->get($id, true);
        $clientID = $record->client_id;

        $this->editRecordWhereMulticonditinal([['client_id', '=', $clientID], ['attendance_group_id', '!=', $id]], ['active' => ActiveTypes::NOT_ACTIVE->value]);
    }

    public function getTableName()
    {
        return $this->TABLE_NAME;
    }
}




