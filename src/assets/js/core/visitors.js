//Get visitors Data
export const get_visitors_data = () => {
  // e.preventDefault();
  return new Promise((resolve, reject) => {
    let data = {
      ip: $("#ip_address").val(),
      csrftoken: document
        .querySelector('meta[name="csrftoken"]')
        .getAttribute("content"),
      frm_name: document
        .querySelector('meta[name="frm_name"]')
        .getAttribute("content"),
    };
    if (data) {
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
