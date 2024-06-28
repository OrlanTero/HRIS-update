import {AddRecord, EditRecord, SearchRecords} from "./SystemFunctions.js";
import Popup from "../../classes/components/Popup.js";
import {addHtml, Ajax, GetComboValue, ListenToForm, ManageComboBoxes} from "../component/Tool.js";
import {TableListener} from "../../classes/components/TableListener.js";

export const AUTHENTICATION_TYPE = {
    NO: "NO_AUTHENTICATION",
    USERNAME_PASSWORD: "USERNAME_PASSWORD",
    PIN_AUTHENTICATION: "PIN_AUTHENTICATION",
    EMAIL_AUTHENTICATION: "EMAIL_AUTHENTICATION",
};

export function CreateNewEmployee(employee, bank) {
    return new Promise((resolve) => {
        AddRecord("employees", {data: JSON.stringify({employee: employee, bank: bank})}).then((data) => {
            resolve(data);
        })
    })
}

export function UpdateEmployee(employee, bank) {
    return new Promise((resolve) => {
        EditRecord("employees", {data: JSON.stringify({employee: employee, bank: bank})}).then((data) => {
            resolve(data);
        })
    })
}



export function AddNewBankAccount() {
    const popup = new Popup("employees/add_new_bank_account", null, {
        backgroundDismiss: false,
    });

    return new Promise((resolve) => {
        popup.Create().then((pop) => {
            popup.Show();

            const form = pop.ELEMENT.querySelector("form.form-control");
            const bank = form.querySelector(".bank_id");

            ListenToForm(form, async function (data) {
                data['bank_id'] = GetComboValue(bank).value;

                data['bank'] = await GetBank(data['bank_id']);

                resolve(data);

                popup.Remove();
            });

            ManageComboBoxes();
        })
    })
}

export function ViewBankAccount(bank) {
    const popup = new Popup("employees/view_bank_account", {bank}, {
        backgroundDismiss: false,
    });

    return new Promise((resolve, reject) => {
        popup.Create().then((pop) => {
            popup.Show();

            const form = pop.ELEMENT.querySelector("form.form-control");
            const deleteBank = form.querySelector(".delete-form");
            const bank = form.querySelector(".bank_id");

            ListenToForm(form, async function (data) {
                data['bank_id'] = GetComboValue(bank).value;

                data['bank'] = await GetBank(data['bank_id']);

                resolve(data);

                popup.Remove();
            });

            deleteBank.addEventListener("click", function() {
                popup.Remove();
                reject();
            })


            ManageComboBoxes();
        })
    })
}

export function GetEmployee(id) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetEmployee",
            type: "POST",
            data: {id},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}
export function GetOverAllLoanBalanceOfEmployee(id) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetOverAllLoanBalanceOfEmployee",
            type: "POST",
            data: {id},
            success: (res) => {
              resolve(res);
            }
        })
    })
}

export function GetEmployment(id) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetEmployment",
            type: "POST",
            data: {id},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function GetClient(id) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetClient",
            type: "POST",
            data: {id},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function GetHoliday(id) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetHoliday",
            type: "POST",
            data: {id},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function GetBank(id) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetBank",
            type: "POST",
            data: {id},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}
export function GetRequisition(id) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetRequisition",
            type: "POST",
            data: {id},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}
export function GetLoans(ids) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetLoans",
            type: "POST",
            data: {ids: JSON.stringify(ids)},
            success: (res) => {
                console.log(res)
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function GetVatValues(vat_or_not) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetVatValues",
            type: "POST",
            data: {vat_or_not},
            success: (res) => {
                console.log(res)
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}
export function SelectRequisition() {
    const popup = new Popup("requisition/select_requisition", null, {
        backgroundDismiss: false,
    });

    return new Promise((resolve) => {
        const SelectRequest = (id) => {
            GetRequisition(id).then((employee) => resolve(employee)).finally(() => {
                popup.Remove();
            });
        }

        popup.Create().then((pop) => {
            popup.Show();

            const TABLE = pop.ELEMENT.querySelector(".main-table-container.items-component");

            if (!TABLE) return;

            const TABLE_LISTENER = new TableListener(TABLE);

            TABLE_LISTENER.singularSelection = true;

            TABLE_LISTENER.addListeners({
                none: {
                    view: [],
                    remove: ["select-request"],
                },
                select: {
                    view: ["select-request"],
                },
                selects: {
                    view: [],
                    remove:  ["select-request"],
                },
            })

            TABLE_LISTENER.init();

            TABLE_LISTENER.listen(() => {
                TABLE_LISTENER.addButtonListener([
                    {
                        name: "select-request",
                        action: SelectRequest,
                        single: true
                    },
                ]);
            });

        })
    })
}

export function SelectEmployee() {
    const popup = new Popup("employees/select_employee", null, {
        backgroundDismiss: false,
    });

    return new Promise((resolve) => {
        const SelectRequest = (id) => {
            GetEmployee(id).then((employee) => resolve(employee)).finally(() => {
                popup.Remove();
            });
        }

        function Search(toSearch, filter) {
            SearchRecords("employees", toSearch, filter).then((HTML) => UpdateTable(HTML));
        }

        function UpdateTable(TABLE_HTML) {
            const TABLE_BODY = popup.ELEMENT.querySelector(".main-table-body");

            addHtml(TABLE_BODY, TABLE_HTML);

            ManageTable();
        }

        function ManageTable() {
            const TABLE = popup.ELEMENT.querySelector(".main-table-container.items-component");

            if (!TABLE) return;

            const TABLE_LISTENER = new TableListener(TABLE);

            TABLE_LISTENER.singularSelection = true;

            TABLE_LISTENER.addListeners({
                none: {
                    view: [],
                    remove: ["select-request"],
                },

                select: {
                    view: ["select-request"],
                },
                selects: {
                    view: [],
                    remove:  ["select-request"],
                },
            })

            TABLE_LISTENER.init();

            TABLE_LISTENER.listen(() => {
                TABLE_LISTENER.addButtonListener([
                    {
                        name: "select-request",
                        action: SelectRequest,
                        single: true
                    },
                ]);
            });
        }

        popup.Create().then((pop) => {
            popup.Show();

            ManageTable();

            const searchEngine = popup.ELEMENT.querySelector(".search-engine input[name=search-records]");

            searchEngine.addEventListener("input", () => {
                Search(searchEngine.value)
            })
        })
    })
}

export function SelectLoans(id) {
    const popup = new Popup("loan_manager/select_loans", {id}, {
        backgroundDismiss: false,
    });

    return new Promise((resolve) => {
        const SelectRequest = (ids) => {

            GetLoans(ids).then((loans) => resolve(loans)).finally(()=> {
                popup.Remove();
            });
        }

        popup.Create().then((pop) => {
            popup.Show();

            const TABLE = pop.ELEMENT.querySelector(".main-table-container.items-component");

            if (!TABLE) return;

            const TABLE_LISTENER = new TableListener(TABLE);

            TABLE_LISTENER.singularSelection = false;

            TABLE_LISTENER.addListeners({
                none: {
                    view: [],
                    remove: ["select-request"],
                },
                select: {
                    view: ["select-request"],
                },
                selects: {
                    view:  ["select-request"],
                },
            })

            TABLE_LISTENER.init();

            TABLE_LISTENER.listen(() => {
                TABLE_LISTENER.addButtonListener([
                    {
                        name: "select-request",
                        action: SelectRequest,
                        single: false
                    },
                ]);
            });

        })
    })
}

export function SelectEmployment() {
    const popup = new Popup("employees/select_employment", null, {
        backgroundDismiss: false,
    });

    return new Promise((resolve) => {
        const SelectRequest = (id) => {
            GetEmployment(id).then((employee) => resolve(employee)).finally(() => {
                popup.Remove();
            });
        }

        popup.Create().then((pop) => {
            popup.Show();

            const TABLE = pop.ELEMENT.querySelector(".main-table-container.items-component");

            if (!TABLE) return;

            const TABLE_LISTENER = new TableListener(TABLE);

            TABLE_LISTENER.singularSelection = true;

            TABLE_LISTENER.addListeners({
                none: {
                    view: [],
                    remove: ["select-request"],
                },
                select: {
                    view: ["select-request"],
                },
                selects: {
                    view: [],
                    remove:  ["select-request"],
                },
            })

            TABLE_LISTENER.init();

            TABLE_LISTENER.listen(() => {
                TABLE_LISTENER.addButtonListener([
                    {
                        name: "select-request",
                        action: SelectRequest,
                        single: true
                    },
                ]);
            });

        })
    })
}

export function SelectClient() {
    const popup = new Popup("clients/select_client", null, {
        backgroundDismiss: false,
    });

    return new Promise((resolve) => {
        const SelectRequest = (id) => {
            GetClient(id).then((client) => resolve(client)).finally(() => {
                popup.Remove();
            });
        }

        function Search(toSearch, filter) {
            SearchRecords("clients", toSearch, filter).then((HTML) => UpdateTable(HTML));
        }

        function UpdateTable(TABLE_HTML) {
            const TABLE_BODY = popup.ELEMENT.querySelector(".main-table-body");

            addHtml(TABLE_BODY, TABLE_HTML);

            ManageTable();
        }

        function ManageTable() {
            const TABLE = popup.ELEMENT.querySelector(".main-table-container.items-component");

            if (!TABLE) return;

            const TABLE_LISTENER = new TableListener(TABLE);

            TABLE_LISTENER.singularSelection = true;

            TABLE_LISTENER.addListeners({
                none: {
                    view: [],
                    remove: ["select-request"],
                },
                select: {
                    view: ["select-request"],
                },
                selects: {
                    view: [],
                    remove:  ["select-request"],
                },
            })

            TABLE_LISTENER.init();

            TABLE_LISTENER.listen(() => {
                TABLE_LISTENER.addButtonListener([
                    {
                        name: "select-request",
                        action: SelectRequest,
                        single: true
                    },
                ]);
            });
        }

        popup.Create().then((pop) => {
            popup.Show();

            ManageTable();

            const searchEngine = popup.ELEMENT.querySelector(".search-engine input[name=search-records]");

            searchEngine.addEventListener("input", () => {
                Search(searchEngine.value)
            })
        })
    })
}


export function SelectHoliday(id) {
    const popup = new Popup("client_manager/select_holiday", {id}, {
        backgroundDismiss: false,
    });

    return new Promise((resolve) => {
        const SelectRequest = (ids = []) => {
            Promise.all(ids.map((id) => GetHoliday(id))).then((res)=> {
                resolve(res);
            }).finally(() => popup.Remove());

        }

        function Search(toSearch, filter) {
            SearchRecords("holidays", toSearch, filter).then((HTML) => UpdateTable(HTML));
        }

        function UpdateTable(TABLE_HTML) {
            const TABLE_BODY = popup.ELEMENT.querySelector(".main-table-body");

            addHtml(TABLE_BODY, TABLE_HTML);

            ManageTable();
        }

        function ManageTable() {
            const TABLE = popup.ELEMENT.querySelector(".main-table-container.items-component");

            if (!TABLE) return;

            const TABLE_LISTENER = new TableListener(TABLE);

            TABLE_LISTENER.singularSelection = false;

            TABLE_LISTENER.addListeners({
                none: {
                    view: [],
                    remove: ["select-request"],
                },
                select: {
                    view: ["select-request"],
                },
                selects: {
                    view: ["select-request"],
                    remove:  [],
                },
            })

            TABLE_LISTENER.init();

            TABLE_LISTENER.listen(() => {
                TABLE_LISTENER.addButtonListener([
                    {
                        name: "select-request",
                        action: SelectRequest,
                        single: false
                    },
                ]);
            });
        }

        popup.Create().then((pop) => {
            popup.Show();

            ManageTable();

            const searchEngine = popup.ELEMENT.querySelector(".search-engine input[name=search-records]");

            searchEngine.addEventListener("input", () => {
                Search(searchEngine.value)
            })
        })
    })
}



/// ATTENDANCE

export function GetColumnsTable(tableHeader, tableBody) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetColumnsTable",
            type: "POST",
            data: {tableHeader, tableBody},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function GetAvailablePeriodAttendance(client) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetAvailablePeriodAttendance",
            type: "POST",
            data: {client},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function GetPayrollTableOf(attendance_group) {
    return new Promise((resolve) => {
        Ajax({
            url: "/components/containers/attendance_group/getPayrollTableOf",
            type: "POST",
            data: {attendance_group},
            success: (res) => {
                resolve(res);
            }
        })
    })
}

export function SetAuthentication(type, data) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/SetAuthentication",
            type: "POST",
            data: {type, data: JSON.stringify(data)},
            success: (res) => {
                console.log(res)
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function TryAuthenticate(type, data) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/TryAuthenticate",
            type: "POST",
            data: {type, data: JSON.stringify(data)},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function GetReports(type, data) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/GetReports",
            type: "POST",
            data: {type, data: JSON.stringify(data)},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}

export function ConfirmAuthenticationVerification(email, verification) {
    return new Promise((resolve) => {
        Ajax({
            url: "/api/post/ConfirmAuthenticationVerification",
            type: "POST",
            data: {email, verification},
            success: (res) => {
                try {
                    resolve(JSON.parse(res));
                } catch (e) {
                    resolve(null);
                }
            }
        })
    })
}