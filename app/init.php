<?php


// ALL MODULES
include_once "modules/Enumeration.php";
include_once "modules/Tool.php";
include_once "modules/AppResources.php";

// ALL MODEL ABSTRACTS
include_once "abstracts/ModelDefaultFunctions.php";
include_once "abstracts/ControlDefaultFunctions.php";
include_once "abstracts/UserAbstract.php";
include_once "abstracts/BeneficiaryAbstract.php";
include_once "abstracts/MortuaryAbstract.php";
include_once "abstracts/EmploymentAbstract.php";
include_once "abstracts/ClientAbstract.php";
include_once "abstracts/DeployedEmployeeAbstract.php";
include_once "abstracts/SystemTypeAbstract.php";
include_once "abstracts/EmployeeAbstract.php";
include_once "abstracts/BankAccountAbstract.php";
include_once "abstracts/ServiceDeductionAbstract.php";
include_once "abstracts/HolidayAbstract.php";
include_once "abstracts/AttendanceGroupAbstract.php";
include_once "abstracts/AttendanceAbstract.php";
include_once "abstracts/BankAbstract.php";
include_once "abstracts/PettycashAbstract.php";
include_once "abstracts/RequisitionAbstract.php";
include_once "abstracts/DisbursementAbstract.php";
include_once "abstracts/AdjustmentAbstract.php";
include_once "abstracts/RequisitioninfoAbstract.php";
include_once "abstracts/ClientholidayAbstract.php";
include_once "abstracts/LoanAbstract.php";
include_once "abstracts/LoanPaymentAbstract.php";
include_once "abstracts/PayrollComputationAbstract.php";
include_once "abstracts/LoanAnalyzedAbstract.php";
include_once "abstracts/UserAuthenticationAbstract.php";
include_once "abstracts/UserProfileAbstract.php";
include_once "abstracts/ActivityLogAbstract.php";
include_once "abstracts/PettyCashReportAbstract.php";
include_once "abstracts/PayslipRatesAbstract.php";

// ALL MODELS
include_once "models/User.php";
include_once "models/Employee.php";
include_once "models/BankAccount.php";
include_once "models/Beneficiary.php";
include_once "models/Mortuary.php";
include_once "models/Employment.php";
include_once "models/Client.php";
include_once "models/DeployedEmployee.php";
include_once "models/SystemType.php";
include_once "models/ServiceDeduction.php";
include_once "models/Holiday.php";
include_once "models/AttendanceGroup.php";
include_once "models/Attendance.php";
include_once "models/Bank.php";
include_once "models/Pettycash.php";
include_once "models/Requisition.php";
include_once "models/Disbursement.php";
include_once "models/Adjustment.php";
include_once "models/RequisitionInfo.php";
include_once "models/ClientHoliday.php";
include_once "models/Loan.php";
include_once "models/LoanPayment.php";
include_once "models/PayrollAnalyzer.php";
include_once "models/PayrollComputation.php";
include_once "models/LoanAnalyzed.php";
include_once "models/LoanAnalyzer.php";
include_once "models/UserAuthentication.php";
include_once "models/UserProfile.php";
include_once "models/ActivityLog.php";
include_once "models/PettyCashReport.php";
include_once "models/PayslipRates.php";

// APP CONTROLLERS
include_once "controllers/app/Response.php";
include_once "controllers/app/GlobalFunctions.php";
include_once "controllers/app/EmailControl.php";
//include_once "controllers/app/SMSControl.php";

// SYSTEM CONTROLLERS
//include_once "controllers/system/UserControl.php";
include_once "controllers/system/PostControl.php";
include_once "controllers/system/ReportControl.php";
include_once "controllers/system/EmploymentControl.php";

include_once "controllers/system/EmployeeControl.php";
include_once "controllers/system/BankAccountControl.php";
include_once "controllers/system/BeneficiaryControl.php";
include_once "controllers/system/MortuaryControl.php";
include_once "controllers/system/ClientController.php";
include_once "controllers/system/DeployedEmployeeControl.php";
include_once "controllers/system/SystemTypeControl.php";
include_once "controllers/system/ServiceDeductionControl.php";
include_once "controllers/system/HolidayControl.php";
include_once "controllers/system/AttendanceGroupControl.php";
include_once "controllers/system/AttendanceControl.php";
include_once "controllers/system/BankControl.php";
include_once "controllers/system/PettyCashControl.php";
include_once "controllers/system/RequisitionControl.php";
include_once "controllers/system/DisbursementControl.php";
include_once "controllers/system/AdjustmentControl.php";
include_once "controllers/system/RequisitionInfoControl.php";
include_once "controllers/system/ClientholidayControl.php";
include_once "controllers/system/LoanControl.php";
include_once "controllers/system/LoanPaymentControl.php";
include_once "controllers/system/UserAuthenticationControl.php";
include_once "controllers/system/UserProfileControl.php";
include_once "controllers/system/ActivityLogControl.php";
include_once "controllers/system/PayslipControl.php";
include_once "controllers/system/PettyCashReportControl.php";
include_once "controllers/system/PayslipRatesControl.php";

// APPLICATION CORE
include_once "core/Session.php";
include_once "core/Connection.php";
include_once "core/Authentication.php";
include_once "core/Application.php";
include_once "core/Routes.php";