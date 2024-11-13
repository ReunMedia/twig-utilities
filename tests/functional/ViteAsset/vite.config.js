/**
 * Reun Media Vite configuration for PHP projects.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 * @copyright 2021 Reun Media
 *
 * @see https://github.com/Reun-Media/project-templates/blob/master/base/app/vite.config.ts
 *
 * @version 1.0.0
 */

import { defineConfig } from "vite";

export default defineConfig({
  build: {
    manifest: true,
    outDir: "www/static/dist",
    rollupOptions: {
      input: {
        style: "src-www/css/style.css",
        main: "src-www/js/main.js",
      },
    },
  },
  server: {
    host: true,
    port: 5173,
    strictPort: true,
    origin: "http://localhost:5173",
    watch: {
      // We must ignore `vendor` because the `twig-utilities` package is
      // required in this test directory via a symlink and causes Vite dev
      // server to eventually run out of memory and crash.
      ignored: ["**/vendor/**"],
    },
  },
});
