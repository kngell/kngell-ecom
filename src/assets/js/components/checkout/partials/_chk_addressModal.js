import { Call_controller } from "corejs/form_crud";
import bs_modal from "corejs/bootstrap_modal";
import input from "../../../core/inputErrManager";
class ChangeAddress {
  constructor(element) {
    this.element = element;
  }
  _init = (variables) => {
    this.var = variables;
    return this;
  };
  _add_deliveryAddress = () => {
    const phpModal = this;

    phpModal.var.wrapper.on("click", ".adresse-de-livraison", function (e) {
      const elem = $(this);
      phpModal.var.bs_modals.then((modal) => {
        modal["add_address-box"]["selector"].addEventListener(
          "shown.bs.modal",
          (e) => {
            phpModal.var.delivery_addr = "adresse-de-livraison";
          }
        );
        phpModal.var.url_addr = "bill-to-address";
      });
    });
  };
  _autoFillAddAddressModalInput = () => {
    const phpModal = this;
    if (phpModal.var.modifyAdressForms.length > 0) {
      phpModal.var.modalWrapper.on("click", ".modify-frm form", function (e) {
        e.preventDefault();
        phpModal.var.modifyAddressButton.html("Please wait...");
        const data = {
          url: "checkout_process_change/autoFillInput",
          frm: $(this),
          frm_name: $(this).attr("id"),
        };
        phpModal.var.delivery_addr = "address-book-wrapper";
        Call_controller(data, (response) => {
          phpModal.var.modifyAddressButton.html("Modify");
          if (response.result == "success") {
            phpModal.var.bs_modals.then((modal) => {
              modal["add_address-box"].show();
              document
                .getElementById("add_address-box")
                .addEventListener("shown.bs.modal", function () {
                  let elemAry = {};
                  $.each(
                    phpModal.var.addAdressForm[0].elements,
                    function (index, elem) {
                      if (Object.keys(response.msg).includes(elem.id)) {
                        elemAry[elem.id] = response.msg[elem.id];
                        if (elem.tagName === "SELECT") {
                          let option = document.createElement("option");
                          option.value = response.msg.ab_id;
                          option.text = response.msg[elem.id];
                          elem.add(option, null);
                        } else {
                          elem.value = response.msg[elem.id];
                        }
                      }
                    }
                  );
                  const diff = Object.entries(response.msg).reduce(
                    (acc, [key, value]) => {
                      if (
                        !Object.values(response.msg).includes(value) ||
                        !Object.values(elemAry).includes(value)
                      )
                        acc[key] = value;
                      return acc;
                    },
                    {}
                  );
                  for (let [key, value] of Object.entries(diff)) {
                    input.inputHidden(
                      "input",
                      key,
                      value,
                      phpModal.var.addAdressForm
                    );
                  }
                });
            });
          } else {
          }
        });
      });
    }
  };
  _changebillingAddress = () => {
    const phpModal = this;
    phpModal.var.wrapper.on(
      "click",
      "input[name=prefred_billing_addr]",
      function (e) {
        if ($(this).attr("id") === "checkout-billing-address-id-2") {
          phpModal.var.bs_modals.then((modal) => {
            modal["modal-box-change-address"].show();
            phpModal.var.url_addr = "bill-to-address";
          });
        }
      }
    );
  };
  _update_selectedAddress = () => {
    const phpModal = this;

    phpModal.var.wrapper.on(
      "click",
      ".change-bill__btn, .change-ship__btn",
      function (e) {
        if ($(this).hasClass("change-bill__btn")) {
          phpModal.var.url_addr = "bill-to-address";
        } else {
          phpModal.var.url_addr = "ship-to-address";
        }
      }
    );
    phpModal.var.modalWrapper.on(
      "submit",
      ".card--active .select-frm form",
      function (e) {
        e.preventDefault();
        const data = {
          url: "checkout_process_change/getAddress",
          frm: $(this),
          frm_name: $(this).attr("class"),
          addr: phpModal.var.url_addr,
        };
        Call_controller(data, (response) => {
          if (response.result == "success") {
            for (var key in response.msg) {
              $("." + key).html(response.msg[key]);
            }
          } else {
          }
        });
      }
    );
  };
  _save_changes = () => {
    const phpModal = this;
    phpModal.var.modalWrapper.on("submit", "#add-address-frm", function (e) {
      e.preventDefault();
      const data = {
        url: "checkout_process_change/saveAddress",
        frm: $(this),
        frm_name: $(this).attr("id"),
        addr:
          phpModal.var.delivery_addr != "undefined"
            ? phpModal.var.delivery_addr
            : "",
      };
      Call_controller(data, (response) => {
        if (response.result == "success") {
          phpModal.var.bs_modals.then((modal) => {
            modal["add_address-box"].hide();
          });
          for (var key in response.msg) {
            $("." + key).html(response.msg[key]);
          }
        } else {
        }
      });
    });
  };
  _address_navigation = () => {
    const phpModal = this;
    phpModal.var.modalWrapper.on(
      "click",
      "#modal-box-change-address .card",
      function (e) {
        $(this)
          .addClass("card--active")
          .parent()
          .siblings()
          .children()
          .removeClass("card--active");
      }
    );
    phpModal.var.wrapper.on("click", ".add-address .card", function (e) {
      $(this)
        .addClass("card--active")
        .parent()
        .siblings()
        .children()
        .removeClass("card--active");
    });
  };
  _close_addressBookModal = () => {
    const phpModal = this;
    phpModal.var.modalWrapper.on("click", ".closeAddress", function (e) {
      e.preventDefault();
      phpModal.var.bs_modals.then((modal) => {
        modal["modal-box-change-address"].hide();
        modal["modal-box-change-address"]["selector"].addEventListener(
          "hidden.bs.modal",
          function (e) {
            phpModal.var.modalWrapper
              .find(".card--active .manage .select-frm form")
              .submit();
          }
        );
      });
    });
  };
}
export default new ChangeAddress($("#main-site"));
