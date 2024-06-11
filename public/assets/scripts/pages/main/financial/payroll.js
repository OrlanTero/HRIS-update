import {
    addHtml, GetComboValue, ListenToCombo,
    ListenToForm,
    ManageComboBoxes, SetNewComboItems
} from "../../../modules/component/Tool.js";
import Popup from "../../../classes/components/Popup.js";
import {TableListener} from "../../../classes/components/TableListener.js";
import {
    AddRecord, EditRecord,
    RemoveRecords, RemoveRecordsBatch,
    SearchRecords,
    UpdateRecords
} from "../../../modules/app/SystemFunctions.js";
import {NewNotification, NotificationType} from "../../../classes/components/NotificationPopup.js";
import AlertPopup, {AlertTypes} from "../../../classes/components/AlertPopup.js";
import FilterContainer from "../../../classes/components/FilterContainer.js";
import {
    GetAvailablePeriodAttendance,
    GetPayrollTableOf,
    SelectClient,
    SelectEmployee
} from "../../../modules/app/Administrator.js";
const TARGET = "payroll";

let TABLE_LISTENER;

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
        primary: "Delete Banks?",
        secondary: `${ids.length} selected`,
        message: "Deleting these banks, cant be undone!"
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
    const popup = new Popup("banks/view_bank", {id: id}, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const form = pop.ELEMENT.querySelector("form.form-control");

        ListenToForm(form, function (data) {
            EditRecord(TARGET, {id, data: JSON.stringify(data)}).then((res) => {
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Successfully Updated Banks' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();
                UpdateData()
            })
        })

        ManageComboBoxes()
    }))
}

function AddRequest() {
    const popup = new Popup("payroll/view_new_payroll", null, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const form = pop.ELEMENT.querySelector("form.form-control");
        const selecClient = pop.ELEMENT.querySelector(".select-client");
        const period = pop.ELEMENT.querySelector(".period");
        const employeeInput = pop.ELEMENT.querySelector("input[name=client]");
        let selectedClient;
        console.log(period)

        const check = ListenToForm(form, function () {

            const attendance_group = GetComboValue(period).value;

            GetPayrollTableOf(attendance_group).then((table) => {
                UpdateTable(table);
                popup.Remove();
            });

          /*  AddRecord(TARGET, {data: JSON.stringify(data)}).then((res) => {
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Successfully Added Banks' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();

                UpdateData()
            })*/
        })

        selecClient.addEventListener("click", function () {
            SelectClient().then((client) => {
                selectedClient = client;
                employeeInput.value = client.name;
                check(true);
                return client;
            }).then((c) => GetAvailablePeriodAttendance(c.client_id)).then((periods) => {
                SetNewComboItems(period, periods.map((p) => {
                    return {
                        text: p.period + " - " + p.year,
                        value: p.attendance_group_id
                    };
                }));

                ListenToCombo(period, () =>  check(true))

                check(true);
            });

        })

        ManageComboBoxes()
    }))
}


function ManageTable() {
    const TABLE = document.querySelector(".main-table-container.table-component");

    if (!TABLE) return;

    TABLE_LISTENER = new TableListener(TABLE);

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
        TABLE_LISTENER.search(searchEngine.value);
    })
}

function ManageButtons() {
    const filter = document.querySelector(".filter-button");

    const FLTER = new FilterContainer({}, { table: "banks", id: "banks_id", control: "BANK_CONTROL"});

    FLTER.Create().then(() => FLTER.Hide());

    FLTER.Load("BANKS_TABLE_HEADER_TEXT", "BANKS_TABLE_BODY_KEY")

    FLTER.AddListeners({onFilter: function (data) {
            UpdateTable(data);
        }});

    filter.addEventListener("click", function () {
        FLTER.Show();
    })

}
function Init() {
    ManageTable();
    ManageSearchEngine();
    ManageButtons();
}

document.addEventListener("DOMContentLoaded", Init);