import { Call_controller } from "corejs/form_crud";
class ChangeShippingMode {
  _init = (variables) => {
    this.var = variables;
    return this;
  };

  _changeShipping = () => {
    const phpModal = this;
    phpModal.var.modalWrapper.on(
      "change",
      "#shipping_class_change",
      function (e) {
        const optionSelected = $(this).find("option:selected");
        phpModal.var.changeShippingForm
          .find("#sh_name")
          .val(optionSelected.text());
      }
    );
    phpModal.var.modalWrapper.on(
      "submit",
      "#shipping-select-frm",
      function (e) {
        e.preventDefault();
        const data = {
          url: "checkout_process_change/changeShipping",
          frm: $(this),
          frm_name: $(this).attr("id"),
        };
        Call_controller(data, (response) => {
          console.log(response);
          if (response.result == "success") {
            phpModal.var.bs_modals.then((modal) => {
              modal["modal-box-shipping"].hide();
            });
            phpModal.var.wrapper.find(".total").html(response.msg.cart);
            phpModal.var.wrapper
              .find(".shipping_method .method_title")
              .html(response.msg.name);
            phpModal.var.wrapper
              .find(".shipping_method .price")
              .html(response.msg.price);
            phpModal.var.wrapper
              .find("input[name=sh_name]")
              .attr("checked", false);
            phpModal.var.wrapper
              .find("#" + response.msg.id)
              .attr("checked", true);
          } else {
          }
        });
      }
    );
  };
}
export default new ChangeShippingMode();
