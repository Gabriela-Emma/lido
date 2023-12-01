import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import topLevelAwait from "vite-plugin-top-level-await";
import wasm from "vite-plugin-wasm";
import * as path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/lido.ts",
                "resources/js/partners.ts",
                "resources/js/earn-ccv4.ts",
                "resources/js/phuffycoin.ts",
                "resources/js/apps/contribute/app.ts",
                "resources/js/apps/catalyst-explorer/app.ts",
                "resources/js/apps/earn/app.ts",
                "resources/js/apps/rewards/app.ts",
                "resources/js/apps/delegators/app.ts",
            ],
            // ssr: "resources/js/ssr.ts",
            refresh: [
                // ...refreshPaths,
                "routes/**",
                "resources/views/**",
                "app/Http/Livewire/**",
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wasm(),
        topLevelAwait(),
        // manifestSRI(),
    ],
    optimizeDeps: {
        esbuildOptions: {
            target: 'es2020',
        },
        exclude: ["lucid-cardano"],
    },
    worker: {
        format: "es",
        plugins: [wasm(), topLevelAwait()],
    },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./resources/js"),
            "@apps": path.resolve(__dirname, "./resources/js/apps"),
            "@lucid-cardano": "/node_modules/lucid-cardano/web/mod.js",
            "@ziggy": "./vendor/tightenco/ziggy/dist/vue.m",
            'node-fetch': 'node-fetch-polyfill',
        },
    },
    build: {
        target: "es2020",
        rollupOptions: {
            external: ["lucid-cardano"],
        },
    },
});
