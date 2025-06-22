import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});

// vite.config.js
// vite.config.js
// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';

// export default defineConfig({
//   server: {
//     // https: {
//     //   key: fs.readFileSync('./localhost-key.pem'),
//     //   cert: fs.readFileSync('./localhost-cert.pem'),
//     // },
//     host: '0.0.0.0',
//   },
//   plugins: [
//     laravel({
//       input: ['resources/sass/app.scss', 'resources/js/app.js'],
//       refresh: true,
//     }),
//   ],
// });
