import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/views/basico/desktop/sass/app.scss',
                'resources/views/basico/mobile/sass/app.scss',
                'resources/views/basico/desktop/vue/app.js',
                'resources/views/basico/mobile/vue/app.js',
            ],
            refresh: true,
        }),
    ],
});
