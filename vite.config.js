import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            pwa: {
                name: 'Meds',
                themeColor: '#4DBA87',
                msTileColor: '#000000',
                appleMobileWebAppCapable: 'yes',
                appleMobileWebAppStatusBarStyle: 'black',

                // configure the workbox plugin
                workboxPluginMode: 'InjectManifest',
                workboxOptions: {
                    // swSrc is required in InjectManifest mode.
                    swSrc: 'dev/sw.js',
                    // ...other Workbox options...
                }
            },
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
