import { cp, mkdir, readdir, rm } from 'node:fs/promises';
import path from 'node:path';

const root = path.resolve(process.cwd());
const webDir = path.join(root, 'www');

const allowedTopLevelDirs = new Set([
  'assets',
  'components',
  'controllers',
  'models',
  'resources',
]);

const allowedTopLevelFiles = new Set([
  'approve.html',
  'category.html',
  'chairman.html',
  'config.js',
  'customer.html',
  'index.html',
  'inventory-check.html',
  'invoiced.html',
  'logistics.html',
  'order-invoice.html',
  'product-variant.html',
  'product-variant22.html',
  'product.html',
  'report.html',
  'roles.html',
  'sale.html',
  'sales-orders',
  'shipping.html',
  'shipping222.html',
  'stats.html',
  'stock-movement.html',
  'stock.html',
  'store.html',
  'test.html',
  'test2.html',
  'user.html',
  'warehouse.html',
  'welcome.html',
  'capacitor.config.json',
]);

const sourceTargets = [
  ['assets', 'assets'],
  ['components', 'components'],
  ['controllers', 'controllers'],
  ['models', 'models'],
  ['resources', 'resources'],
];

async function ensureDir(dir) {
  await mkdir(dir, { recursive: true });
}

async function cleanWebDir() {
  await ensureDir(webDir);
  const entries = await readdir(webDir, { withFileTypes: true });

  await Promise.all(
    entries.map(async (entry) => {
      if (entry.isDirectory()) {
        if (!allowedTopLevelDirs.has(entry.name)) {
          await rm(path.join(webDir, entry.name), { recursive: true, force: true });
        }
        return;
      }

      if (!allowedTopLevelFiles.has(entry.name)) {
        await rm(path.join(webDir, entry.name), { force: true });
      }
    })
  );
}

async function copySources() {
  for (const [src, dest] of sourceTargets) {
    await cp(path.join(root, src), path.join(webDir, dest), {
      recursive: true,
      force: true,
      dereference: true,
      preserveTimestamps: true,
    });
  }

  for (const file of allowedTopLevelFiles) {
    const src = path.join(root, file);
    const dest = path.join(webDir, file);
    await cp(src, dest, {
      force: true,
      dereference: true,
      preserveTimestamps: true,
    });
  }
}

await cleanWebDir();
await copySources();
console.log('Web bundle synced to www/');
