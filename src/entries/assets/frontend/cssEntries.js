module.exports = {
  entry: {
    //Front General Main sass
    "css/main/generalMain": {
      import: ["css/main/generalMain.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Home plugins
    "css/plugins/homeplugins": {
      import: ["css/plugins/homeplugins.sass"],
      dependOn: "css/librairies/frontlib",
    },
    // Main Clothes sass
    "css/brand/clothes/main/clothesMain": {
      import: ["css/brand/clothes/main/clothesMain.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Clothes Home sass
    "css/brand/clothes/pages/home/home": {
      import: ["css/brand/clothes/pages/home/home.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Phones Products Home sass
    "css/brand/phones/home": {
      import: ["css/brand/phones/_index.sass"],
      dependOn: "css/librairies/frontlib",
    },
    // Checkout
    "css/components/checkout/checkout": {
      import: ["css/components/checkout/checkout.sass"],
      dependOn: "css/librairies/frontlib",
    },
    // Learning
    "css/learn/learn": {
      import: ["css/learn/learn.sass"],
      dependOn: "css/librairies/frontlib",
    },
    // Todo
    "css/components/todoList/todoList": {
      import: ["css/components/todoList/todoList.sass"],
      dependOn: "css/librairies/frontlib",
    },
  },
};
