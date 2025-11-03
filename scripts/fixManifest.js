import fs from 'fs';
import path from 'path';

const oldPath = path.resolve('public/build/.vite/manifest.json');
const newPath = path.resolve('public/build/manifest.json');

if (fs.existsSync(oldPath)) {
    fs.renameSync(oldPath, newPath);
    console.log('✅ Manifest moved to public/build/manifest.json');
} else {
    console.log('⚠️ Manifest not found, skipping move.');
}
