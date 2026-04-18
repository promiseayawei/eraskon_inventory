# eraskon_inventory

## Workflow

- `npm run start` starts a file watcher that automatically syncs root web changes into `www/`.
- `npm run sync:web` runs a one-time mirror of the current web sources into `www/`.
- `npm run build` syncs `www/` and then refreshes the Android Capacitor project.

## Notes

- Edit the root source files first. The watcher copies those changes into `www/`.
- If you want Android to pick up the latest web files, run `npm run build` after your edits.
