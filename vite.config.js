import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig(({ mode }) => ({
  plugins: [
    laravel({
      input: [
        'resources/scss/app.scss',
        'resources/js/app.js'
      ],
      refresh: [
        'resources/views/**',
        'routes/**'
      ],
    }),
  ],
  
  // Configurações do servidor de desenvolvimento
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    hmr: {
      host: mode === 'development' ? 'localhost' : undefined,
      protocol: 'ws',
      port: 5173,
    },
    watch: {
      usePolling: true, // Essencial para Docker
      interval: 1000,   // Polling a cada 1s
    },
  },

  // Configurações de build
  build: {
    manifest: true,
    outDir: 'public/build',
    emptyOutDir: true,
    rollupOptions: {
      output: {
        assetFileNames: 'assets/[name]-[hash][extname]',
        chunkFileNames: 'assets/[name]-[hash].js',
        entryFileNames: 'assets/[name]-[hash].js',
      },
    },
  },

  // Resolução de aliases
  resolve: {
    alias: {
      '~': path.resolve(__dirname, 'resources/js'),
      '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
      '~resources': path.resolve(__dirname, 'resources'),
    },
  },

  // Otimizações específicas por ambiente
  optimizeDeps: {
    include: [
      'bootstrap',
      'jquery',
    ],
  },
}));