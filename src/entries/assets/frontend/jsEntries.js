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
      dependOn: "js/librairies/frontlib",
    },
    // Todo
    "js/components/todoList/todoList": {
      import: ["js/components/todoList/todoList"],
      dependOn: "js/librairies/frontlib",
    },
    //Phones Products Home sass
    "js/brand/phones/home": {
      import: ["js/brand/phones/index"],
      dependOn: "js/librairies/frontlib",
    },
  },
};
