<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\controllers\app\Response;
use Application\models\Attendance;

class AttendanceControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = Attendance::class;
    protected $TABLE_NAME = "attendance";
    protected $TABLE_PRIMARY_ID = "attendance_id";
    protected $SEARCH_LOOKUP = [];

    protected $CATEGORY = \ActivityLogCategories::ATTENDANCE;

    public function add($client_id, $data) {
        global $ACTIVITY_CONTROL, $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->CLIENT_CONTROL;
        $holidayControl = $APPLICATION->FUNCTIONS->CLIENT_HOLIDAY_CONTROL;

        $client = $control->get($client_id, true);
        $holidays = $holidayControl->filterRecords(['client_id' => $client_id], true);

        try {
            foreach ($data as $attendance) {
                $status = $attendance['status'];
                $id = $attendance['id'];

                unset($attendance['status'], $attendance['id']);

                // add
                if ($status === 222) {
                    $this->addRecord($attendance);

                    // update
                } else if ($status === 333) {
                    $this->editRecord($id, $attendance);
                }
            }

            $ACTIVITY_CONTROL->insert($this->CATEGORY, \ActivityLogActionTypes::MODIFY, 200);

            return new Response(200, "Successfully Saved");
        } catch (\Exception $e) {
            $ACTIVITY_CONTROL->insert($this->CATEGORY, \ActivityLogActionTypes::MODIFY, 204);

            return new Response(204, "Failed to Save!");
        }
    }
}