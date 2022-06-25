const devMode = process.env.NODE_ENV !== "production";
// const autoprefixer = require("autoprefixer");
const { styles } = require("@ckeditor/ckeditor5-dev-utils");
const ckeditorConfig = styles.getPostCssConfig({
  themeImporter: {
    themePath: require.resolve("@ckeditor/ckeditor5-theme-lark"),
  },
  // minify: true,
});
const purgecss = require("@fullhuman/postcss-purgecss");
const normalConfig = {
  plugins: [
    "postcss-grid-kiss",
    "autoprefixer",
    "postcss-import",
    "postcss-flexbugs-fixes",
    [
      "postcss-preset-env",
      {
        autoprefixer: {
          grid: false,
          flexbox: "no-2009",
        },
        stage: 3,
        features: {
          "custom-properties": false,
        },
      },
    ],
  ],
};
module.exports = ({ file }) => {
  if (/ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/.test(file)) {
    return ckeditorConfig;
  }
  if (!devMode) {
    normalConfig.plugins.push(
      purgecss({
        content: [
          "./App/Views/**/*.php",
          "./public/assets/css/**.*.css",
          "./src/views/**/*.php",
        ],
        defaultExtractor: (content) => content.match(/[\w-/:]+(?<!:)/g) || [],
      })
    );
  }
  return normalConfig;
};
