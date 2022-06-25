//Get visitors Data

export const get_visitors_data = () => {
  // e.preventDefault();
  return new Promise((resolve, reject) => {
    let data = {
      ip: $("#ip_address").val(),
    };
    if (data) {
      resolve(data);
    } else {
      reject("no data");
    }
  });
};

export const send_visitors_data = (data, manageR) => {
  const csrfToken = document.querySelector('meta[name="csrftoken"]');
  const frm_name = document.querySelector('meta[name="view_name"]');
  $.ajax({
    url: data.url,
    method: "post",
    dataType: "json",
    data: {
      table: data.table,
      ip: data.ip ? data.ip : "",
      cookies: data.cookies ? data.cookies : "",
      csrftoken: csrfToken === null ? "" : csrfToken.getAttribute("content"),
      frm_name: frm_name === null ? "" : frm_name.getAttribute("content"),
    },
  })
    .done((response) => {
      manageR(response);
    })
    .fail((error) => {
      console.log(error);
    });
};
