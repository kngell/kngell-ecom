import StripeAPI from "corejs/stripeAPIClient";
import { Call_controller } from "corejs/form_crud";
import input from "corejs/inputErrManager";
import _chk_change_emailModal from "./partials/_chk_change_emailModals";
import _chk_addressModal from "./partials/_chk_addressModal";
import _chk_shipping_modeChange from "./partials/_chk_shipping_modeChange";
import variables from "./partials/_chk_init_variables";
import { csrftoken, frm_name } from "corejs/config";
// import _chk_success_msg from "./partials/_chk_success_msg";
// import _credit_card from "../credit_card/_card";
class Checkout {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this.name =
      this.element.querySelector("#chk-firstName").value +
      " " +
      this.element.querySelector("#chk-lastName").value;
    this.cardError = this.element.querySelector("#card_error");
    this.cardButton = this.element.querySelector("#complete-order");
    this.form = this.element.querySelector("#checkout-frm");
    this._setupEvents();
  };
  _setupEvents = () => {
    var phpCkt = this;
    let formStepNum = 0;
    let btnNext = null;
    let btnPrev = null;

    const chg_addr = _chk_addressModal._init(variables);
    /** Change Email */
    _chk_change_emailModal._init(variables)._changeEmail();
    /** Modify Addresses */
    chg_addr._modifyAddress();
    chg_addr._add_Address();
    chg_addr._changebillingAddress();
    chg_addr._save_changes();
    chg_addr._active_address();
    chg_addr._close_addressBookModal();
    chg_addr._update_navigationAddress();
    chg_addr._reset_modals();
    chg_addr._delete_address();
    /** Chande Shipping Mode */
    _chk_shipping_modeChange._init(variables)._changeShipping();

    /** Chck Card holder */
    phpCkt.element.querySelector("#cc_holder").value = phpCkt.name;

    variables.modalWrapper.on(
      "click",
      ".buttons-grps .close-btn",
      function (e) {
        window.location.reload();
      }
    );
    /**
     * reset Invalid Input
     */
    input.removeInvalidInput(variables.frmJQ);
    /** Credit Card */
    // _credit_card._init();
    /**
     * Init stripe JS
     * ========================================================================
     */

    const stripeApi = new StripeAPI({
      api_key: variables.chkWrapper.querySelector("#stripe_key").value,
      cardHolder: phpCkt.name,
      cardElement: "#cc_number",
      cardExp: "#cc_Expiry",
      cardCvc: "#cc_cvv",
      cardButton: phpCkt.cardButton,
      cardError: phpCkt.cardError,
      baseClasses: "form-control custom-font",
    })._init();

    /** pay logic */
    phpCkt.form.addEventListener("submit", function (e) {
      e.preventDefault();
      stripeApi._createPayment().then((mod) => {
        const data = {
          url: "checkout_payments/pay",
          frm_name: $(this).attr("id"),
          frm: $(this),
          paymentMethod: mod,
        };
        phpCkt.cardButton.innerText = "Please wait...";
        Call_controller(data, (response) => {
          phpCkt.cardButton.innerText = "Pay";
          if (response.result == "success") {
            variables.bs_modals.then((modal) => {
              modal["payment-box"].hide();
              variables.modalWrapper.append(response.msg);
              const sucess_popup = document.querySelector(".popup-modal");
              const sucess_popup_btn_close = document.querySelector(
                ".popup-modal .close-btn"
              );
              sucess_popup.classList.add("active");
              sucess_popup_btn_close.addEventListener("click", () => {
                sucess_popup.classList.remove("active");
              });
            });
          }
        });
      });
    });

    /** Navigation */
    variables.progressSteps.forEach((step, i) => {
      step.onclick = () => {
        formStepNum = i + 1;
      };
    });
    phpCkt.updateBtnPrev = () => {
      variables.nextBtns.forEach((btn) => {
        if (btn.disabled) {
          btn.disabled = false;
        }
      });
      if (btnPrev != null) {
        if (formStepNum <= 0) {
          btnPrev.disabled = true;
          formStepNum = 0;
        } else if (btnPrev.disabled == true) {
          btnPrev.disabled = false;
        }
      }
    };
    phpCkt.updateBtnNext = () => {
      variables.prevBtns.forEach((btn) => {
        if (btn.disabled) {
          btn.disabled = false;
        }
      });
      if (btnNext != null) {
        if (formStepNum > variables.formSteps.length - 1 && btnNext != null) {
          btnNext.innerText = "Place Order";
          variables.bs_modals.then((modal) => {
            modal["payment-box"].show();
          });
          // btnNext.disabled = true;
          formStepNum = variables.formSteps.length - 1;
        } else if (btnNext.disabled == true) {
          btnNext.disabled = false;
        }
      }
    };
    variables.nextBtns.forEach((btn, idx) => {
      btn.addEventListener("click", () => {
        formStepNum++;
        btnNext = btn;
        const shMode = variables.chkWrapper.querySelector(
          ".radio-check__wrapper input[name=sh_name]:checked"
        ).id;
        const shModeName =
          idx == 1
            ? variables.chkWrapper.querySelector(
                ".radio-check__wrapper input[name=sh_name]:checked"
              )
            : "";

        const data = {
          url: "checkout_navigation/validate",
          page: idx,
          csrftoken: csrftoken,
          frm_name: frm_name,
          ab_id: phpCkt._addressBookId(idx),
          shc_id: parseInt(shMode.replace(/[^0-9]/g, "")),
          sh_name:
            idx == 1
              ? shModeName.parentNode.querySelector(".radio__text").innerText
              : "",
          addr: phpCkt._addr_url(idx),
          addrType: phpCkt._addrType(idx),
        };
        const additionalData = {
          lastName: variables.contact.lastName.value,
          firstName: variables.contact.firstName.value,
          email: variables.contact.email.value,
          user_id: variables.contact.user_id.value,
        };
        btn.innerText = "Please wait...";
        Call_controller({ ...data, ...additionalData }, (response) => {
          btn.innerText = "Next";
          if (response.result == "success") {
            phpCkt.updateBtnNext();
            phpCkt.updateFormSteps();
            phpCkt.updateProgressBar();
            if (idx == 0 || idx == 2) {
              for (let [key, value] of Object.entries(response.msg)) {
                $("." + key).html(value);
              }
            }
            if (idx == 1) {
              variables.chkWrapper.querySelector(
                ".shipping_method .method_title"
              ).innerHTML = response.msg.name;
              variables.chkWrapper.querySelector(
                ".shipping_method .price"
              ).innerHTML = response.msg.price;
              variables.chkWrapper.querySelector(
                ".modal-title .price"
              ).innerHTML = response.msg.ttc;
              variables.chkWrapper
                .querySelectorAll(".total")
                .forEach((total) => {
                  total.innerHTML = response.msg.cart;
                });
            }
          } else {
            if (response.result == "error-field") {
              input.error(phpCkt.frmJQ, response.msg, 30);
            } else {
              variables.frmJQ.find(".alertErr").html(response.msg);
            }
          }
        });
      });
    });
    variables.prevBtns.forEach((btn, idx) => {
      btn.addEventListener("click", () => {
        formStepNum--;
        btnPrev = btn;
        phpCkt.updateBtnPrev();
        phpCkt.updateFormSteps();
        phpCkt.updateProgressBar();
      });
    });
    phpCkt.updateFormSteps = () => {
      variables.formSteps.forEach((formStep) => {
        formStep.classList.contains("form-step-active") &&
          formStep.classList.remove("form-step-active");
      });
      variables.formSteps[formStepNum].classList.add("form-step-active");
    };
    phpCkt.updateProgressBar = () => {
      variables.progressSteps.forEach((progressStep, idx) => {
        if (idx < formStepNum + 1) {
          progressStep.classList.add("progress-step-active");
        } else {
          progressStep.classList.remove("progress-step-active");
        }
      });
      const progressStepActive = phpCkt.element.querySelectorAll(
        ".progress-step.progress-step-active"
      );
      variables.progress.style.width =
        ((progressStepActive.length - 1) /
          (variables.progressSteps.length - 1)) *
          100 +
        "%";
    };
    phpCkt._addr_url = (idx) => {
      switch (idx) {
        case 0:
          return {
            ship: "ship-to-address",
            bill: "bill-to-address",
            modals: "modal-address",
            chkFrm: "delivery-address-content",
          };
        case 2:
          return {
            bill: "bill-to-address",
            modals: "modal-address",
            chkFrm: "delivery-address-content",
          };
          break;

        default:
          break;
      }
    };
    phpCkt._addressBookId = (idx) => {
      if (idx == 0) {
        return variables.chkWrapper.querySelector(
          ".card--active input[name=ab_id]"
        )
          ? variables.chkWrapper.querySelector(
              ".card--active input[name=ab_id]"
            ).value
          : "";
      }
      if (idx == 2) {
        const elem = variables.chkWrapper.querySelector(
          "#order-billing-address input:checked"
        );
        if (elem.id === "checkout-billing-address-id-1") {
          return variables.chkWrapper.querySelector(
            ".card--active input[name=ab_id]"
          ).value;
        } else {
          return variables.modalWrapper
            .find("#modal-box-change-address .card--active input[name=ab_id]")
            .val();
        }
      }
    };
    phpCkt._addrType = (idx) => {
      switch (idx) {
        case 2:
          return "billing";
          break;

        default:
          return "delivery";
          break;
      }
    };
    // phpCkt.pay.addEventListener("click", () => {
    //   modals.then((modal) => {
    //     modal["payment-box"].show();
    //   });
    // });
    // phpCkt.paymentGateway.forEach((gateway) => {
    //   gateway.addEventListener("click", function () {});
    // });
  };
}
export default new Checkout(document.getElementById("main-site"))._init();
