export default class StripeAPIClient {
  constructor(params = {}) {
    this.params = params;
  }
  _init = () => {
    this._setupVariables();
    this._create_cardElements();
    return this;
  };
  _setupVariables = () => {
    this.api_key = this.params.api_key;
    this.cardHolder = this.params.cardholder;
    this.cardElement = this.params.cardElement;
    this.cardExp = this.params.cardExp;
    this.cardCvc = this.params.cardCvc;
    this.cardButton = this.params.cardButton;
    this.cardError = this.params.cardError;
    this.baseClasses = this.params.baseClasses;
    //-----------------------
    this.stripe = Stripe(this.api_key);
    this.elements = this.stripe.elements();

    this.Card = this.elements.create("cardNumber", {
      classes: {
        base: this.baseClasses,
        focus: "valid",
        invalid: "invalid",
      },
      style: this._style(),
      showIcon: true,
      iconStyle: "solid",
      // placeholder: "1234 1234 1234 1234",
    });
    this.Exp = this.elements.create("cardExpiry", {
      classes: {
        base: this.baseClasses,
        focus: "valid",
        invalid: "invalid",
      },
      disabled: true,
      style: this._style(),
    });
    this.Cvc = this.elements.create("cardCvc", {
      classes: {
        base: this.baseClasses,
        focus: "valid",
        invalid: "invalid",
      },
      disabled: true,
      style: this._style(),
    });
  };
  _style = () => {
    const style = {
      base: {
        // backgroundColor: "transparent",
        color: "#333",
        fontSize: "16px",
        iconColor: "rgba(126,128,251)",
        fontFamily: "share_tech,sans-serif",
        fontSmoothing: "antialiased",
        "::placeholder": {
          color: "#757593",
        },
      },
      invalid: {
        fontFamily: "sans-serif",
        color: "#fa755a",
        iconColor: "#fa755a",
      },
      complete: { color: "green" },
    };
    return style;
  };
  _create_cardElements = () => {
    const plugin = this;

    plugin.Card.mount(plugin.cardElement);
    plugin.Exp.mount(plugin.cardExp);
    plugin.Cvc.mount(plugin.cardCvc);
    plugin.Card.on("change", function (e) {
      if (e.complete) {
        plugin.Exp.update({ disabled: false });
        plugin.Exp.focus();
      }
    });
    plugin.Exp.on("change", function (e) {
      if (e.complete) {
        plugin.Cvc.update({ disabled: false });
        plugin.Cvc.focus();
      }
    });
    plugin.Cvc.on("change", function (e) {
      if (e.complete) {
        plugin.cardButton.disabled = false;
      }
    });
    plugin._manage_errors(plugin.Card, plugin.Exp, plugin.Cvc);
    return plugin;
  };

  /**
   * Manage Errors
   * ======================================================================================
   */
  _manage_errors = (card, cardExp, cardCvc) => {
    const plugin = this;
    [card, cardExp, cardCvc].forEach((elt, index) => {
      elt.addEventListener("change", (e) => {
        if (e.error) {
          plugin.cardError.textContent = e.error.message;
        } else {
          plugin.cardError.textContent = "";
        }
      });
    });
  };
  /**
   * Create Paiment
   * ======================================================================================
   */
  _createPayment = () => {
    const plugin = this;
    return new Promise((resolve, reject) => {
      plugin.stripe
        .createPaymentMethod({
          type: "card",
          card: plugin.Card,
          billing_details: {
            // Include any additional collected billing details.
            name: plugin.cardHolder,
          },
        })
        .then((response) => {
          if (response.error) {
            reject(response);
          } else {
            resolve(response);
          }
        });
    });
  };
}
