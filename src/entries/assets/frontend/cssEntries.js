module.exports = {
  entry: {
    //Front General Main sass
    "css/main/generalMain": {
      import: ["css/main/generalMain.sass"],
      dependOn: "css/librairies/frontlib",
    },
    // Main Clothes sass
    "css/brand/clothes/main/clothesMain": {
      import: ["css/brand/clothes/main/clothesMain.sass"],
      dependOn: "css/librairies/frontlib",
    },
    //Clothes Home sass
    "css/brand/clothes/pages/home": {
      import: ["css/brand/clothes/pages/home.sass"],
      dependOn: "css/librairies/frontlib",
    },
  },
};
