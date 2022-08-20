import { Call_controller } from "corejs/form_crud";
class GestionMenu {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.wrapper = this.element.find(".wrapper");
  };
  _setupEvents = () => {
    const phpMenu = this;

    phpMenu.wrapper.on("click", ".transaction-item", function (e) {
      $(this).find("form").submit();
    });
    phpMenu.wrapper.on("submit", ".transaction-item form", function (e) {
      e.preventDefault();
      const data = {
        url: "user_account_menu/handle",
        frm: $(this),
        frm_name: $(this).attr("class"),
      };
      Call_controller(data, (response) => {
        if (response.result == "success") {
          for (var key in response.msg) {
            $("." + key).html(response.msg[key]);
          }
          phpMenu._manageOrders();
        }
      });
    });
  };
}

export default new GestionMenu($("#main-site"));
