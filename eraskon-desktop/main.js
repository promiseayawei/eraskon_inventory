// main.js
const { app, BrowserWindow } = require('electron');

function createWindow () {
  const win = new BrowserWindow({
    width: 1280,
    height: 800,
    webPreferences: {
      nodeIntegration: false
    }
  });

  // Option 1: Load your hosted web app
  win.loadURL('https://eraskon-inventory.onrender.com/');

  // Option 2: Load local version (see below)
  // win.loadFile('index.html');
}

app.whenReady().then(createWindow);
