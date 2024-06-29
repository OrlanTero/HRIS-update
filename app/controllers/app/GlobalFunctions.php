<?php

namespace Application\controllers\app;


use Application\controllers\system\AdjustmentControl;
use Application\controllers\system\AttendanceControl;
use Application\controllers\system\AttendanceGroupControl;
use Application\controllers\system\BankControl;
use Application\controllers\system\BeneficiaryControl;
use Application\controllers\system\ClientController;
use Application\controllers\system\ClientHolidayControl;
use Application\controllers\system\DeployedEmployeeControl;
use Application\controllers\system\DisbursementControl;
use Application\controllers\system\EmploymentControl;
use Application\controllers\system\HolidayControl;
use Application\controllers\system\LoanControl;
use Application\controllers\system\LoanPaymentControl;
use Application\controllers\system\MortuaryControl;
use Application\controllers\system\EmployeeControl;

use Application\controllers\system\PayslipControl;
use Application\controllers\system\PayslipRatesControl;
use Application\controllers\system\PettyCashControl;
use Application\controllers\system\PettyCashReportControl;
use Application\controllers\system\RequisitionControl;
use Application\controllers\system\RequisitionInfoControl;
use Application\controllers\system\ServiceDeductionControl;
use Application\controllers\system\SystemTypeControl;
use BankAccountControl;
use PostControl;

class GlobalFunctions
{
    protected $CONNECTION;
    protected $KLEIN;
    protected $SESSION;
    public $isAdmin;


    public $EMAIL_CONTROL;
    public $POST_CONTROL;

    public $EMPLOYEE_CONTROL;

    public $EMPLOYMENT_CONTROL;

    public $BANK_ACCOUNT_CONTROL;

    public $MORTUARY_CONTROL;

    public $BENEFICIARY_CONTROL;

    public $CLIENT_CONTROL;

    public $DEPLOYED_EMPLOYEE_CONTROL;

    public $SYSTEM_TYPES_CONTROL;

    public $SERVICE_DEDUCTION_CONTROL;

    public $HOLIDAY_CONTROL;

    public $CLIENT_HOLIDAY_CONTROL;

    public $ATTENDANCE_GROUP_CONTROL;

    public $ATTENDANCE_CONTROL;

    public $BANK_CONTROL;

    public $PETTYCASH_CONTROL;

    public $REQUISITION_CONTROL;

    public $DISBURSEMENT_CONTROL;

    public $ADJUSTMENT_CONTROL;

    public $REQUISITION_INFO_CONTROL;

    public $LOAN_CONTROL;

    public $LOAN_PAYMENT_CONTROL;

    public $PAYSLIP_CONTROL;

    public $PETTY_CASH_REPORT_CONTROL;

    public $PAYSLIP_RATES_CONTROL;

    public function __construct($SESSION)
    {
        global $CONNECTION;
        global $KLEIN;

        $this->SESSION = $SESSION;
        $this->CONNECTION = $CONNECTION;
        $this->KLEIN = $KLEIN;
        $this->isAdmin = $SESSION->isAdmin;

        $this->EMAIL_CONTROL = new EmailControl();
        $this->POST_CONTROL = new PostControl();
        $this->EMPLOYEE_CONTROL = new EmployeeControl();
        $this->BANK_ACCOUNT_CONTROL = new BankAccountControl();
        $this->MORTUARY_CONTROL = new MortuaryControl();
        $this->BENEFICIARY_CONTROL = new BeneficiaryControl();
        $this->EMPLOYMENT_CONTROL = new EmploymentControl();
        $this->CLIENT_CONTROL = new ClientController();
        $this->DEPLOYED_EMPLOYEE_CONTROL = new DeployedEmployeeControl();
        $this->SYSTEM_TYPES_CONTROL = new SystemTypeControl();
        $this->SERVICE_DEDUCTION_CONTROL = new ServiceDeductionControl();
        $this->HOLIDAY_CONTROL = new HolidayControl();
        $this->ATTENDANCE_GROUP_CONTROL  = new AttendanceGroupControl();
        $this->ATTENDANCE_CONTROL = new AttendanceControl();
        $this->BANK_CONTROL = new BankControl();
        $this->PETTYCASH_CONTROL = new PettyCashControl();
        $this->REQUISITION_CONTROL = new RequisitionControl();
        $this->DISBURSEMENT_CONTROL = new DisbursementControl();
        $this->ADJUSTMENT_CONTROL = new AdjustmentControl();
        $this->REQUISITION_INFO_CONTROL = new RequisitionInfoControl();
        $this->LOAN_CONTROL = new LoanControl();
        $this->LOAN_PAYMENT_CONTROL = new LoanPaymentControl();
        $this->PAYSLIP_CONTROL = new PaySlipControl();
        $this->PETTY_CASH_REPORT_CONTROL = new PettyCashReportControl();
        $this->PAYSLIP_RATES_CONTROL = new PayslipRatesControl();
        $this->CLIENT_HOLIDAY_CONTROL = new ClientHolidayControl();
    }
}