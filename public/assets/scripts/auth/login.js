import PINCodeEditor from "../classes/components/PINCodeEditor.js";
import {
    AUTHENTICATION_TYPE,
    ConfirmAuthenticationVerification,
    SetAuthentication,
    TryAuthenticate
} from "../modules/app/Administrator.js";
import {ApplyError, ListenToForm} from "../modules/component/Tool.js";
import {NewNotification, NotificationType} from "../classes/components/NotificationPopup.js";
import Popup from "../classes/components/Popup.js";

function ConfirmVerification(email) {
   return new Promise((resolve)=> {
       const popup = new Popup("user_authentication/confirmVerification", {}, {
           backgroundDismiss: false,
       });

       popup.Create().then(((pop) => {
           popup.Show();

           const form = pop.ELEMENT.querySelector("form.form-control");
           const PINEDITOR = new PINCodeEditor(pop.ELEMENT.querySelector(".pin-code-editor"));

           const check = ListenToForm(form, function (data) {
               ConfirmAuthenticationVerification( email, data['pin-code']).then((res => {
                   NewNotification({
                       title: res.code === 200 ? 'Success' : 'Failed',
                       message: res.message
                   }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                   if (res.code === 200) {
                       pop.Remove();

                       resolve();
                   } else {
                       PINEDITOR.shake();
                       PINEDITOR.reset();
                   }


               }));
           },[],[{input: "pin-code", min: 6}])

           PINEDITOR.listens();

           PINEDITOR.addListeners({
               onChange: (pin) => {
                   check(true);
               }
           });

       }));
   })
}

function Init() {
    const editor = document.querySelector(".pin-code-editor");
    const form = document.querySelector("form.form-control");

    const inputs = form.querySelectorAll('input');

    if (editor) {
        const PINEDITOR = new PINCodeEditor(editor);

        PINEDITOR.listens();

        PINEDITOR.addListeners({
            onChange: (PIN) => {
                if (PIN.length === 6) {
                    TryAuthenticate(AUTHENTICATION_TYPE.PIN_AUTHENTICATION, {pin: PIN}).then((res) => {
                        if (res.code === 200) {
                            location.replace('/')
                        } else {
                            PINEDITOR.shake();
                            PINEDITOR.reset();
                        }
                    })
                }
            }
        });
    }
    
    ListenToForm(form, function (data) {
        const email = data['email_address'];

        if (!email) {
            TryAuthenticate(AUTHENTICATION_TYPE.USERNAME_PASSWORD, data).then((res) => {
                if (res.code === 200) {
                    location.replace('/')
                } else {
                    ApplyError(['username', 'password'],inputs);
                    document.querySelector('input[name=password]').value = "";
                }
            })
        } else {
            TryAuthenticate(AUTHENTICATION_TYPE.EMAIL_AUTHENTICATION, data).then((res) => {
                if (res.code === 200) {
                    NewNotification({
                        title: res.code === 200 ? 'Success' : 'Failed',
                        message: res.code === 200 ? 'Successfully Sent Verification' : res.message
                    }, 3000, res.code === 200 ? NotificationType.SUCCESS : NotificationType.ERROR)

                    ConfirmVerification(data.email_address).then((res) => {
                        location.replace('/');
                    })

                } else {
                    ApplyError(['email'],inputs);
                }
            })
        }
    })
}

Init();