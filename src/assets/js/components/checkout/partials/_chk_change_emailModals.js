import { Call_controller } from "corejs/form_crud";
import input from "corejs/inputErrManager";
class ChangeEmail {
  constructor(element) {
    this.element = element;
  }
  _init = (variables) => {
    this.var = variables;
    return this;
  };

  _changeEmail = () => {
    const phpModal = this;
    input.removeInvalidInput(phpModal.var.changeEmailForm);
    phpModal.var.modalWrapper.on("submit", "#change-email-frm", function (e) {
      e.preventDefault();
      phpModal.var.changeEmailButton.html("Please wait...");
      const data = {
        url: "checkout_process_change/changeEmail",
        frm: $(this),
        frm_name: $(this).attr("id"),
      };
      Call_controller(data, (response) => {
        phpModal.var.changeEmailButton.html("Submit");
        if (response.result == "success") {
          phpModal.var.bs_modals.then((modal) => {
            modal["modal-box-email"].hide();
          });
          phpModal.var.wrapper.find(".contact-email").html(response.msg);
        } else {
          if (response.result == "error-field") {
            input.error(phpModal.var.changeEmailForm, response.msg, 30);
          } else {
            phpModal.var.changeEmailForm.find(".alertErr").html(response.msg);
          }
        }
      });
    });
  };
}
export default new ChangeEmail($("#main-site"));
