<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\DeployedEmployee;

class DeployedEmployeeControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = DeployedEmployee::class;
    protected $TABLE_NAME = "deployed_employees";
    protected $TABLE_PRIMARY_ID = "deployed_employee_id";
    protected $SEARCH_LOOKUP = [];
    protected $CATEGORY = \ActivityLogCategories::EMPLOYEE_DEPLOYMENT;

    public function countDeployed()
    {
        global  $CONNECTION;

        $query = "SELECT DISTINCT (a.employment_id), a.* FROM employments as a";

        return count($CONNECTION->Query($query, true));
    }

    public function countNotDeployed()
    {
        global  $CONNECTION;

        $query = "SELECT a.* FROM employees as a WHERE a.employee_id NOT IN (SELECT b.employee_id FROM employments as b WHERE b.employment_id IN (SELECT c.employment_id FROM deployed_employees as c WHERE b.employment_id = c.employment_id))";

        return count($CONNECTION->Query($query, true));
    }
}