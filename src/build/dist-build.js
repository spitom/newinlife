const { promises: fs } = require('fs');
const path = require('path');

async function copyDir(src, dest) {
    await fs.mkdir(dest, { recursive: true });

    const entries = await fs.readdir(src, { withFileTypes: true });

    const ignore = [
        'node_modules',
        'dist',
        'src',
        '.git',
        '.github',
        '.vscode',
        '.idea',
        '.browserslistrc',
        '.editorconfig',
        '.gitattributes',
        '.gitignore',
        '.jscsrc',
        '.jshintignore',
        '.travis.yml',
        'composer.json',
        'composer.lock',
        'package.json',
        'package-lock.json',
        'phpcs.xml.dist',
        'readme.txt',
        'npm-debug.log',
        '.DS_Store',
        'Thumbs.db',
		'phpmd.baseline.xml',
		'phpmd.xml',
		'phpstan-baseline.neon',
		'phpstan.neon.dist',
		'README.md',
    ];

    for (const entry of entries) {
        if (
            ignore.includes(entry.name) ||
            entry.name.endsWith('.map')
        ) {
            continue;
        }

        const srcPath = path.join(src, entry.name);
        const destPath = path.join(dest, entry.name);

        if (entry.isDirectory()) {
            await copyDir(srcPath, destPath);
        } else {
            await fs.copyFile(srcPath, destPath);
        }
    }
}

copyDir('./', './dist');
