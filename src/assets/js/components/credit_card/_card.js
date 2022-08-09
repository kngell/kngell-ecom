class CheckoutCreditCard {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariales();
    this._setupEvents();
  };
  _setupVariales = () => {
    this.ccNumberInput = this.element.querySelector(".card-number-input");
    this.ccNumberBox = this.element.querySelector(".card-number-box");
    this.ccHolderInput = this.element.querySelector(".card-holder-input");
    this.ccHolderBox = this.element.querySelector(".card-holder-name");
    this.ccMonthInput = this.element.querySelector(".month-input");
    this.ccMonthBox = this.element.querySelector(".exp-month");
    this.ccYearInput = this.element.querySelector(".year-input");
    this.ccYearBox = this.element.querySelector(".exp-year");
    this.ccCcvInput = this.element.querySelector(".cvv-input");
    this.ccCcvBox = this.element.querySelector(".ccv-box");
    this.ccFront = this.element.querySelector(".front");
    this.ccBack = this.element.querySelector(".back");
  };
  _setupEvents = () => {
    const cc = this;
    cc.ccNumberInput.oninput = () => {
      cc.ccNumberBox.innerText = cc.ccNumberInput.value;
    };
    cc.ccHolderInput.oninput = () => {
      cc.ccHolderBox.innerText = cc.ccHolderInput.value;
    };
    cc.ccMonthInput.oninput = () => {
      cc.ccMonthBox.innerText = cc.ccMonthInput.value;
    };
    cc.ccYearInput.oninput = () => {
      cc.ccYearBox.innerText = cc.ccYearInput.value;
    };
    cc.ccCcvInput.onmouseenter = () => {
      cc.ccFront.style.transform = "perspective(1000px) rotateY(-180deg)";
      cc.ccBack.style.transform = "perspective(1000px) rotateY(0deg)";
    };
    cc.ccCcvInput.onmouseleave = () => {
      cc.ccFront.style.transform = "perspective(1000px) rotateY(0deg)";
      cc.ccBack.style.transform = "perspective(1000px) rotateY(180deg)";
    };
    cc.ccCcvInput.oninput = () => {
      cc.ccCcvBox.innerText = cc.ccCcvInput.value;
    };
  };
}
export default new CheckoutCreditCard(document.getElementById("credit-card"));
