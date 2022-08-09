export const BASE_URL = "/";
export const HOST = "https://localhost";
export const AVATAR = BASE_URL + "public/assets/img/users/avatar.png";
export const IMG = BASE_URL + "public/assets/img/";

export const isIE = () => {
  var userAgent = navigator.userAgent;
  return /MSIE|Trident/.test(userAgent);
};
export const csrftoken = document
  .querySelector('meta[name="csrftoken"]')
  .getAttribute("content");
export const frm_name = document
  .querySelector('meta[name="frm_name"]')
  .getAttribute("content");
