const fs = require("fs-extra");
const path = require("path");
const files = require("./filesToCopy");
class CopyFiles {
  apply(compiler) {
    compiler.hooks.compilation.tap("CopyFiles", (compilation) => {
      compilation.hooks.afterProcessAssets.tap("CopyFiles", () => {
        const moveFrom = path.resolve("src", "assets", "img");
        const moveTo = path.resolve("public", "assets", "img");
        try {
          for (const file of files) {
            const fromPath = moveFrom + "/" + file;
            const toPath = moveTo + "/" + file;
            if (!fs.existsSync(toPath)) {
              fs.copy(fromPath, toPath)
                .then(() => console.log("success!"))
                .catch((err) => console.error(err));
            }
          }
        } catch (e) {
          console.error("We've thrown! Whoops! ", e);
        }
      });
    });
  }
}

module.exports = CopyFiles;
