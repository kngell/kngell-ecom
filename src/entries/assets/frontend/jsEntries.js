module.exports = {
  entry: {
    //Main Js
    "js/main/frontend/main": {
      import: ["js/main/frontend/main.js"],
      dependOn: "js/librairies/frontlib",
    },
    "js/plugins/homeplugins": {
      import: ["js/plugins/homeplugins"],
      dependOn: "js/librairies/frontlib",
    },
    // Checkout
    "js/components/checkout/checkout": {
      import: ["js/components/checkout/checkout"],
      dependOn: "js/librairies/frontlib",
    },
    // Todo
    "js/components/todoList/todoList": {
      import: ["js/components/todoList/todoList"],
      dependOn: "js/librairies/frontlib",
    },
    "js/main/auth_modals": {
      import: ["js/main/frontend/partials/_auth_modals"],
      dependOn: "js/librairies/frontlib",
    },
  },
};
