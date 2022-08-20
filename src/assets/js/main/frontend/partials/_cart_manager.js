import { Call_controller } from "corejs/form_crud";
class Cart_Manager {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.lr = this.element.find("#Login-Register-System");
    this.wrapper = this.element.find("#main-site");
    this.header = this.element.find("#header");
  };
  _setupEvents = () => {
    var phpPlugin = this;

    // Qty up
    phpPlugin.wrapper.on("click", ".qty-up", function (e) {
      e.preventDefault();
      const input = $(this).next();
      input.val(function (i, oldval) {
        return !isNaN(oldval) ? ++oldval : oldval;
      });
      const frm = $(this).parent();
      const data = {
        url: "user_cart/qty_change",
        frm: frm,
        frm_name: frm.attr("class"),
      };
      Call_controller(data, (response) => {
        if (response.result == "success") {
          frm
            .parents("#cart_items")
            .parents("#cart")
            .replaceWith(response.msg.shoppingCart);
        }
      });
    });
    // Qty down
    phpPlugin.wrapper.on("click", ".qty-down", function (e) {
      e.preventDefault();
      const input = $(this).parent().find("input[name=item_qty]");
      input.val(function (i, oldval) {
        return !isNaN(oldval) && oldval > 1 ? --oldval : oldval;
      });
      const frm = $(this).parent();
      const data = {
        url: "user_cart/qty_change",
        frm: frm,
        frm_name: frm.attr("class"),
      };
      Call_controller(data, (response) => {
        if (response.result == "success") {
          frm
            .parents("#cart_items")
            .parents("#cart")
            .replaceWith(response.msg.shoppingCart);
        }
      });
    });
    /** Manual add */
    let typingTimer;
    let typingTimerInterval = 1000;
    phpPlugin.wrapper.on("keyup", ".qty_input", function (e) {
      clearTimeout(typingTimer);
      const input = $(this);
      const frm = $(this).parent();
      const data = {
        url: "user_cart/qty_change",
        frm: frm,
        frm_name: frm.attr("class"),
      };
      typingTimer = setTimeout(function () {
        e.preventDefault();
        if (input.val() >= 1) {
          Call_controller(data, (response) => {
            if (response.result == "success") {
              frm
                .parents("#cart_items")
                .parents("#cart")
                .replaceWith(response.msg.shoppingCart);
            }
          });
        } else {
          input.val(function (i, oldval) {
            return "";
          });
        }
      }, typingTimerInterval);
    });
    phpPlugin.wrapper.on("keydown", ".qty_input", function (e) {
      clearTimeout(typingTimer);
    });

    /** Delete item from the cart */
    phpPlugin.wrapper.on("submit", ".delete-cart-item-frm", function (e) {
      e.preventDefault();
      const data = {
        url: "user_cart/delete_item",
        frm: $(this),
        frm_name: $(this).attr("id"),
      };
      Call_controller(data, (response) => {
        if (response.result == "success") {
          console.log(response);
          phpPlugin.wrapper
            .find("#cart")
            .replaceWith(response.msg.shoppingCart);
          phpPlugin.wrapper
            .find("#wishlist")
            .replaceWith(response.msg.whislist);
          phpPlugin.header
            .find("#shopping-cart")
            .replaceWith(response.msg.cartItems);
          phpPlugin.header
            .find(".connect a")
            .replaceWith(response.msg.whishlistItmes);
        }
      });
    });

    phpPlugin.wrapper.on("click", ".save-add", function (e) {
      e.preventDefault();
      let cart_type = "wishlist";
      if ($(this).parents("#wishlist").length != 0) {
        cart_type = "cart";
      }
      const data = {
        url: "user_cart/save_for_later",
        frm: $(this).parent(),
        frm_name: $(this).parent().attr("id"),
        cart_type: cart_type,
      };
      Call_controller(data, (response) => {
        console.log(response);
        if (response.result == "success") {
          phpPlugin.wrapper
            .find("#cart")
            .replaceWith(response.msg.shoppingCart);
          phpPlugin.wrapper
            .find("#wishlist")
            .replaceWith(response.msg.whislist);
          phpPlugin.header
            .find("#shopping-cart")
            .replaceWith(response.msg.cartItems);
          phpPlugin.header
            .find(".connect a")
            .replaceWith(response.msg.whishlistItmes);
        }
      });
    });
    phpPlugin.wrapper.on("submit", ".proceed_to_buy", function (e) {
      e.preventDefault();
      const data = {
        url: "user_cart/buy",
        frm: $(this),
        frm_name:
          $(this).attr("class") + $(this).find('input[name="item_id"]').val(),
      };
      Call_controller(data, (response) => {
        phpPlugin.wrapper.find("#cart").replaceWith(response.msg.shoppingCart);
        phpPlugin.wrapper.find("#wishlist").replaceWith(response.msg.whislist);
        phpPlugin.header
          .find("#shopping-cart")
          .replaceWith(response.msg.cartItems);
        if (response.url != null) {
          window.location.href = response.url;
        }
      });
    });
  };
}
export default new Cart_Manager($("#body"));
