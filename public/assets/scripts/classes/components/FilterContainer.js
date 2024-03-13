import {
    Ajax,
    CreateElement,
    DisableScroll,
    EnableScroll,
    ExecuteFn,
    HideShowComponent, SetNewComboItems,
    ToData
} from "../../modules/component/Tool.js";
import {CONTAINERS} from "../../modules/app/Application.js";
import {GetColumnsTable} from "../../modules/app/Administrator.js";

export  class FilterContainer {
    constructor(DATA = {}, OPTIONS = {}) {
        this.DATA = {...this.GetDefaultData(),...DATA};
        this.OPTIONS = this.InitOptions(OPTIONS);
        this.PARENT = this.FindMyParent();
        this.ELEMENT = null;
        this.LISTENERS = {};
        this.COLUMNS = [];
    }

    async Load(header, body) {
        this.COLUMNS = await GetColumnsTable(header, body);

        this.PlaceDatas();
    }

    GetDefaultData() {
        return {
            primary: 'This is my Popup',
            secondary: 'Supporting Details',
        }
    }


    AddListeners(listeners = {onYes: null, onNo: null, onCancel: null, onShow: null, onHide: null}) {
        this.LISTENERS = {
            ...listeners,
            ...this.LISTENERS
        }
    }

    InitOptions(option = {}) {
        return {
            ...option,
            backgroundDismiss: option.backgroundDismiss ?? false,
            removeOnDismiss: option.removeOnDismiss ?? false,
        };
    }

    FindMyParent() {
        const parentID = "big-pipes-container";
        const parent = document.querySelector("#" + parentID);

        const newParent = CreateElement({
            el: "section",
            id: parentID,
        });

        if (!parent) {
            CONTAINERS.popup.appendChild(newParent);
        }

        return parent ?? newParent;
    }

    Create() {
        const pop = this;

        return new Promise((resolve) => {

            Ajax({
                url: `/components/popup/system/createFilterPopup`,
                type: "POST",
                data: ToData({data: JSON.stringify(this.DATA), options: JSON.stringify(this.OPTIONS)}),
                success: (popup) => {
                    pop.Place(popup);
                    resolve(pop);
                },
            });
        });
    }


    Place(popup, node = false) {
        if (popup && this.PARENT) {
            this.ELEMENT = node
                ? this.CreateDefaultElement(popup)
                : CreateElement({
                    el: "SPAN",
                    html: popup,
                });

            this.PARENT.appendChild(this.ELEMENT);

            this.Listeners();

            this.Show();

            ExecuteFn(this.LISTENERS, "onPlace");
        }
    }

    Listeners() {
        if (this.PARENT && this.ELEMENT) {
            const main = this;
            const background = this.ELEMENT.querySelector(".popup-background");
            const closeBtn = this.ELEMENT.querySelector(".close-popup");

            const yesBtn = this.ELEMENT.querySelector(".yes-btn");
            const noBtn = this.ELEMENT.querySelector(".no-btn");
            const cancelBtn = this.ELEMENT.querySelector(".cancel-btn");

            const newFilterCol = this.ELEMENT.querySelector(".add-new-filter-column");

            background.addEventListener("click", () => {
                if (this.OPTIONS.backgroundDismiss) {
                    if (this.OPTIONS.removeOnDismiss) {
                        this.Remove();
                    } else {
                        this.Hide();
                    }
                }
            });

            if (closeBtn) {
                closeBtn.addEventListener("click", () => {
                    this.Remove();
                });
            }

            if (yesBtn) {
                yesBtn.addEventListener("click", () => {
                    ExecuteFn(this.LISTENERS, "onYes");

                    this.Remove();
                });
            }

            if (noBtn) {
                noBtn.addEventListener("click", () => {
                    ExecuteFn(this.LISTENERS, "onNo");

                    this.Remove();
                });
            }

            if (cancelBtn) {
                cancelBtn.addEventListener("click", () => {
                    ExecuteFn(this.LISTENERS, "onCancel");

                    this.Remove();
                });
            }

            newFilterCol.addEventListener("click", function () {
                main.CreateNewFilterColumn();
            })
        }
    }

    async CreateNewFilterColumn() {
        const parent = this.ELEMENT.querySelector(".filter-column .main-content");

        return new Promise((resolve) => {
            Ajax({
                url: `/components/popup/system/createNewFilterColumn`,
                type: "POST",
                success: (data) => {
                    resolve(data);
                },
            });
        }).then((res) => {
            const fragment = document.createDocumentFragment();
            const span = CreateElement({
                el: "SPAN",
                html: res
            })

            fragment.appendChild(span);

            parent.append(fragment);

            this.PlaceDatas();


        })

    }

    Show() {
        if (!this.ELEMENT) return false;

        DisableScroll();
        HideShowComponent(this.ELEMENT, true);
        ExecuteFn(this.LISTENERS, "onShow");

        return this.ELEMENT;
    }

    Hide() {
        if (!this.ELEMENT) return false;

        EnableScroll();
        HideShowComponent(this.ELEMENT, false);
        ExecuteFn(this.LISTENERS, "onHide");
    }

    Remove() {
        if (!this.ELEMENT) return false;

        EnableScroll()

        this.ELEMENT.remove();

        ExecuteFn(this.LISTENERS, "onRemove");
    }

    PlaceDatas() {
        // place filter by columns

        const threeInput = this.ELEMENT.querySelectorAll(".filter-column .three-input-container");


        for (const TI of threeInput) {
            const combo = TI.querySelector(".custom-combo-box");
            const operator = TI.querySelector("input[name=operator]");
            const value = TI.querySelector("input[name=value]");

            SetNewComboItems(combo, this.COLUMNS.header);
            
            operator.addEventListener("change", function () {
                const validOperators = ["==", "===", "<=", ">=", ">", "<"];
                const isValid = validOperators.includes(operator.value.trim());

                if (!isValid) {
                    operator.value = "==";
                }
            })

        }
    }
}

export default FilterContainer;