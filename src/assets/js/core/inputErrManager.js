import eL from "corejs/getParent";
class Input_Manager {
  reset_invalid_input = (form) => {
    form.find(".is-invalid").removeClass("is-invalid");
    form.find("div.invalid-feedback").html("");
  };
  //remove invalid input on focus
  removeInvalidInput(myform) {
    myform.on("focus", "input,textarea, .ck, .note-editor", function () {
      $(this).removeClass("is-invalid");
      $(this).parents(".input-box").children("div.invalid-feedback").html("");
      $("label[for='" + $(this).attr("id") + "']").css("top", "");
    });
  }
  findLabel = (el) => {
    const idVal = el.id;
    const labels = document.getElementsByTagName("label");
    for (const label of labels) {
      if (label.htmlFor === idVal) {
        return label;
      }
    }
  };
  error = (form, InputErr, valeur = null) => {
    let arrErr = [];
    for (const [key, value] of Object.entries(InputErr)) {
      if (key == "terms") {
        const terms = document.getElementById(key);
        let div = eL
          .uPToClass(terms, "input-box")
          .querySelector(".invalid-feedback");
        div.classList.add("form-text", "d-block");
        div.innerHTML = value;
      } else {
        const input = form.find("#" + key).addClass("is-invalid");
        input
          .parents(".input-box")
          .children("div.invalid-feedback")
          .html(value);
        const label = $("label[for='" + input.attr("id") + "']");
        if (input.val().length > 0) {
          label.css("top", "");
        } else {
          label.css("top", valeur + "%");
        }
      }
      arrErr.push(key);
    }
    return arrErr;
  };
  inputHidden = (el, name, value, form) => {
    let element = document.createElement(el);
    element.type = "hidden";
    element.value = value;
    element.name = name;
    form.append(element);
  };
  clearForm = (myFormElement, select2 = null) => {
    $("#" + select2).empty();
    $(myFormElement)
      .find(":input")
      .each(function (i, elem) {
        switch (elem.type) {
          case "password":
          case "select-multiple":
          case "select-one":
          case "text":
          case "textarea":
            $(elem).val("");
            break;
          case "checkbox":
          case "radio":
            elem.checked = false;
        }
      });
  };
}
export default new Input_Manager();
