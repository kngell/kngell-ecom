import { csrftoken, frm_name } from "corejs/config";
//Get visitors Data
export const get_visitors_data = () => {
  return new Promise((resolve, reject) => {
    const ip = $("#ip_address");
    if (ip.length) {
      let data = {
        ip: ip.val(),
        csrftoken: csrftoken,
        frm_name: frm_name,
      };
      resolve(data);
    } else {
      reject("no data");
    }
  });
};

export const send_visitors_data = (data, manageR) => {
  $.ajax({
    url: data.url,
    method: "post",
    dataType: "json",
    data: data,
  })
    .done((response) => {
      manageR(response);
    })
    .fail((error) => {
      console.log(error);
    });
};
