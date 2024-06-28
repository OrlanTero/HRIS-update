import {SidePicker} from "../../../classes/components/SidePicker.js";
import AlertPopup, {AlertTypes} from "../../../classes/components/AlertPopup.js";
import {EditRecord, RemoveRecordsBatch, UploadFileFromFile} from "../../../modules/app/SystemFunctions.js";
import {NewNotification, NotificationType} from "../../../classes/components/NotificationPopup.js";
import {AUTHENTICATION_TYPE, SetAuthentication} from "../../../modules/app/Administrator.js";
import Popup from "../../../classes/components/Popup.js";
import {GetComboValue, ListenToForm, MakeID, ManageComboBoxes} from "../../../modules/component/Tool.js";
import {PINCodeEditor} from "../../../classes/components/PINCodeEditor.js";


function DisableAuthentication() {
    return new Promise((resolve) => {
        const popup = new AlertPopup({
            primary: "Disable Authentication?",
            secondary: `Remove Auth`,
            message: "By Disabling Authentication, you allow the system to be open widely on your computer"
        }, {
            alert_type: AlertTypes.YES_NO,
        });

        popup.AddListeners({
            onYes: () => {
                SetAuthentication(AUTHENTICATION_TYPE.NO, []).then((res) => {
                    NewNotification({
                        title: res.code === 200 ? 'Success' : 'Failed',
                        message: res.code === 200 ? 'Successfully Changed Authentication' : 'Task Failed to perform!'
                    }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                    popup.Remove();

                    resolve();
                });
            }
        })

        popup.Create().then(() => { popup.Show() })
    })
}

function SetPINAuthentication() {
    return new Promise((resolve) => {
        const popup = new Popup("user_authentication/setPin", {}, {
            backgroundDismiss: false,
        });

        popup.Create().then(((pop) => {
            popup.Show();

            const form = pop.ELEMENT.querySelector("form.form-control");
            const PINEDITOR = new PINCodeEditor(pop.ELEMENT.querySelector(".pin-code-editor"));

            const check = ListenToForm(form, function (data) {
                SetAuthentication(AUTHENTICATION_TYPE.PIN_AUTHENTICATION, {pin: data['pin-code']}).then((res => {
                    NewNotification({
                        title: res.code === 200 ? 'Success' : 'Failed',
                        message: res.code === 200 ? 'Successfully Changed Authentication' : 'Task Failed to perform!'
                    }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                    pop.Remove();

                    resolve();

                }));
            },[],[{input: "pin-code", min: 6}])

            PINEDITOR.listens();

            PINEDITOR.addListeners({
                onChange: (pin) => {
                    check(true);
                }
            });

        }))
    })
}

function SetUPassAuthentication() {
    return new Promise((resolve) => {
        const popup = new Popup("user_authentication/setUsernamePassword", {}, {
            backgroundDismiss: false,
        });

        popup.Create().then(((pop) => {
            popup.Show();

            const form = pop.ELEMENT.querySelector("form.form-control");

            ListenToForm(form, function (data) {
                SetAuthentication(AUTHENTICATION_TYPE.USERNAME_PASSWORD, data).then(res => {
                    NewNotification({
                        title: res.code === 200 ? 'Success' : 'Failed',
                        message: res.code === 200 ? 'Successfully Changed Authentication' : 'Task Failed to perform!'
                    }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                    pop.Remove();

                    resolve();

                })
            })

        }))
    })
}

function EditProfile() {
    return new Promise((resolve) => {
        const popup = new Popup("user_authentication/editProfile", {}, {
            backgroundDismiss: false,
        });

        popup.Create().then(((pop) => {
            popup.Show();

            const form = pop.ELEMENT.querySelector("form.form-control");

            ListenToForm(form, async function (data) {
                if (data.company_logo.size > 0) {
                    const upload = await UploadFileFromFile(data.company_logo, MakeID(5), "public/assets/media/uploads/");

                    data.company_logo = upload.body.path;
                } else {
                    delete data.company_logo;

                }

                if (data.main_logo.size > 0) {
                    const upload = await UploadFileFromFile(data.main_logo, MakeID(5), "public/assets/media/uploads/");

                    data.main_logo = upload.body.path;
                } else {
                    delete data.main_logo;
                }

                EditRecord("profile", {data: JSON.stringify(data)}).then((res) => {
                    NewNotification({
                        title: res.code === 200 ? 'Success' : 'Failed',
                        message: res.code === 200 ? 'Successfully Updated' : 'Task Failed to perform!'
                    }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                    pop.Remove();

                    resolve();
                })
            },['company_logo', 'main_logo'])

        }))
    })
}

function SetEmailAuthentication() {
    return new Promise((resolve) => {
        const popup = new Popup("user_authentication/setEmail", {}, {
            backgroundDismiss: false,
        });

        popup.Create().then(((pop) => {
            popup.Show();

            const form = pop.ELEMENT.querySelector("form.form-control");

            ListenToForm(form, function (data) {
                SetAuthentication(AUTHENTICATION_TYPE.EMAIL_AUTHENTICATION, data).then((res => {
                    NewNotification({
                        title: res.code === 200 ? 'Success' : 'Failed',
                        message: res.code === 200 ? 'Successfully Changed Authentication' : 'Task Failed to perform!'
                    }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                    pop.Remove();

                    resolve();

                }));
            })

        }))
    })
}


function ManageButtons() {
    const disableBtn = document.querySelector(".disable-authentication");
    const pinBtn = document.querySelector(".set-pin");
    const unameBtn = document.querySelector(".set-uname-pass");
    const emailBtn = document.querySelector(".set-email");
    const editBtn = document.querySelector(".edit-profile-btn");


    disableBtn.addEventListener("click", function () {
        DisableAuthentication().then((r) => location.reload())
    })

    pinBtn.addEventListener("click", function () {
        SetPINAuthentication().then((r) => location.reload())
    })

    unameBtn.addEventListener("click", function () {
        SetUPassAuthentication().then((r) => location.reload())
    })

    emailBtn.addEventListener("click", function () {
        SetEmailAuthentication().then((r) => location.reload())
    })

    editBtn.addEventListener("click", function () {
        EditProfile().then(() => location.reload());
    })
}

function Init() {
    const sideBar = document.querySelector(".profile-sidebar");
    const authSideBar = document.querySelector(".authentication-picker");

    const SIDEBARCON = new SidePicker(sideBar);
    const AUTHSIDEBAR = new SidePicker(authSideBar);

    SIDEBARCON.listens();
    AUTHSIDEBAR.listens();

    ManageButtons();
}

Init();