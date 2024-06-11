import {
    addHtml, GetComboValue, ListenToCombo,
    ListenToForm, ListenToThisCombo, ListenToYearAndPeriodAsOptions,
    ManageComboBoxes, SetComboValue, SetNewComboItems
} from "../../../modules/component/Tool.js";
import Popup from "../../../classes/components/Popup.js";
import {TableListener} from "../../../classes/components/TableListener.js";
import {
    AddRecord, EditRecord, FilterRecords, GetPeriodOfAYear,
    RemoveRecordsBatch,
    SearchRecords,
    UpdateRecords
} from "../../../modules/app/SystemFunctions.js";
import {SelectClient, SelectEmployee} from "../../../modules/app/Administrator.js";
import AttendanceTableListener from "../../../classes/components/AttendanceTableListener.js";
import {NewNotification, NotificationType} from "../../../classes/components/NotificationPopup.js";
import FilterContainer from "../../../classes/components/FilterContainer.js";
import AlertPopup, {AlertTypes} from "../../../classes/components/AlertPopup.js";

const TARGET = "attendance";
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
        primary: "Delete Attendance?",
        secondary: `${ids.length} selected`,
        message: "Deleting these attendance, cant be undone!"
    }, {
        alert_type: AlertTypes.YES_NO,
    });

    popup.AddListeners({
        onYes: () => {
            RemoveRecordsBatch("attendance_group", {data: JSON.stringify(ids)}).then((res) => {
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
    const popup = new Popup("attendance/view_attendance_group", {id: id}, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const form = pop.ELEMENT.querySelector("form.form-control");
        const active = form.querySelector(".active");
        const finished = form.querySelector(".finished");
        const TABLES = [...popup.ELEMENT.querySelectorAll(".main-attendance-table-container .attendance-table-container")].map((TABLE) => new AttendanceTableListener(TABLE));
        let selectedClient;

        ListenToCombo(finished, function (v, p) {
            if (v == 1) {
                // Set
                // SetComboSelectedIndex(1);
            }
        })

        const check = ListenToForm(form, function (data) {
            data['active'] = GetComboValue(active).value;
            data['finished'] = GetComboValue(finished).value;

            if (selectedClient) {
                data['client_id'] = selectedClient.client_id;

            } else {
                delete  data['client_id'];
            }

            delete data['branch'];

            Promise.all(TABLES.map((t) => t.saveToDatabase()))
                .then(() => {
                    NewNotification({
                        title:  'Success',
                        message: 'Successfully updated',
                    }, 3000,   NotificationType.SUCCESS)
                }).then(() =>  {
                    return EditRecord("attendance_group", {id, data: JSON.stringify(data)});
                })
                .catch(() => {
                    NewNotification({
                        title:  'Failed',
                        message: 'Task failed to perform!',
                    }, 3000,   NotificationType.ERROR)
                })
                .finally(() => {
                popup.Remove();

                UpdateData();
            })
        })

        for (const TABLE of TABLES) {
            TABLE.listen();

            TABLE.mapColors([
                {row: 3, color: "#FAC1FF"},
                {row: 4, color: "#BDC1FF"},
                {row: 5, color: "#C2FDFF"},
                {row: 6, color: "#BCFFC4"},
                {row: 7, color: "#FFDEC5"},
            ]);
        }

        ManageComboBoxes()
    }))
}

function AddRequest(id) {
    const popup = new Popup("attendance/add_new_attendance_group", {id: id}, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const form = pop.ELEMENT.querySelector("form.form-control");
        const select_client = pop.ELEMENT.querySelector(".select-client");
        const client_input = pop.ELEMENT.querySelector("input[name=client_id]");
        const branch_input = pop.ELEMENT.querySelector("input[name=branch]");
        const year = form.querySelector(".year");
        const period = form.querySelector(".period");
        let selectedClient;

        const check = ListenToForm(form, function (data) {

            data['client_id'] = selectedClient.client_id;

            delete data['branch'];

            //
            AddRecord("attendance_group", {data: JSON.stringify(data)}).then((res) => {
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Successfully added' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();

                UpdateData()

            })
        })

        select_client.addEventListener("click", function() {
            SelectClient().then((client) => {
                selectedClient = client;
                client_input.value = client.name;
                branch_input.value = client.branch;
            });
        })

        ListenToCombo(year, function (_, y) {
            const periods = GetPeriodOfAYear(y);

            SetNewComboItems(period, periods);

            ListenToCombo(period, function () {
                check(true);
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
                name: "view-request",
                action: ViewRequest,
                single: true
            },
            {
                name: "add-request",
                action: AddRequest,
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
    const filter = document.querySelector(".filter-button");

    const FLTER = new FilterContainer({}, { table: "attendance_groups", id: "attendance_group_id", control: "ATTENDANCE_GROUP_CONTROL"});

    FLTER.Create().then(() => FLTER.Hide());

    FLTER.Load("ATTENDANCE_GROUP_TABLE_HEADER_TEXT", "ATTENDANCE_GROUP_BODY_KEY")

    FLTER.AddListeners({onFilter: function (data) {
        UpdateTable(data);
    }});

    filter.addEventListener("click", function () {
        FLTER.Show();
    })
    
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