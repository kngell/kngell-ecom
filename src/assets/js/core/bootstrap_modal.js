import { Modal } from "bootstrap";
// Bootstrap modal
class Bs_Modal {
  constructor(modals) {
    this.modals = modals;
  }
  _init = () => {
    const p = this;
    return new Promise((resolve, reject) => {
      let my_modal = new Array();
      p.modals.forEach((modal, i) => {
        const el = document.getElementById(modal);
        my_modal[modal] = Modal.getOrCreateInstance(el, {
          keyboard: false,
        });
        my_modal[modal]["selector"] = el;
      });
      if (my_modal instanceof Array) {
        resolve(my_modal);
      } else {
        reject("not an array");
      }
    });
  };
}
export default Bs_Modal;
