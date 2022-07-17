import favicon from "img/favicon.ico";
import card from "img/visa.png";
import logo2 from "img/logo2.png";
import { Call_controller } from "corejs/form_crud";
import "select2";
import OP from "corejs/operator";
import user_cart from "corejs/user_cart";
import { BASE_URL, HOST } from "corejs/config";

class Main {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.header = this.element.find("#header");
    this.wrapper = this.element.find("#main-site");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    document.querySelector("link[type='image/ico']").href = favicon;
    /**
     * Currency Management
     * =======================================================================
     */
    //  const operation = new OP();
    //  operation._format_money({
    //    wrapper: phpPlugin.wrapper,
    //    fields: [".price .product_regular_price"],
    //  });
    /**
     * Add to Cart
     * ========================================================================
     */
    phpPlugin.wrapper.on("submit", ".add_to_cart_frm", function (e) {
      e.preventDefault();
      var data = {
        url: "add_item_into_cart",
        frm: $(this),
        frm_name: "add_to_cart_frm" + $(this).find("input[name=item_id]").val(),
        method: "addUserItem",
        params: $(this).find("button[type=submit]"),
      };
      Call_controller(data, ManageR);
      function ManageR(response, button) {
        if (response.result == "success") {
          console.log(response);
          if (document.location.pathname != BASE_URL + "cart") {
            phpPlugin.header.find(".cart_nb_elt").html(function () {
              return (
                response.msg.nbItems +
                parseInt(phpPlugin.header.find(".cart_nb_elt").html())
              );
            });
          }
          if (response.msg.nbItems == 1) {
            button
              .removeClass("btn-warning")
              .addClass("btn-success")
              .html("In the cart");
          } else {
            button
              .removeClass("btn-warning")
              .addClass("btn-success")
              .html("In the cart");
          }
          if (document.location.pathname == BASE_URL + "cart") {
            new user_cart(phpPlugin.wrapper, phpPlugin.header)._display_cart();
          }
        }
      }
    });
  };
}

new Main($("#body"))._init();
