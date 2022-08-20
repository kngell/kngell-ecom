class Succes_message {
  _init = () => {
    this.open_success_msg_btn = document.querySelector("#open-popup");
    this.close_success_msg_btn = document.querySelector(".popup .close-btn");
    return this;
  };

  _show = () => {
    const phpModal = this;
    console.log(phpModal.open_success_msg_btn);
    phpModal.open_success_msg_btn.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelector(".popup").classList.add("active");
    });

    phpModal.close_success_msg_btn.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelector(".popup").classList.remove("active");
    });
  };
}
export default new Succes_message();
