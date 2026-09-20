import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import legacy from '@vitejs/plugin-legacy';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/app.tsx',
                'resources/src/main.styl',
                'resources/fonts/fonts.css'
            ],
            refresh: true,
        }),
        legacy({
            targets: ['defaults', 'not IE 11']
        }),
        react(),
        tailwindcss()
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            'images': '/public/images'
        }
    },
    publicDir: 'public',
    outDir: 'dist',
    css: {
        preprocessorOptions: {
            stylus: {
                additionalData: `@import "/resources/src/partials/variables.styl"`
            }
        }
    }
});
