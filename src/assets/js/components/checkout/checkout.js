import bs_modal from "corejs/bootstrap_modal";
import StripeAPI from "corejs/stripeAPIClient";
class Checkout {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.form = this.element.querySelector("[data-multi-step]");
    this.prevBtns = this.element.querySelectorAll(".btn-prev");
    this.nextBtns = this.element.querySelectorAll(".btn-next");
    this.progress = this.element.querySelector(".progress");
    this.formSteps = this.element.querySelectorAll("[data-step]");
    this.progressSteps = this.element.querySelectorAll(".progress-step");
    this.extraSection = this.element.querySelector("#extras-features");
    this.pay = document.querySelector(".btn-pay");
    this.paymentGateway = this.element.querySelectorAll(".payment-gateway");
    this.wrapper = document.querySelector(".page-content");
  };
  _setupEvents = () => {
    var phpCkt = this;
    let formStepNum = 0;
    let btnNext = null;
    let btnPrev = null;
    const modals = new bs_modal(["payment-box"])._init();
    /**
     * Init stripe JS
     * ========================================================================
     */
    const stripeApi = new StripeAPI({
      api_key: phpCkt.wrapper.querySelector("#stripe_key").value, // ok
      cardHolderLname: document.getElementById("chk-lastName"), //ok
      cardHolderFname: document.getElementById("chk-firstName"), //ok
      cardElement: document.getElementById("card-element"),
      cardExp: document.getElementById("card-exp"), //ok
      cardCvc: document.getElementById("card-cvc"), //ok
      cardError: document.getElementById("card-error"), //ok
      cardErrorID: "#card-error",
      cardButton: document.getElementById("complete-order"), //ok
      cardButtonID: "#complete-order",
      responseError: document.getElementById("stripeErr"),
    });
    stripeApi._create_cardElements();

    phpCkt.progressSteps.forEach((step, i) => {
      step.onclick = () => {
        formStepNum = i + 1;
      };
    });
    phpCkt.updateBtnPrev = () => {
      phpCkt.nextBtns.forEach((btn) => {
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
      phpCkt.prevBtns.forEach((btn) => {
        if (btn.disabled) {
          btn.disabled = false;
        }
      });
      if (btnNext != null) {
        if (formStepNum > phpCkt.formSteps.length - 1 && btnNext != null) {
          btnNext.disabled = true;
          formStepNum = phpCkt.formSteps.length - 1;
        } else if (btnNext.disabled == true) {
          btnNext.disabled = false;
        }
      }
    };
    phpCkt.nextBtns.forEach((btn, idx) => {
      btn.addEventListener("click", () => {
        formStepNum++;
        btnNext = btn;
        phpCkt.updateBtnNext();
        phpCkt.updateFormSteps();
        phpCkt.updateProgressBar();
      });
    });
    phpCkt.prevBtns.forEach((btn, idx) => {
      btn.addEventListener("click", () => {
        formStepNum--;
        btnPrev = btn;
        phpCkt.updateBtnPrev();
        phpCkt.updateFormSteps();
        phpCkt.updateProgressBar();
      });
    });
    phpCkt.updateFormSteps = () => {
      phpCkt.formSteps.forEach((formStep) => {
        formStep.classList.contains("form-step-active") &&
          formStep.classList.remove("form-step-active");
      });
      phpCkt.formSteps[formStepNum].classList.add("form-step-active");
    };
    phpCkt.updateProgressBar = () => {
      phpCkt.progressSteps.forEach((progressStep, idx) => {
        if (idx < formStepNum + 1) {
          progressStep.classList.add("progress-step-active");
        } else {
          progressStep.classList.remove("progress-step-active");
        }
      });
      const progressStepActive = phpCkt.element.querySelectorAll(
        ".progress-step.progress-step-active"
      );
      phpCkt.progress.style.width =
        ((progressStepActive.length - 1) / (phpCkt.progressSteps.length - 1)) *
          100 +
        "%";
    };

    phpCkt.pay.addEventListener("click", () => {
      modals.then((modal) => {
        modal["payment-box"].show();
      });
    });
    // phpCkt.paymentGateway.forEach((gateway) => {
    //   gateway.addEventListener("click", function () {});
    // });
  };
}
export default new Checkout(document.getElementById("main-site"))._init();
