import { spawn } from 'node:child_process';
import { watch } from 'node:fs';
import path from 'node:path';

const root = path.resolve(process.cwd());
const ignoredPrefixes = [
  `${path.sep}.git${path.sep}`,
  `${path.sep}node_modules${path.sep}`,
  `${path.sep}.gradle${path.sep}`,
  `${path.sep}android${path.sep}`,
  `${path.sep}www${path.sep}`,
];

let syncing = false;
let rerunRequested = false;
let debounceTimer = null;
let watcher = null;

function isIgnored(filePath = '') {
  const normalized = `${path.sep}${String(filePath).replaceAll('/', path.sep)}`;
  return ignoredPrefixes.some((prefix) => normalized.includes(prefix));
}

function runSync() {
  if (syncing) {
    rerunRequested = true;
    return;
  }

  syncing = true;
  console.log('[watch:web] syncing web bundle...');

  const child = spawn(process.execPath, [path.join(root, 'scripts', 'sync-web.mjs')], {
    cwd: root,
    stdio: 'inherit',
  });

  child.on('exit', (code) => {
    syncing = false;
    if (code !== 0) {
      console.error(`[watch:web] sync failed with exit code ${code}`);
    } else {
      console.log('[watch:web] sync complete');
    }

    if (rerunRequested) {
      rerunRequested = false;
      runSync();
    }
  });
}

function scheduleSync() {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(runSync, 150);
}

function startWatcher() {
  watcher = watch(
    root,
    { recursive: true },
    (_eventType, filename) => {
      if (!filename || isIgnored(filename)) return;
      scheduleSync();
    }
  );

  process.on('SIGINT', () => {
    watcher?.close();
    process.exit(0);
  });

  process.on('SIGTERM', () => {
    watcher?.close();
    process.exit(0);
  });

  console.log('[watch:web] watching for file changes...');
}

runSync();
startWatcher();
