import bs_modal from "corejs/bootstrap_modal";
class InitializeVariables {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this.wrapper = this.element.find(".form-wrapper");
    this.modalWrapper = this.element.find("#extras-features");
    this.changeEmailBox = this.modalWrapper.find("#modal-box-email");
    this.changeEmailForm = this.modalWrapper.find("#change-email-frm");
    this.changeEmailButton = this.modalWrapper.find("#submitBtnEmail");
    this.bs_modals = new bs_modal([
      "modal-box-email",
      "modal-box-change-address",
      "add_address-box",
      "modal-box-email",
      "modal-box-shipping",
      "payment-box",
    ])._init();
    this.changeShippoingBox = this.modalWrapper.find("#modal-box-shipping");
    this.changeShippingForm = this.modalWrapper.find("#shipping-select-frm");
    this.changeShippingButton = this.modalWrapper.find("#submitBtnShipping");
    this.modifyAddressBox = this.modalWrapper.find("#modal-box-change-address");
    this.modifyAdressForms = this.modalWrapper.find(".modify-frm form");
    this.addAdressForm = this.modalWrapper.find("#add-address-frm");
    this.modifyAddressButton = this.modalWrapper.find(".modify");
    this.url_addr;
    this.delivery_addr;

    this.frmJQ = this.element.find("#checkout-frm");
    this.form = document.querySelector("[data-multi-step]");
    this.prevBtns = document.querySelectorAll(".btn-prev");
    this.nextBtns = document.querySelectorAll(".btn-next");
    this.progress = document.querySelector(".progress");
    this.formSteps = document.querySelectorAll("[data-step]");
    this.progressSteps = document.querySelectorAll(".progress-step");
    this.extraSection = document.querySelector("#extras-features");
    this.pay = document.querySelector(".btn-pay");
    this.paymentGateway = document.querySelectorAll(".payment-gateway");
    this.chkWrapper = document.querySelector(".page-content");
    this.contact = {
      lastName: document.getElementById("chk-lastName"),
      firstName: document.getElementById("chk-firstName"),
      email: document.getElementById("chk-email"),
      user_id: document.getElementById("chk-user_id"),
    };
    return this;
  };
}
export default new InitializeVariables($("#main-site"))._init();
