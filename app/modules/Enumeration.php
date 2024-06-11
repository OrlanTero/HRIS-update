
<?php


enum UserAuthenticationTypes : string {
    case NO_AUTHENTICATION = "NO_AUTHENTICATION";
    case USERNAME_PASSWORD = "USERNAME_PASSWORD";
    case PIN_AUTHENTICATION = "PIN_AUTHENTICATION";
    case EMAIL_AUTHENTICATION = "EMAIL_AUTHENTICATION";
}

enum PostedTypes : int
{
    case POSTED = 1;
    case NOT_POSTED = 2;
}

enum CancelledTypes : int
{
    case CANCELLED = 1;
    case NOT_CANCELLED = 2;

}

enum PaidTypes : int
{
    case PAID = 1;

    case NOT_PAID = 2;
}
enum ActiveTypes : int
{
    case ACTIVE = 1;
    case NOT_ACTIVE = 2;

}

enum FinishedTypes : int
{
    case FINISHED = 1;

    case NOT_FINISHED = 2;
}
enum VatType : string
{
    case AMMUNITION = "AMMUNITION";

    case EQUIPMENT = "EQUIPMENT";

    case FOODANDMEALS = "FOOD & MEALS";

    case FUELANDGASOLINE = "FUEL & GASOLINE";

    case LIGHTANDELECTRICITY = "LIGHT & ELECTRICITY";

    case MISCELLANEOUSVAT = "MISCELLANEOUS VAT";

    case OTHER = "OTHER";
    case RENTAL = "RENTAL";
    case REPAIRANDMAINTENANCE = "REPAIR & MAINTENANCE";
    case SALARIESANDWAGESINSPECTORS = "SALARIES & WAGES / INSPECTORS";
    case SUPPLIES = "SUPPLIES";

    case TELECOMMUNICATION ="TELECOMMUNICATION";

    case NONE   = "NONE";
}
enum NonVatType : string
{
    case BACKGROUNDINVESTIGATION = "BACKGROUND INVESTIGATION";
    case BACKWAGES = "BACKWAGES";
    case BANKTRANSFERBANK = "BANK TRANSFER - BANK";
    case BANKTRANSFERGUARDS = "BANK TRANSFER - GUARDS";
    case CASHADVANCEGUARDS = "CASH ADVANCE GUARDS";
    case CASHADVANCEMANAGEMENT = "CASH ADVANCE MANAGEMENT";
    case CASHBOND = "CASH BOND";
    case CASHBONDDOLECASE = "CASH BOND - DOLE CASE";
    case CERTIFICATION   ="CERTIFICATION";
    case DOLEEXPENSES   ="DOLE EXPENSES";
    case FINANCIALASSISTANCE   ="FINANCIAL ASSISTANCE - DOLE";
    case FOODNONVAT   ="FOOD NON VAT";
    case FRINGEBENEFITS   ="FRINGE BENEFITS";
    case FUNDTRANSFER   ="FUND TRANSFER";
    case INSURANCE   ="INSURANCE";
    case INSURANCEREINBURSEMENT   ="INSURANCE REINBURSEMENT";

    case NONE   = "NONE";
}

enum PaymentType : string
{
    case CASH ="CASH";
    case CHEQUE ="CHEQUE";
    case BANKTRANSFER ="BANK TRANSFER";
}
enum BasicUnitType : string
{
    case BOTTLES = "BOTTLES";

    case BOX = "BOX";

    case PACKS = "PACKS";

    case PAIRS = "PAIRS";

    case PCS = "PCS";
}
enum GenderType : string
{
    case MALE = "Male";

    case FEMALE = "Female";
}

enum CivilStatusTypes : string
{
    case SINGLE = "Single";

    case MARRIED = "Married";

    case WIDOWED = "Widowed";
}

enum DepartmentTypes : string
{
    case FIELD = "Field";

    case OFFICE = "Office";
}

enum EmploymentStatus : string
{
    case CONTRACTUAL = "Contractual";

    case PROBATIONARY = "Probationary";

    case REGULAR = "Regular";

    case RESIGNED = "Resigned";
}

enum EmploymentTypes : string
{
    case FIELD = "Field";

    case STAFF = "Staff";
}

enum EmploymentPositionTypes : string
{
    case ADMINISTRATOR = "Administrator";

    case CASHIER = "Cashier";

    case GENERAL_SERVICES = "General Services";

    case HEAD_GUARD = "Head Guard";

    case IT_CONSULTANT = "IT Consultant";

    case PAYROLL_OFFICER = "Payroll Officer";

    case SECURITY_GUARD = "Security Guard";
}

enum RegionTypes : string
{
    case REGION1 ="REGION1";
    case REGION2 ="REGION2";
    case REGION3 ="REGION3";
    case REGION4 ="REGION4";
    case REGION5 ="REGION5";
    case REGION6 ="REGION6";
    case REGION7 ="REGION7";
    case REGION8 ="REGION8";
}
enum RestDayTypes : string
{
    case MONDAY = "Monday";

    case TUESDAY = "Tuesday";

    case WEDNESDAY = "Wednesday";

    case THURSDAY = "Thursday";

    case FRIDAY = "Friday";

    case SATURDAY = "Saturday";

    case SUNDAY = "Sunday";

    case NO_REST_DAY = "No Rest Day";

}

enum AttendanceTypes : string
{
    case REGULAR = "Regular";

    case OT = "OT";

    case NIGHT_DIFF = "Night Diff";

    case LEGAL_HOLIDAY = "Legal Holiday";

    case SPECIAL_HOLIDAY = "Special Holiday";

    case REST_DAY = "Rest Day";

    case LEGAL_HOLIDAY_OT = "Legal Holiday OT";

    case SPECIAL_HOLIDAY_OT = "Special Holiday OT";
}

enum LoanStatusTypes : int
{
    case NOT_PAID = 1;

    case PARTIAL_PAID = 2;

    case PAID = 3;
}

enum ServiceDeductionTypes : string
{
    case SSS = "sss";

    case PHILHEALTH = "phil";

    case PAGIBIG = "pagibig";
}

enum RequisitionStatusType : string
{
    case DRAFT = "DRAFT";

    case FINALIZED = "FINALIZED";
}

enum ActivityLogCategories : int
{
    case ATTENDANCE = 1;
    case ADJUSTMENTS = 2;
    case EMPLOYEE_ACCOUNT = 3;
    case EMPLOYEES = 4;
    case EMPLOYMENT = 5;
    case MORTUARY = 6;
    case BANKS = 7;
    case EMPLOYEE_ASSIGNMENT = 8;
    case CLIENTS = 9;
    case BILLING = 10;
    case HOLIDAYS = 11;
    case PAYROLL = 12;
    case REQUISITION = 13;
    case DISBURSEMENT = 14;
    case COLLECTION = 15;
    case LOAN_MANAGER = 16;
    case DATA_MANAGEMENT = 17;
    case PROFILE = 18;
    case AUTHENTICATION = 19;
    case ATTENDANCE_GROUP = 20;
    case BANK_ACCOUNT = 21;
    case BENEFICIARY = 22;
    case CLIENT_HOLIDAY = 23;
    case EMPLOYEE_DEPLOYMENT = 24;
    case PETTY_CASH = 25;
    case DATA_MAINTENANCE = 26;

}

enum ActivityLogActionTypes : int
{
    case CREATE = 1;
    case DELETE = 2;
    case UPDATE = 3;
    case INSERT = 4;
    case MODIFY = 5;
    case PRINTS = 6;
}

enum ActivityLogStatus : int
{
    case SUCCESS = 1;
    case FAILED = 2;
}

enum ReportTypes : int
{
    case PAYSLIP_PER_CLIENT_INDIVIDUALLY = 99;
    case PAYSLIP_PER_CLIENT = 100;
    case ACCOUNT_CREDITED = 101;
    case LOAN_PAYMENTS = 102;
    case MORTUARY = 103;
    case PAYSLIP_AZ = 104;
    case TOTAL_BANK = 105;
    case PAYROLL = 106;

    case PETTY_CASH_EXPENSES = 107;
};

enum BeneficiaryTypes : string
{
    case BENEFICIARY = "Beneficiary";

    case CHARITABLE_ORGANIZATION = "Charitable Organization";

    case RESIDUARY_BENEFICIARY = "Residuary Beneficiary";

    case SPOUSE = "Spouse";

    case CHARITABLE_BENEFICIARIES = "Charitable Beneficiaries";

    case TRUSTS = "Trusts";

    case CHILDREN = "Children";

    case LAST_WILL_AND_TESTAMENT = "Last Will and Testament";

    case OTHER_FAMILY_MEMBERS = "Other Family Members";

}

//enum LoanTypes : string
//{
//    case AWDW%AWD
//}

?>


