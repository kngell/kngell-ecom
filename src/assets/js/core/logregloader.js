export default class Logreg {
  constructor() {
    this.isLoad = false;
  }
  check = () => {
    return this;
  };
  login = async () => {
    const login = await import(
      /* webpackMode: "lazy" */
      /* webpackChunkName: "logAndReg" */
      "./login_register.class"
    );
    this.isLoad = true;
  };
  isLoadStatus = (status) => {
    this.isLoad = status;
  };
}
