const { promises: fs } = require("fs")
const path = require("path")

async function copyDir(src, dest) {
    await fs.mkdir(dest, { recursive: true });
    let entries = await fs.readdir(src, { withFileTypes: true });

    for (let entry of entries) {
        let srcPath = path.join(src, entry.name);
        let destPath = path.join(dest, entry.name);

        entry.isDirectory() ?
            await copyDir(srcPath, destPath) :
            await fs.copyFile(srcPath, destPath);
    }
}

async function copyFile(src, dest) {
    await fs.mkdir(path.dirname(dest), { recursive: true });
    await fs.copyFile(src, dest);
}

// Copy all Bootstrap SCSS files.
copyDir('./node_modules/bootstrap/scss', './src/sass/assets/bootstrap5');
// Copy all Understrap SCSS files.
copyDir('./node_modules/understrap/src/sass/theme', './src/sass/assets/understrap/theme');
// Copy Bootstrap Icons runtime assets.
copyFile(
    './node_modules/bootstrap-icons/font/bootstrap-icons.min.css',
    './assets/icons/bootstrap-icons/bootstrap-icons.min.css'
);

copyFile(
    './node_modules/bootstrap-icons/font/fonts/bootstrap-icons.woff',
    './assets/icons/bootstrap-icons/fonts/bootstrap-icons.woff'
);

copyFile(
    './node_modules/bootstrap-icons/font/fonts/bootstrap-icons.woff2',
    './assets/icons/bootstrap-icons/fonts/bootstrap-icons.woff2'
);
