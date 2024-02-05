import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    resolve: {
        alias: {
          '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
          '~fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
          '~flatpickr': path.resolve(__dirname, 'node_modules/flatpickr'),
          '~vue-select': path.resolve(__dirname, 'node_modules/vue-select'),
          '~swiper': path.resolve(__dirname, 'node_modules/swiper'),
          'vue': 'vue/dist/vue.esm-bundler.js'
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.ts',
                
                'resources/js/pages/auth/forgot-password.ts',
                'resources/js/pages/auth/login.ts',
                'resources/js/pages/auth/sign-up.ts',

                'resources/js/pages/clients/create.ts',
                'resources/js/pages/clients/edit.ts',
                'resources/js/pages/clients/index.ts',
                'resources/js/pages/clients/show.ts',

                'resources/js/pages/products/edit.ts',
                'resources/js/pages/products/show.ts',
                'resources/js/pages/products/index.ts',

                'resources/js/pages/projects/create.ts',
                'resources/js/pages/projects/edit.ts',
                'resources/js/pages/projects/index.ts',

                'resources/js/pages/collections/show.ts',
                'resources/js/pages/collections/edit.ts',
                'resources/js/pages/collections/create.ts',

                'resources/js/pages/proposals/edit.ts',
                'resources/js/pages/proposals/index.ts',

                'resources/js/pages/users/create.ts',
                'resources/js/pages/users/edit.ts',
                'resources/js/pages/users/index.ts',
                'resources/js/pages/users/show.ts',

                'resources/js/pages/roles/create.ts',
                'resources/js/pages/roles/edit.ts',
                'resources/js/pages/roles/index.ts',
                'resources/js/pages/roles/show.ts',

                'resources/js/pages/email-templates/index.ts',
                'resources/js/pages/email-templates/edit.ts',
                'resources/js/pages/email-templates/create.ts',

                'resources/js/pages/dashboard/dashboard.ts',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,
 
                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directory as expected.
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: { 
        hmr: {
            host: 'localhost',
        },
    },
});