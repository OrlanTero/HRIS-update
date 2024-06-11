import {
    addAttr,
    addHtml, append, CreateElement, generateRandomBinary, GetComboValue,
    HideShowComponent, ListenToCombo,
    ListenToForm, ListenToThisCombo, ListenToYearAndPeriodAsOptions,
    MakeID,
    ManageComboBoxes, SetNewComboItems
} from "../../../modules/component/Tool.js";
import Popup from "../../../classes/components/Popup.js";
import {TableListener} from "../../../classes/components/TableListener.js";
import {
    AddRecord, EditRecord, FilterRecords,
    RemoveRecords, RemoveRecordsBatch,
    SearchRecords,
    UpdateRecords
} from "../../../modules/app/SystemFunctions.js";
import {
    GetOverAllLoanBalanceOfEmployee,
    SelectEmployee, SelectEmployment,
    SelectLoans
} from "../../../modules/app/Administrator.js";
import {NewNotification, NotificationType} from "../../../classes/components/NotificationPopup.js";
import AlertPopup, {AlertTypes} from "../../../classes/components/AlertPopup.js";
import MenuBarListener from "../../../classes/components/MenuBarListener.js";

const TARGET = "holidays";


const OPTIONS = {
    year: null,
    period: null
};

function UpdateTable(TABLE_HTML) {
    const TABLE_BODY = document.querySelector(".main-table-body");

    addHtml(TABLE_BODY, TABLE_HTML);
    ManageTable();
}

function UpdateData() {
    return UpdateRecords(TARGET).then((HTML) => UpdateTable(HTML));
}

function AddNewLoan() {
    const popup = new Popup("loan_manager/new_loan", null, {
        backgroundDismiss: false,
    });

    popup.Create().then((res) => {
        popup.Show();

        const form = popup.ELEMENT.querySelector("form.form-control");
        const loan_type = form.querySelector(".loan_type");
        const selectemployee = popup.ELEMENT.querySelector(".select-employee");
        const employeeInput = popup.ELEMENT.querySelector("input[name=employee]");
        let selectedEmployee;

        ListenToForm(form, function (data) {

            data['loan_type'] = GetComboValue(loan_type).value;
            data['employee_id'] = selectedEmployee.employee_id;
            data['balance'] = data.amount;

            delete data['employee'];

            AddRecord("loans", {data: JSON.stringify(data)}).then((res) => {
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Successfully added' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();

                UpdateData();
            })
        }, ["target_date"]);

        selectemployee.addEventListener("click", function () {
            SelectEmployee().then((employee) => {
                selectedEmployee = employee;
                employeeInput.value = employee.name;
            });
        })

        ManageComboBoxes();

    });
}

function AddNewPayment() {
    const popup = new Popup("loan_manager/new_payment", null, {
        backgroundDismiss: false,
    });

    popup.Create().then((res) => {
        popup.Show();

        const form = popup.ELEMENT.querySelector("form.form-control");
        const loan_type = form.querySelector(".loan_type");
        const selectemployee = popup.ELEMENT.querySelector(".select-employee");
        const employeeInput = popup.ELEMENT.querySelector("input[name=employee]");
        const selectLoans = popup.ELEMENT.querySelector(".select-loans");
        const loansInput = popup.ELEMENT.querySelector("input[name=loans]");
        const toPay = popup.ELEMENT.querySelector("input[name=to_pay]");
        const balance = popup.ELEMENT.querySelector("input[name=balance]");
        let selectedEmployee;
        let selectedLoans;

        ListenToForm(form, function (data) {
            data['employee_id'] = selectedEmployee.employee_id;
            data['loans'] = selectedLoans.map((l) => l.loan_id).join(',');
            data['loan_types'] = selectedLoans.map((l) => l.loan_type).join(',');
            data['to_pay'] = toPay.value;

            delete data['employee'];

            AddRecord("loan_payments", {data: JSON.stringify(data)}).then((res) => {
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Successfully added' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();

                UpdateData();
            })
        }, ["note"]);

        selectemployee.addEventListener("click", function () {
            SelectEmployee().then((employee) => {
                selectedEmployee = employee;
                employeeInput.value = employee.name;

                GetOverAllLoanBalanceOfEmployee(employee.employee_id).then((res) => {
                    balance.value = res;
                });
            });
        })

        selectLoans.addEventListener("click", function () {
            if (selectedEmployee) {
                SelectLoans(selectedEmployee.employee_id).then((loans) => {
                    console.log(loans)
                    selectedLoans = loans;
                    loansInput.value = loans.map(l => l.description).join(", ");
                    toPay.value = loans.map(l => l.balance).reduce((a,b) => a + b);
                });
            } else {
                alert("Please select Employee!")
            }
        })

        ListenToYearAndPeriodAsOptions(popup.ELEMENT, function (op) {
        })

    });
}

function AddRequest() {
    const popup = new Popup("loan_manager/show_manager", null, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const loanBtn = pop.ELEMENT.querySelector(".new-loan-btn");
        const paymentBtn = pop.ELEMENT.querySelector(".new-payment-btn");
        const forwardBtn = pop.ELEMENT.querySelector(".forward-balance");
        const menubar = popup.ELEMENT.querySelector(".menu-bar-loan-manager");
        const selectEmployeeone = pop.ELEMENT.querySelector(".select-employee-one");
        const employeeInputone = pop.ELEMENT.querySelector("input[name=employee_id]");
        const selectEmployeetwo = pop.ELEMENT.querySelector(".select-employee-two");
        const employeeInputtwo = pop.ELEMENT.querySelector("input[name=employee_id_two]");
        const MENUBARLISTENER = new MenuBarListener(menubar);
        let selectedEployee = null;
        let selectedEployee1 = null;


        const updateLoanTable = (TABLE_HTML)=> {
            const TABLE_BODY = document.querySelector(".main-loan-table");

            addHtml(TABLE_BODY, TABLE_HTML);
            ManageTable();
        }

        const updatePaymentsTable = (TABLE_HTML)=> {
            const TABLE_BODY = document.querySelector(".main-payment-table");

            addHtml(TABLE_BODY, TABLE_HTML);
            ManageTable();
        }

        MENUBARLISTENER.makeActive(0);


        loanBtn.addEventListener("click", function () {
            AddNewLoan();
        });

        paymentBtn.addEventListener("click", function () {
            AddNewPayment();
        });

        forwardBtn.addEventListener("click", function () {

        });

        selectEmployeeone.addEventListener("click", function() {
            SelectEmployee().then((employee) => {
                console.log(employee)

                selectedEployee = employee;
                employeeInputone.value = employee.name;

                FilterRecords("loan_manager_loans", {id: employee.employee_id}).then((res) => {
                    updateLoanTable(res);
                })
            })
        });

        selectEmployeetwo.addEventListener("click", function() {
            SelectEmployee().then((employee) => {
                selectedEployee1 = employee;
                employeeInputtwo.value = employee.name;

                FilterRecords("loan_manager_payments", {id: employee.employee_id}).then((res) => {
                    updatePaymentsTable(res);
                })
            })
        });

        ManageComboBoxes()
    }))
}


function ManageTable() {
    const TABLE = document.querySelector(".main-table-container.table-component");

    if (!TABLE) return;

    const TABLE_LISTENER = new TableListener(TABLE);

    TABLE_LISTENER.addListeners({
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

    TABLE_LISTENER.init();

    TABLE_LISTENER.disableSelections();

    TABLE_LISTENER.listen(() => {
        TABLE_LISTENER.addButtonListener([
            {
                name: "add-request",
                action: AddRequest,
                single: true
            }
        ]);
    });
}

function Search(toSearch, filter) {
    SearchRecords(TARGET, toSearch, filter).then((HTML) => UpdateTable(HTML));
}

function ManageSearchEngine() {
    const searchEngine = document.querySelector(".search-engine input[name=search-records]");

    searchEngine.addEventListener("input", () => {
        Search(searchEngine.value)
    })
}


function Init() {
    ManageSearchEngine();
    ManageTable();
}

document.addEventListener("DOMContentLoaded", Init);