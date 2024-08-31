import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/serebo.dashboard-print.scss',
                'resources/sass/serebo.dashboard.scss',
                'resources/js/app.js',
                'resources/js/serebo.dashboard-print.core.js',
                'resources/js/serebo.dashboard.core.js',
                'resources/js/serebo.dashboard.js',
            ],
            refresh: true,
        }),
    ],
});
