
import MenuBarListener from "../../../classes/components/MenuBarListener.js";
import {TableListener} from "../../../classes/components/TableListener.js";
import {
    HideShowComponent,
    ListenToCombo,
    ListenToForm,
    ListenToYearAndPeriodAsOptions,
    ManageComboBoxes
} from "../../../modules/component/Tool.js";
import {SidePicker} from "../../../classes/components/SidePicker.js";
import PDFManager from "../../../classes/components/PDFManager.js";
import {GetReports, SelectEmployee} from "../../../modules/app/Administrator.js";

const REPORT_TYPES = {
    PAYSLIP_PER_CLIENT_INDIVIDUALLY: 99,
    PAYSLIP_PER_CLIENT: 100,
    ACCOUNT_CREDITED: 101,
    LOAN_PAYMENTS: 102,
    MORTUARY: 103,
    PAYSLIP_AZ: 104,
    TOTAL_BANK: 105,
    PAYROLL: 106,

    PETTY_CASH_EXPENSES: 107
};


function ManageSidebars() {
    const payrollSidebar = document.querySelector(".payroll-sidebar");
    const expensesSidebar = document.querySelector(".expenses-sidebar");
    const adminSidebar = document.querySelector(".admin-sidebar");

    const sidebar = new SidePicker(payrollSidebar);
    const EXsidebar = new SidePicker(expensesSidebar);
    const ADsidebar = new SidePicker(adminSidebar);

    const pdfManager = new PDFManager();

    sidebar.listens();
    EXsidebar.listens();
    ADsidebar.listens();

    const pay_slip_per_client_year_period = document.querySelector(".pay_slip_per_client_year_period");
    const accounts_credited_year_payroll = document.querySelector(".accounts_credited_year_payroll");
    const loan_payments_year_payroll = document.querySelector(".loan_payments_year_payroll");
    const mortuary_control_year_payroll = document.querySelector(".mortuary_control_year_payroll");
    const pay_slip_a_z_year_payroll = document.querySelector(".pay_slip_a_z_year_payroll");
    const total_bank_year_period = document.querySelector(".total_bank_year_period");
    const payroll_year_period = document.querySelector(".payroll_year_period");

    const expenses_petty_cash_period = document.querySelector(".petty_cash_expenses_period");

    const payslip_table = document.querySelector(".main-table-requests");

    let loan_options;
    let petty_cash_options;

    ListenToYearAndPeriodAsOptions(pay_slip_per_client_year_period, function ({year, period}) {
        GetReports(REPORT_TYPES.PAYSLIP_PER_CLIENT, {year, period}).then((res) => {
            payslip_table.innerHTML = res;

            const container = document.querySelector('.per-client-container');

            const listener = new TableListener(container);

            listener.addListeners({
                none: {
                    remove: ["delete-request", "view-request"],
                    view: ["add-request"],
                },
                select: {
                    view: ["delete-request", "view-request"],
                },
                selects: {
                    view: ["delete-request"],
                    remove: ["view-request"]
                },
            });

            listener.init();

            listener.listen(() => {
                listener.addButtonListener([
                    {
                        name: "view-request",
                        action: (id) => {
                            GetReports(REPORT_TYPES.PAYSLIP_PER_CLIENT_INDIVIDUALLY, {year, period, client: id}).then((res) => {
                                console.log(res)
                                pdfManager.preview(REPORT_TYPES.PAYSLIP_PER_CLIENT_INDIVIDUALLY, res);
                            });
                        },
                        single: true
                    }
                ]);
            });
        });
    })

    ListenToYearAndPeriodAsOptions(expenses_petty_cash_period, function (options) {
        petty_cash_options = options;
    })

    ListenToYearAndPeriodAsOptions(accounts_credited_year_payroll, function ({year, period}) {
        GetReports(REPORT_TYPES.ACCOUNT_CREDITED, {year, period}).then((res) => {
            console.log(res);
        });
    })

    ListenToYearAndPeriodAsOptions(loan_payments_year_payroll, function (options) {
        loan_options = options;
        GetReports(REPORT_TYPES.LOAN_PAYMENTS, options).then((res) => {
            console.log(res);
        });
    }, ['type'])

    ListenToYearAndPeriodAsOptions(total_bank_year_period, function ({year, period}) {
        GetReports(REPORT_TYPES.TOTAL_BANK, {year, period}).then((res) => {
            console.log(res);
        });
    })

    ListenToYearAndPeriodAsOptions(payroll_year_period, function ({year, period}) {
        GetReports(REPORT_TYPES.PAYROLL, {year, period}).then((res) => {
            console.log(res);
        });
    })

    // ...

    const by = pay_slip_a_z_year_payroll.querySelector(".by");
    const bySelect = pay_slip_a_z_year_payroll.querySelector(".by_select");
    const selectEmployee = pay_slip_a_z_year_payroll.querySelector(".select-employee");
    const selectEmployeeInput = pay_slip_a_z_year_payroll.querySelector("input[name=by_employee]");
    let selectedEmployee = null;
    let selectedAll = false;
    let az_options, mortuary_options;


    ListenToYearAndPeriodAsOptions(pay_slip_a_z_year_payroll, function (op) {
        az_options = op;
    })

    ListenToYearAndPeriodAsOptions(mortuary_control_year_payroll, function (op) {
        mortuary_options = op;
    })

    ListenToCombo(by, function (_, text) {
        HideShowComponent(bySelect, text == "Employee", false);
        selectedAll = text == "All";
    });

    selectEmployee.addEventListener("click", function () {
        SelectEmployee().then((employee) => {
            selectEmployeeInput.value = employee.name;
            selectedEmployee = employee;
        })
    })

    // ...

    const printPayslipAZ = payrollSidebar.querySelector("[data-content=pay_slip_a_z]").querySelector('.printBtn');
    const printMortuary = payrollSidebar.querySelector("[data-content=mortuary_control]").querySelector('.printBtn');
    const printLoanPayments = payrollSidebar.querySelector("[data-content=loan_payments]").querySelector('.printBtn');
    const printTotalBank = payrollSidebar.querySelector("[data-content=total_bank]").querySelector('.printBtn');

    const printExpensePetty = expensesSidebar.querySelector("[data-content=pettycash]").querySelector('.printBtn');


    printPayslipAZ.addEventListener("click", function () {
       if (selectedEmployee != null) {
           az_options.employee_id = selectedEmployee.employee_id;
       } else {
           az_options.employee_id = 'all';
       }

        GetReports(REPORT_TYPES.PAYSLIP_AZ, az_options).then((res) => {
            pdfManager.preview(REPORT_TYPES.PAYSLIP_AZ, res);
        });
    })

    printMortuary.addEventListener("click", function () {
        GetReports(REPORT_TYPES.MORTUARY, mortuary_options).then((res) => {
            pdfManager.preview(REPORT_TYPES.MORTUARY, res);
        });
    })

    printLoanPayments.addEventListener("click", function () {
        GetReports(REPORT_TYPES.LOAN_PAYMENTS, loan_options).then((res) => {
            pdfManager.preview(REPORT_TYPES.LOAN_PAYMENTS, res);
        });
    })

    printTotalBank.addEventListener("click", function () {
        GetReports(REPORT_TYPES.TOTAL_BANK, loan_options).then((res) => {
            pdfManager.preview(REPORT_TYPES.TOTAL_BANK, res);
        });
    })

    printExpensePetty.addEventListener("click", function () {
        GetReports(REPORT_TYPES.PETTY_CASH_EXPENSES, expenses_petty_cash_period).then((res) => {
            console.log(res)
            pdfManager.preview(REPORT_TYPES.PETTY_CASH_EXPENSES, res);
        });
    })

    ManageComboBoxes();
}

function Init() {
    const menubar = document.querySelector(".menu-bar-reports");
    const MENUBARLISTENER = new MenuBarListener(menubar);

    MENUBARLISTENER.makeActive(0);

    ManageSidebars();
}


document.addEventListener("DOMContentLoaded", Init);