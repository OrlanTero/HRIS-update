import {
    addAttr,
    addHtml, append, CreateElement, generateRandomBinary,
    HideShowComponent,
    ListenToForm, ListenToThisCombo, ListenToYearAndPeriodAsOptions,
    MakeID,
    ManageComboBoxes, SetNewComboItems
} from "../../../modules/component/Tool.js";
import Popup from "../../../classes/components/Popup.js";
import {TableListener} from "../../../classes/components/TableListener.js";
import {
    AddRecord, FilterRecords, GetPeriodOfAYear,
    RemoveRecords, RemoveRecordsBatch,
    SearchRecords,
    UpdateRecords
} from "../../../modules/app/SystemFunctions.js";
import {
    AddNewBankAccount,
    CreateNewEmployee,
    UpdateEmployee,
    ViewBankAccount
} from "../../../modules/app/Administrator.js";
import AlertPopup, { AlertTypes} from "../../../classes/components/AlertPopup.js";
import {NewNotification, NotificationType} from "../../../classes/components/NotificationPopup.js";
import FilterContainer from "../../../classes/components/FilterContainer.js";
const TARGET = "employees";


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

function DeleteRequests(ids) {
    const popup = new AlertPopup({
        primary: "Delete Employee?",
        secondary: `${ids.length} selected`,
        message: "Deleting these employee, cant be undone!"
    }, {
        alert_type: AlertTypes.YES_NO,
    });

    popup.AddListeners({
        onYes: () => {
            RemoveRecordsBatch(TARGET, {data: JSON.stringify(ids)}).then((res) => {
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Successfully Deleted Data' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                UpdateData();
            })
        }
    })


    popup.Create().then(() => { popup.Show() })
}

function ViewRequest(id) {
    const popup = new Popup("employees/view_employee", {id: id}, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const form = pop.ELEMENT.querySelector("form.form-control");
        const newbank = pop.ELEMENT.querySelector(".add-new-bank-account");
        const banklist = pop.ELEMENT.querySelector(".most-item-lists .main");
        const currentBanks = pop.ELEMENT.querySelectorAll(".most-item-lists .item.item-button");
        let currentBankAccounts = [...currentBanks].map((item) => {
            return {
                id: item.getAttribute("data-id"),
                status: 'current'
            };
        }).filter((i) => i);

        let bankAccounts = [];

        const updateBankAccount = (id, bank, group) => {
            let i = 0;

            for (const b of group) {
                if (b.id === id) {
                    if (!bank.id) {
                        bank.id = id;
                    }

                    group[i] = bank;
                }

                i++;
            }
        }

        const updateBankAccountStatus = (id, status, group) => {
            let i = 0;

            for (const b of group) {
                if (b.id === id) {
                    group[i].status = status;
                }
                i++;
            }
        }

        const listenToCurrentBanks = () => {
            let i = 0;

            for (const bank of currentBanks) {
                let index = i;

                bank.addEventListener("click", function () {
                    const span = bank.querySelector("span");
                    const bb = currentBankAccounts[index];

                    ViewBankAccount(bb.status === 'edited' ? bb : bank.getAttribute('data-id')).then((b) => {
                        updateBankAccount(bank.getAttribute('data-id'), {status: 'edited', ...b}, currentBankAccounts);
                        span.innerText = b.bank.name;
                    }).catch((e) => {
                        bank.remove();

                        updateBankAccountStatus(bank.getAttribute('data-id'), 'deleted', currentBankAccounts);
                    });
                })

                i++;
            }
        }

        const getBankByID = (id) => {
            try {
                return bankAccounts.filter((b) => b.id === id)[0];

            } catch (e) {
                return  null;
            }
        }

        const addNewBank = (bank) => {

            const id = generateRandomBinary(10);

            bank.id = id;
            bank.status = 'created';
            
            bankAccounts.push(bank);

            const el = CreateElement({
                el: "li",
                className: "item",
                child: CreateElement({
                    el: "SPAN",
                    text: bank.bank.name
                }),
                listener: {
                    click: () => {
                        const span = el.querySelector("span");

                        ViewBankAccount(getBankByID(id)).then((b) => {
                            updateBankAccount(id, {status: 'created', ...b}, bankAccounts);
                            span.innerText = b.bank.name;

                        }).catch((e) => {
                            el.remove();

                            bankAccounts = bankAccounts.filter((b) => b.id !== id);
                        });
                    }
                }
            });

            append(banklist, el);
        }

        ListenToForm(form, function (data) {
            data['id'] = id;

            const allBankAccounts = [...bankAccounts, ...currentBankAccounts];

            UpdateEmployee(data, allBankAccounts).then((res) => {

                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Employee Successfully updated' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();

                UpdateData();
            })
        }, [
            "telephone",
            "mobile",
            "email",
            "address",
            "sss",
            "tin",
            "rfid",
            "phil",
            "ctc",
            "gsis",
            "pagibig"
        ]);

        newbank.addEventListener("click", function() {
            AddNewBankAccount().then((bank) => {
                addNewBank(bank);
            })
        });

        listenToCurrentBanks();

        ManageComboBoxes()
    }))
}

function AddRequest(id) {
    const popup = new Popup("employees/add_new_employee", {id: id}, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const form = pop.ELEMENT.querySelector("form.form-control");
        const newbank = pop.ELEMENT.querySelector(".add-new-bank-account");
        const banklist = pop.ELEMENT.querySelector(".most-item-lists .main");
        const bankAccounts = [];

        const addNewBank = (bank) => {
            const id = bankAccounts.length;
            bankAccounts.push(bank);

            const el = CreateElement({
                el: "li",
                className: "item",
                child: CreateElement({
                    el: "SPAN",
                    text: bank.bank
                }),
                listener: {
                    click: () => {
                        bankAccounts.splice(id, 1);

                        el.remove();
                    }
                }
            });

            append(banklist, el);
        }

        ListenToForm(form, function (data) {
            CreateNewEmployee(data, bankAccounts).then((res) => {
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Employee Successfully Added' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();

                UpdateData();
            });
        }, [
            "telephone",
            "mobile",
            "email",
            "address",
            "sss",
            "tin",
            "rfid",
            "phil",
            "ctc",
            "gsis",
            "pagibig"
        ]);

        newbank.addEventListener("click", function() {
            AddNewBankAccount().then((bank) => {
                addNewBank(bank);
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

    TABLE_LISTENER.listen(() => {
        TABLE_LISTENER.addButtonListener([
            {
                name: "add-request",
                action: AddRequest,
                single: true
            },
            {
                name: "view-request",
                action: ViewRequest,
                single: true
            },
            {
                name: "delete-request",
                action: DeleteRequests,
                single: false
            },
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
function ManageButtons() {
    // const filter = document.querySelector(".filter-button");
    //
    // const FLTER = new FilterContainer({}, { table: "employees", id: "employee_id", control: "EMPLOYEE_CONTROL"});
    //
    // FLTER.Create().then(() => FLTER.Hide());
    //
    // FLTER.Load("EMPLOYEES_TABLE_HEADER_TEXT", "EMPLOYEES_TABLE_BODY_KEY")
    //
    // FLTER.AddListeners({onFilter: function (data) {
    //         UpdateTable(data);
    //     }});
    //
    // filter.addEventListener("click", function () {
    //     FLTER.Show();
    // })

}

function Listens() {
    const yearPeriod = document.querySelector(".year-period");

    ListenToYearAndPeriodAsOptions(yearPeriod, function (options) {
        FilterRecords(TARGET, {data: JSON.stringify(options)}).then(r => {
            UpdateTable(r)
        })
    })


}
function Init() {
    ManageSearchEngine();
    ManageTable();
    ManageButtons();
    Listens();
}

document.addEventListener("DOMContentLoaded", Init);