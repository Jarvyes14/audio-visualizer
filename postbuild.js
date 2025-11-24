// postbuild.js
import fs from "node:fs";

const src = 'public/build/.vite/manifest.json';
const dst = 'public/build/manifest.json';

if (!fs.existsSync(src)) {
    console.error('❌ No se encontró', src);
    process.exit(1);
}

fs.copyFileSync(src, dst);
console.log('✅ Copiado', src, '→', dst);
