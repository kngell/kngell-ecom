import log_reg from "corejs/logregloader";
import select2 from "corejs/select2_manager";
import { csrftoken, frm_name } from "corejs/config";
// import { get_visitors_data, send_visitors_data } from "corejs/visitors";

class HomePlugin {
  constructor(element) {
    this.element = element;
  }

  _init = (e) => {
    this._setupVariables();
    this._setupEvents(e);
  };

  _setupVariables = () => {
    this.loginBtn = this.element.find("#login_btn");
    this.header = this.element.find("#header");
    this.navigation = this.element.find(".navigation");
    this.wrapper = this.element.find(".page-content");
  };
  _setupEvents = (e) => {
    var phpPlugin = this;
    /**
     * Login and Register
     * ------------------------------------------------------
     */
    phpPlugin.element.on(
      "click",
      "show.bs.dropdown,.connect .connexion,.account-request .text-highlight",
      function (e) {
        var loader = new log_reg().check();
        if (!loader.isLoad) {
          loader.isLoadStatus(true);
          loader.login();
        }
      }
    );

    //Activate select2 box for contries
    const select = new select2();
    select._init({
      element: phpPlugin.wrapper.find(".select_country"),
      placeholder: "Sélectionnez un pays",
      url: "get_countries",
      csrftoken: csrftoken,
      frm_name: frm_name,
    });
  };
}
document.addEventListener("DOMContentLoaded", function (e) {
  new HomePlugin($("#body"))._init(e);
  (function (e) {
    if (typeof EventTarget !== "undefined") {
      let supportsPassive = false;
      try {
        // Test via a getter in the options object to see if the passive property is accessed
        const opts = Object.defineProperty({}, "passive", {
          get: () => {
            supportsPassive = true;
          },
        });
        window.addEventListener("testPassive", null, opts);
        window.removeEventListener("testPassive", null, opts);
      } catch (e) {}
      const func = EventTarget.prototype.addEventListener;
      EventTarget.prototype.addEventListener = function (type, fn) {
        this.func = func;
        this.func(type, fn, supportsPassive ? { passive: false } : false);
      };
    }
  })();
});
