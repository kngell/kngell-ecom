import { Call_controller } from "corejs/form_crud";
import input from "corejs/inputErrManager";
class ChangeAddress {
  constructor(element) {
    this.element = element;
  }
  _init = (variables) => {
    this.var = variables;
    return this;
  };
  _open_add_address = (elem) => {
    const phpModal = this;
    if (elem.hasClass("addAddress")) {
      const activeChk = elem.parents(
        ".address-content.delivery-address-content"
      );
      if (activeChk && activeChk.length > 0) {
        const active = activeChk.find(".card--active");
        if (active && active.length == 0) {
          phpModal.var.modalWrapper.find("#principale").val("Y");
          phpModal.var.addrType = "delivery";
        }
      }
    }
    if (elem.hasClass("change-ship__btn")) {
      phpModal.var.addAdressForm.find("#principale").val("Y");
      phpModal.var.addAdressForm.find("#billing_addr").val("N");
      phpModal.var.addrType = "delivery";
      console.log(phpModal.var.url_addr);
    }
    if (elem.hasClass("change-bill__btn")) {
      phpModal.var.addAdressForm.find("#billing_addr").val("Y");
      phpModal.var.addAdressForm.find("#principale").val("N");
      phpModal.var.addrType = "billing";
      console.log(phpModal.var.url_addr);
    }
  };
  _add_Address = () => {
    const phpModal = this;
    phpModal.var.mainWrapper.on("click", ".addAddress", function (e) {
      const elem = $(this);
      phpModal._open_add_address(elem);
      phpModal.var.bs_modals.then((modal) => {
        modal["add_address-box"].show();
        modal["add_address-box"].selector.addEventListener(
          "shown.bs.modal",
          (e) => {
            phpModal.var.delivery_addr =
              "address-content.delivery-address-content";
          }
        );
        // phpModal.var.url_addr = "bill-to-address";
      });
    });
  };
  _modifyAddress = () => {
    const phpModal = this;
    phpModal.var.mainWrapper.on(
      "submit",
      "#manage_frm_Modifier , .modify-frm form",
      function (e) {
        e.preventDefault();
        phpModal.var.modifyAddressButton.html("Please wait...");
        const modifElem = $(this);
        let frm_name = modifElem.attr("id");
        if (modifElem.parent().attr("class") == "modify-frm") {
          frm_name = modifElem.attr("class");
        }
        let fillInput =
          modifElem.attr("id") == "manage_frm_Modifier" ||
          modifElem.parent().attr("class") == "modify-frm";
        const data = {
          url: "checkout_process_change/autoFillInput",
          frm: modifElem,
          frm_name: frm_name,
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
                  if (fillInput) {
                    fillInput = false;
                    let elemAry = {};
                    $.each(
                      $(this).find("form")[0].elements,
                      function (index, elem) {
                        if (Object.keys(response.msg).includes(elem.id)) {
                          elemAry[elem.id] = response.msg[elem.id];
                          if (elem.tagName === "SELECT") {
                            let option = document.createElement("option");
                            option.value = response.msg[elem.id].id;
                            option.text = response.msg[elem.id].name;

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
                  }
                });
            });
          } else {
          }
        });
      }
    );
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
        if ($(this).attr("id") === "checkout-billing-address-id-1") {
          phpModal.var.url_addr = "ship-to-address";
        }
      }
    );
  };
  _update_navigationAddress = () => {
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
        phpModal._open_add_address($(this));
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
          addr: { addr: phpModal.var.url_addr },
          addrType: phpModal.var.addrType ? phpModal.var.addrType : "",
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
        addr: {
          modals: "modal-address",
          chkFrm: "delivery-address-content",
        },
        addrType: phpModal.var.addrType ? phpModal.var.addrType : "",
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
  _delete_address = () => {
    const phpModal = this;
    phpModal.var.mainWrapper.on(
      "submit",
      "#manage_frm_Supprimer, .erase-frm form",
      function (e) {
        e.preventDefault();
        const delElem = $(this);
        let frm_name = delElem.attr("id");
        if (delElem.parent().attr("class") == "erase-frm") {
          frm_name = delElem.attr("class");
        }
        console.log(delElem);
        const data = {
          url: "checkout_process_change/delete",
          frm: delElem,
          frm_name: frm_name,
          addr: {
            ship: "ship-to-address",
            bill: "bill-to-address",
            modals: "modal-address",
            chkFrm: "delivery-address-content",
          },
          addrType: phpModal.var.addrType ? phpModal.var.addrType : "",
        };
        phpModal.var.delivery_addr = "address-book-wrapper";
        Call_controller(data, (response) => {
          if (response.result == "success") {
            console.log(response);
            if (response.result == "success") {
              for (var key in response.msg) {
                $("." + key).html(response.msg[key]);
              }
            }
          }
        });
      }
    );
  };
  _active_address = () => {
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
              .find(".card--active .manage .select-frm form .select")
              .click();
          }
        );
      });
    });
  };
  _reset_modals = () => {
    const phpModal = this;
    phpModal.var.bs_modals
      .then((modal) => {
        for (var modalName in modal) {
          modal[modalName]["selector"].addEventListener(
            "hidden.bs.modal",
            function (e) {
              input.clearForm($(this).find("form")[0], "pays");
            }
          );
        }
      })
      .catch((e) => {
        console.log(e);
      });
  };
}
export default new ChangeAddress($("#main-site"));
