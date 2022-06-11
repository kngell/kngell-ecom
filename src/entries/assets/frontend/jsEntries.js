module.exports = {
  entry: {
    //Main Js
    "js/main/main": {
      import: ["js/main/main.js"],
      dependOn: "js/librairies/frontlib",
    },
  },
};
