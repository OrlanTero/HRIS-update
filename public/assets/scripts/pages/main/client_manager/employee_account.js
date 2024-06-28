import {
    addAttr,
    addHtml, append, CreateElement,
    HideShowComponent, ListenToCombo,
    ListenToForm, ListenToThisCombo,
    MakeID,
    ManageComboBoxes, ResetActiveComponent, SetActiveComponent, SetNewComboItems
} from "../../../modules/component/Tool.js";
import Popup from "../../../classes/components/Popup.js";
import {TableListener} from "../../../classes/components/TableListener.js";
import {
    AddRecord, EditRecord, GetPeriodOfAYear, PostContainerRequest,
    RemoveRecords, RemoveRecordsBatch,
    UpdateRecords
} from "../../../modules/app/SystemFunctions.js";
import {SelectEmployee, SelectEmployment} from "../../../modules/app/Administrator.js";
import {NewNotification, NotificationType} from "../../../classes/components/NotificationPopup.js";
import AlertPopup, {AlertTypes} from "../../../classes/components/AlertPopup.js";

const TARGET = "netpays";

let SELECTED_CLIENT = null;

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
    return UpdateRecords("assign_employees").then((HTML) => UpdateTable(HTML));
}

function DeleteRequests(ids) {
    const popup = new AlertPopup({
        primary: "Remove deployment?",
        secondary: `${ids.length} selected`,
        message: "You will remove this employee to selected client."
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

function ViewRequests(id) {
    const popup = new Popup( "assign_employees/view_assignment", {id}, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const form = pop.ELEMENT.querySelector("form.form-control");
        const selectEmployee = pop.ELEMENT.querySelector(".select-employee");
        const employeeInput = form.querySelector("input[name=employee]");
        let selectedEployee = null;

        selectEmployee.addEventListener("click", function() {
            SelectEmployment().then((employment) => {
                selectedEployee = employment;

                employeeInput.value = employment.employee.name;
            })
        });

        ListenToForm(form, function (data) {

            if (selectedEployee !== null) {
                data['employment_id'] = selectedEployee.employment_id;
                data['client_id'] = SELECTED_CLIENT;
            }

            delete data['employee'];

            EditRecord(TARGET, {id, data: JSON.stringify(data)}).then((res) => {
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Successfully Edited Deployment' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();

                UpdateData()
            })
        })


        ManageComboBoxes()
    }))
}

function AddRequest(id) {
    const popup = new Popup("client_manager/assign_employee", {id: id}, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        const form = pop.ELEMENT.querySelector("form.form-control");
        const selectEmployee = pop.ELEMENT.querySelector(".select-employee");
        const employeeInput = form.querySelector("input[name=employee]");
        let selectedEployee = null;

        selectEmployee.addEventListener("click", function() {
            SelectEmployment().then((employment) => {
                selectedEployee = employment;

                employeeInput.value = employment.employee.name;
            })
        });

        ListenToForm(form, function (data) {

            data['employment_id'] = selectedEployee.employment_id;
            data['client_id'] = SELECTED_CLIENT;

            delete data['employee'];

            AddRecord(TARGET, {data: JSON.stringify(data)}).then((res) => {
                console.log(res)
                NewNotification({
                    title: res.code === 200 ? 'Success' : 'Failed',
                    message: res.code === 200 ? 'Successfully Deployed Employee' : 'Task Failed to perform!'
                }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                popup.Remove();

                UpdateData()
            })
        })


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

    // TABLE_LISTENER.listen(() => {
    //     TABLE_LISTENER.addButtonListener([
    //         {
    //             name: "add-request",
    //             action: AddRequest,
    //             single: true
    //         },
    //         {
    //             name: "view-request",
    //             action: ViewRequests,
    //             single: true
    //         },
    //         {
    //             name: "delete-request",
    //             action: DeleteRequests,
    //             single: false
    //         },
    //     ]);
    // });
}


function ShowNetPaysOf(id, options) {
    PostContainerRequest(TARGET,"get_netpays" ,{employee_id: id, options: JSON.stringify(options)}).then((res) => {
        UpdateTable(res);
    })
}

function ManageSelections() {
    const parent = document.querySelector(".selection-parent");
    const items = parent.querySelectorAll(".item-list");
    const searchEngine = document.querySelector('.search-engine input[name=search-records]');

    const resetItems = () => {
        ResetActiveComponent(items);
    }
    
    const selectItem = (item) => {
        const id = item.getAttribute("data-id");

        resetItems();

        SetActiveComponent(item, true);

        SELECTED_CLIENT = id;
    }
    const doSearch = (toSearch) => {
        if (toSearch.length > 0 ) {
            for (const item of items) {
                HideShowComponent(item, item.innerHTML.trim().toLowerCase().search(toSearch) >= 0);
            }
        } else {
            for (const item of items) {
                HideShowComponent(item, true);
            }
        }
    }

    searchEngine.addEventListener("input", function () {
        const __search = searchEngine.value.trim().toLowerCase();

        doSearch(__search);
    })

    for (const item of items) {
        item.addEventListener("click", function () {
            const id = item.getAttribute("data-id");

            selectItem(item);

            ShowNetPaysOf(id, OPTIONS);
        })
    }

    if (items.length) {

        const first = items[0];

        selectItem(first);

        ShowNetPaysOf(first.getAttribute("data-id"), OPTIONS);
    }

}

function Listens() {
    const year = document.querySelector(".year");
    const period = document.querySelector(".period");

    ListenToThisCombo(year, function (_, y) {
        SetNewComboItems(period, GetPeriodOfAYear(y));

        OPTIONS.year = y;

        ShowNetPaysOf(SELECTED_CLIENT, OPTIONS);


        ListenToThisCombo(period, function (_, p) {
            OPTIONS.period = p;

            ShowNetPaysOf(SELECTED_CLIENT, OPTIONS);
        })
    })


}

function Init() {
    ManageSelections();
    ManageTable();
    ManageComboBoxes();
    Listens();
}

document.addEventListener("DOMContentLoaded", Init);