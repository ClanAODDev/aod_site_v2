import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import legacy from '@vitejs/plugin-legacy';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/src/main.styl',
                'resources/fonts/fonts.css'
            ],
            refresh: true,
        }),
        legacy({
            targets: ['defaults', 'not IE 11']
        })
    ],
    resolve: {
        alias: {
            '@': '/resources',
            'images': '/public/images'
        }
    },
    publicDir: 'public',
    css: {
        preprocessorOptions: {
            stylus: {
                additionalData: `@import "/resources/src/partials/variables.styl"`
            }
        }
    }
});
