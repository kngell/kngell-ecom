class Checkout {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {
    this.form = this.element.querySelector("[data-multi-step]");
    this.prevBtns = this.element.querySelectorAll(".btn-prev");
    this.nextBtns = this.element.querySelectorAll(".btn-next");
    this.progress = this.element.querySelector(".progress");
    this.formSteps = this.element.querySelectorAll("[data-step]");
    this.progressSteps = this.element.querySelectorAll(".progress-step");
  };
  _setupEvents = () => {
    var phpCkt = this;
    let formStepNum = 0;
    // let curentStep = parseInt(
    //   phpCkt.formSteps.find((step) => {
    //     console.log(step);
    //     return step.classList.contains("form-step-active");
    //   })?.dataset.step
    // );
    // console.log(curentStep);
    phpCkt.nextBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        formStepNum++;
        updateFormSteps();
        updateProgressBar();
      });
    });
    phpCkt.prevBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        formStepNum--;
        updateFormSteps();
        updateProgressBar();
      });
    });
    function updateFormSteps() {
      phpCkt.formSteps.forEach((formStep) => {
        formStep.classList.contains("form-step-active") &&
          formStep.classList.remove("form-step-active");
      });
      phpCkt.formSteps[formStepNum].classList.add("form-step-active");
    }
    function updateProgressBar() {
      phpCkt.progressSteps.forEach((progressStep, idx) => {
        console.log(progressStep.classList);
        if (idx < formStepNum + 1) {
          progressStep.classList.add("progress-step-active");
        } else {
          progressStep.classList.remove("progress-step-active");
        }
      });
      const progressStepActive = phpCkt.element.querySelectorAll(
        ".progress-step.progress-step-active"
      );
      phpCkt.progress.style.width =
        ((progressStepActive.length - 1) / (phpCkt.progressSteps.length - 1)) *
          100 +
        "%";
    }
  };
}
export default new Checkout(
  document.getElementById("checkout-element")
)._init();
