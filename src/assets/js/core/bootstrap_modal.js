import { Modal } from "bootstrap";
// Bootstrap modal
class Bs_Modal {
  constructor(modals) {
    this.modals = modals;
  }
  _init = () => {
    const p = this;
    return new Promise((resolve, reject) => {
      let my_modal = [];
      p.modals.forEach((modal, i) => {
        const el = document.getElementById(modal);
        my_modal[modal] = Modal.getOrCreateInstance(el, {
          keyboard: false,
        });
        my_modal[modal]["selector"] = el;
      });
      resolve(my_modal);
    });
  };
}
export default Bs_Modal;
