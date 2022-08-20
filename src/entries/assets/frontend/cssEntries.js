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

    // Learning
    "css/learn/learn": {
      import: ["css/learn/learn.sass"],
      dependOn: "css/librairies/frontlib",
    },

    // Email Main css
    "css/components/email/main": {
      import: ["css/components/email/_index.sass"],
      dependOn: "css/librairies/frontlib",
    },
  },
};
