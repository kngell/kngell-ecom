import { Call_controller } from "corejs/form_crud";
import "select2";
// import _credit_card from "../../components/credit_card/_card";
import user_cart from "corejs/user_cart";
import { BASE_URL, HOST } from "corejs/config";
import cart_manager from "./partials/_cart_manager";
import owl_carousel from "./partials/_owl_carousel";
import user_account from "js/components/user_account/user_account";
import imageList from "./partials/_image_list";

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
    /** Cart Manager */
    cart_manager._init();
    /** Owl_Carousel */
    owl_carousel._init();
    /** User Account */
    user_account._init();
    /** FavIcon */
    document.querySelector("link[type='image/ico']").href =
      imageList["favicon"];
    /** Authentication Manager */

    /**
     * Add to Cart
     * ========================================================================
     */
    phpPlugin.wrapper.on("submit", ".add_to_cart_frm", function (e) {
      e.preventDefault();
      var data = {
        url: "user_cart/add",
        frm: $(this),
        frm_name: "add_to_cart_frm" + $(this).find("input[name=item_id]").val(),
        method: "addUserItem",
        params: $(this).find("button[type=submit]"),
      };
      Call_controller(data, ManageR);
      function ManageR(response, button) {
        if (response.result == "success") {
          if (document.location.pathname != BASE_URL + "cart") {
            phpPlugin.header
              .find("#shopping-cart")
              .replaceWith(response.msg.cartItems);
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
