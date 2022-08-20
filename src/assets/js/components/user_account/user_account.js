import userMenu from "./partials/_gestion_menu";
import { _odList_accordion } from "./partials/_ordList_accordion";
class UserAccount {
  constructor(element) {
    this.element = element;
  }
  _init = () => {
    this._setupVariables();
    this._setupEvents();
  };
  _setupVariables = () => {};
  _setupEvents = () => {
    const phpAccount = this;

    /** Manager user account menu */
    userMenu._init();
    /** Order List Accordion Management*/
    _odList_accordion();
  };
}

export default new UserAccount($("#main-site"));
