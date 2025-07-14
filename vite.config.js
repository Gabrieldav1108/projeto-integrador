import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import os from 'os';

function getDockerHost() {
  // Se estiver rodando fora do Docker, use localhost
  if (!process.env.DOCKER) {
    return 'localhost';
  }

  // Windows/macOS (Docker Desktop): use host.docker.internal
  if (os.platform() === 'win32' || os.platform() === 'darwin') {
    return 'host.docker.internal';
  }

  // Linux: use IP local da máquina (ajuste se necessário)
  return '172.17.0.1'; // IP padrão do host no Docker bridge no Linux
}

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/scss/app.scss', 'resources/js/app.js'],
      refresh: true
    })
  ],
  server: {
    host: '0.0.0.0', // importante para funcionar no Docker
    port: 5173,
    strictPort: true,
    hmr: {
      host: 'localhost',
      protocol: 'ws',
      port: 5173
    }
  },
  resolve: {
    alias: {
      '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
    }
  }
});