<?php

use Application\controllers\system\ClientController;
use Application\controllers\system\EmployeeControl;
use Application\controllers\system\EmploymentControl;
use Application\controllers\system\RequisitionControl;
use Application\controllers\system\SystemTypeControl;

$EMPLOYEES_TABLE_HEADER_TEXT = ["No", "Emp No", "Name", "Gender", "Address", "Tel", "Mobile","Email"];
$EMPLOYEES_TABLE_BODY_KEY = ["no", "employee_no",array(
    "primary" => "employee_id",
    "controller" => EmployeeControl::class,
    "value" => "name"
), "gender", "address", "telephone", "mobile", "email"];

$EMPLOYMENT_TABLE_HEADER_TEXT = ["No", "Date From", "Date To", "Employee", "Position", "Department", "Type","Status", "Active"];
$EMPLOYMENT_TABLE_BODY_KEY = ["no", "date_hired","date_end", array(
    "primary" => "employee_id",
    "controller" => EmployeeControl::class,
    "value" => "name"
), "position", "department", "e_type", "status", [
    "enum" => array_column(ActiveTypes::cases(), 'name'),
    "value" => "active"
]];

$MORTUARY_TABLE_HEADER_TEXT = ["No", "Date Created", "Period", "Year"];
$MORTUARY_TABLE_BODY_KEY = ["no", "date_created","period", "year"];

$CLIENT_TABLE_HEADER_TEXT = ["No", "Name", "Branch", "Date Created"];
$CLIENT_TABLE_BODY_KEY = ["no", "name","branch", "date_created"];

$BANKS_TABLE_HEADER_TEXT = ["No", "Name", "Branch", "Date Created"];
$BANKS_TABLE_BODY_KEY = ["no", "name","branch", "date_created"];

$DEPLOYMENT_TABLE_HEADER_TEXT = ["No", "Date From", "Date To", "Employee"];
$DEPLOYMENT_TABLE_BODY_KEY = ["no", "date_from","date_to", [
    "primary" => "employment_id",
    "controller" => EmploymentControl::class,
    "value" => ["employee", "name"]
]];

$ADJUSTMENTS_TABLE_HEADER_TEXT = ["No", "Date", "Employee", "Posted", "Paid", "Amount"];
$ADJUSTMENTS_TABLE_BODY_KEY = ["adjustment_id","date", [
    "primary" => "employee_id",
    "controller" => EmployeeControl::class,
    "value" =>  "name"
], [
    "enum" => array_column(PostedTypes::cases(), 'name'),
    "value" => "posted"
],[
    "enum" => array_column(PaidTypes::cases(), 'name'),
    "value" => "paid"
],"amount"];

$BENEFICIARIES_TABLE_HEADER_TEXT = ["No", "Employee", "Type", "Name"];
$BENEFICIARIES_TABLE_BODY_KEY = ["no", ["primary" => "employee_id",
    "controller" => EmployeeControl::class,
    "value" => "name"], "type", "name"];

$EMPLOYMENT_ACCOUNT_TABLE_HEADER_TEXT = ["No", "Client", "Branch", "Basic Pay"];
$EMPLOYMENT_ACCOUNT_TABLE_BODY_KEY = [];

$NO_TYPE_TABLE_HEADER_TEXT = ["No", "Type"];
$NO_TYPE_TABLE_BODY_KEY = ["no", "type"];

$SERVICES_DEDUCTION_TABLE_HEADER_TEXT = ["No", "From", "To", "MSC", "ER", "EE"];
$SERVICES_DEDUCTION_TABLE_BODY_KEY = ["no", "price_from", "price_to", "msc", "er", "ee"];

$HOLIDAYS_TABLE_HEADER_TEXT = ["No", "Date", "Holiday"];
$HOLIDAYS_TABLE_BODY_KEY = ["no", "holiday_date", "holiday"];

$PER_CLIENT_TABLE_HEADER_TEXT = ["No", "Period","Year", "Client", "Branch", "Total"];
$PER_CLIENT_TABLE_BODY_KEY = ["no", "period", "year", "client", "branch", "total"];

$NETPAYS_TABLE_HEADER_TEXT = ["No", "Client", "Branch", "Amount"];
$NETPAYS_TABLE_BODY_KEY = ["no", "client", "branch", "amount"];

$LOAN_ITEM_TABLE_HEADER_TEXT = ["No", "Employee", "Description", "Amount", "Balance", "Type", "Status", "Date"];
$LOAN_ITEM_TABLE_BODY_KEY = ["no", [
    "primary" => "employee_id",
    "controller" => EmployeeControl::class,
    "value" =>  "name"
], "description", "amount", "balance", [
    "primary" => "loan_type",
    "controller" => SystemTypeControl::class,
    "value" =>  "type"
], "status", "date_created"];

$LOAN_PAYMENT_TABLE_HEADER_TEXT = ["No", "Employee", "To Pay", "Pay", "Note", "Date"];
$LOAN_PAYMENT_TABLE_BODY_KEY = ["No", [
    "primary" => "employee_id",
    "controller" => EmployeeControl::class,
    "value" =>  "name"
], "to_pay", "amount", "note", "date_created"];

$ATTENDANCE_GROUP_TABLE_HEADER_TEXT = ["No", "Period", "Year", "Client", "Branch", "Active", "Finished", "Date Created"];
$ATTENDANCE_GROUP_BODY_KEY = ["no", "period", "year", [
    "primary" => "client_id",
    "controller" => ClientController::class,
    "value" => "name"
],
    [
    "primary" => "client_id",
    "controller" => ClientController::class,
    "value" => "branch"
], [
    "enum" => array_column(ActiveTypes::cases(), 'name'),
    "value" => "active"
    ],
    [
        "enum" => array_column(FinishedTypes::cases(), 'name'),
        "value" => "finished"
    ], "date_created"];


// ALL FINANCIAL

$PAYROLL_TABLE_HEADER_TEXT = ["No", "Name", "Days Worked","Rest Day", "BASIC PAY", "NSD", "NSD(BP)", "NHW(SH)", "SH(BP)", "NHW(SHOT)", "SHOT(BP)", "NHW(LH)","LH(BP)","NHW(LHOT)","LHOT(BP)","Gross Pay", "SSS", "PHIL", "INSURANCE", "P1", "Death", "Pag-Ibig", "P2","P3", "Net Pay"];
$PAYROLL_TABLE_BODY_KEY = ["no", "name", "ndw","rest_day", "basic_pay", "nsd", "nsd_basic_pay", "nhw_sh", "sh_basic_pay", "nhw_shot", "shot_basic_pay","nhw_lh","lh_basic_pay","nhw_lhot","lhot_basic_pay", "gross_pay", "sss", "phil", "insurance", "part1", "death", "pagibig", "part2","others", "netpay"];

$REQUISITION_TABLE_HEADER_TEXT = ["No", "Req#", "Date", "Remarks","Status", "Amount"];
$REQUISITION_TABLE_BODY_KEY = ["no", "req_id", "req_date", "remarks","status",  [
    "primary" => "requisition_id",
    "controller" => RequisitionControl::class,
    "value" => "amount"
]];

$REQUISITION_EXPENSES_LESS_TABLE_HEADER_TEXT = ["No", "Particulars", "Type", "Basic Unit", "Qty", "Unit Price", "Amount"];
$REQUISITION_EXPENSES_LESS_TABLE_BODY_KEY = ["no", "particulars", "type", "basic_unit", "quantity", "unit_price", "amount"];

$DISBURSEMENT_TABLE_HEADER_TEXT = ["No", "Date", "Voucher #", "Payments", "Paid To", "Type", "Posted", "Cancelled", "Amount"];
$DISBURSEMENT_TABLE_BODY_KEY = ["no", "date", "voucher", "payments", "paid_to", "type", [
    "enum" => array_column(PostedTypes::cases(), 'name'),
    "value" => "posted"
],[
    "enum" => array_column(CancelledTypes::cases(), 'name'),
    "value" => "cancelled"
], "amount"];

$COLLECTION_TABLE_HEADER_TEXT = ["No", "Date", "Receipt #", "Payment", "User", "Posted","Amount"];
$COLLECTION_TABLE_BODY_KEY = ["no", "date", "receipt", "payment", "user",[
    "enum" => array_column(PostedTypes::cases(), 'name'),
    "value" => "posted"
],  "amount"];

$PETTYCASH_TABLE_HEADER_TEXT = ["No", "Date", "Requested By", "Remarks", "Posted","Amount"];
$PETTYCASH_TABLE_BODY_KEY = ["no", "date", "requested_by", "remarks",[
    "enum" => array_column(PostedTypes::cases(), 'name'),
    "value" => "posted"
],  "amount"];

$CLIENT_HOLIDAY_TABLE_HEADER_TEXT = ["No", "Date", "Holiday"];
$CLIENT_HOLIDAY_TABLE_BODY_KEY = ["no", "date", "holiday"];

$LOAN_MANAGER_TABLE_HEADER_TEXT = ["No","Employee", "Date", "Description","Times", "Status", "Principal", "Previous", "Forward", "Payments", "Received", "Bal"];
$LOAN_MANAGER_TABLE_BODY_KEY = ["no","employee", "date", "description", "times","status","principal", "previous", "forward", "payments", "recieved", "balance"];

$LOAN_TABLE_HEADER_TEXT = ["No", "Description", "Amount","Balance", "Loan Type", "Status", "Date"];
$LOAN_TABLE_BODY_TEXT = ["no", "description", "amount","balance", "loan_type", "status", "date_created"];

$ACTIVITY_LOG_HEADER_TEXT = ["No","User", "Category", "Action", "Status", "Message", "Related ID"];
$ACTIVITY_LOG_BODY_TEXT = ["no", "user", [
    "enum" => array_column(ActivityLogCategories::cases(), 'name'),
    "value" => "category"
], [
    "enum" => array_column(ActivityLogActionTypes::cases(), 'name'),
    "value" => "action"
], [
    "enum" => array_column(ActivityLogStatus::cases(), 'name'),
    "value" => "status"
], "message", "id"];

// REPORTS

$REPORTS_MORTUARY_HEADER = ["NO", "EMPLOYEE", "AMOUNT"];
$REPORTS_MORTUARY_BODY = ["no", "employee", "amount"];

$REPORTS_PETTY_HEADER = ["NO", "DATE", "VOUCHER #", "TYPE", "REMARKS", "IN", "OUT"];
$REPORTS_PETTY_BODY = ["no", "date", "voucher", "type", "remarks", "in", "out"];


// OTHERS

//$GENDERS = ["Male", "Female"];
$GENDERS = array_column(GenderType::cases(), 'value');

//$CIVIL_STATUS = ["Single", "Married", "Widowed"];
$CIVIL_STATUS = array_column(CivilStatusTypes::cases(), 'value');

//$DEPARTMENTS = ["Field", "Office"];
$DEPARTMENTS = array_column(DepartmentTypes::cases(), 'value');

//$EMPLOYMENT_STATUS = ["Contractual", "Probationary", "Regular", "Resigned"];
$EMPLOYMENT_STATUS = array_column(EmploymentStatus::cases(), 'value');

//$EMPLOYMENT_TYPES = ["Field", "Staff"];

$EMPLOYMENT_TYPES = array_column(EmploymentTypes::cases(), 'value');
//$EMPLOYMENT_POSITIONS = ["Administrator", "Cashier", "General Services", "Head Guard", "IT Consultant", "Payroll Officer", "Security Guard"];

//$POSTED_VALUES = ["POSTED", "NOT POSTED"];
$POSTED_VALUES = array_column(PostedTypes::cases(), 'name');

$CANCELLED_VALUES = array_column(CancelledTypes::cases(), 'name');

$PAID_VALUES = array_column(PaidTypes::cases(), 'name');

$REGION_VALUES = array_column(RegionTypes::cases(), 'value');

$ACTIVE_VALUES = array_column(ActiveTypes::cases(), 'name');

$FINISHED_VALUES = array_column(FinishedTypes::cases(), 'name');

$PAYMENTS_VALUES = array_column(PaymentType::cases(), 'value');

$VAT_VALUES = array_column(VatType::cases(), 'value');

$NONVAT_VALUES = array_column(NonVatType::cases(), 'value');

$BASIC_VALUES = array_column(BasicUnitType::cases(), 'value');

$EMPLOYMENT_POSITIONS = array_column(EmploymentPositionTypes::cases(), 'value');

//$RESTDAYS = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

$RESTDAYS = array_column(RestDayTypes::cases(), 'value');

//$ATTENDANCE_TYPES = ["Regular", "OT", "Night Diff", "Legal Holiday", "Special Holiday", "Rest Day", "Legal Holiday OT", "Special Holiday OT"];

$ATTENDANCE_TYPES = array_column(AttendanceTypes::cases(), 'value');

$BENEFICIARY_TYPES = array_column(BeneficiaryTypes::cases(), 'value');


