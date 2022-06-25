module.exports = {
  entry: {
    //Main Js
    "js/main/main": {
      import: ["js/main/main.js"],
      dependOn: "js/librairies/frontlib",
    },
    "js/plugins/homeplugins": {
      import: ["js/plugins/homeplugins"],
      dependOn: "js/librairies/frontlib",
    },
    // Checkout
    "js/components/checkout/checkout": {
      import: ["js/components/checkout/checkout"],
      dependOn: "css/librairies/frontlib",
    },
  },
};
