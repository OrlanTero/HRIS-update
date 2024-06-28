import {
    ManageComboBoxes
} from "../../../modules/component/Tool.js";
import Popup from "../../../classes/components/Popup.js";
import {TableListener} from "../../../classes/components/TableListener.js";




function ViewRequest(id) {
    const popup = new Popup("disbursement/view_disbursement", {id: id}, {
        backgroundDismiss: false,
    });

    popup.Create().then(((pop) => {
        popup.Show();

        ManageComboBoxes()
    }))
}

function ManageTable() {
    const TABLE = document.querySelector(".main-table-container.table-component");

    if (!TABLE) return;

    const TABLE_LISTENER = new TableListener(TABLE);

    TABLE_LISTENER.pagination.max = 20;

    TABLE_LISTENER.disableSelections()

    TABLE_LISTENER.addListeners({
        none: {
            remove: ["view-request"],
            view: ["add-request"],
        },
        select: {
            view: ["view-request"],
        },
        selects: {
            view: [],
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


function ManageButtons() {


}
function Init() {
    ManageTable();
    ManageButtons();
}

document.addEventListener("DOMContentLoaded", Init);