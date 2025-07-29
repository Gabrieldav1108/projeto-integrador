#!/bin/bash
set -e

echo "🚀 Starting Vite Auto-Setup..."

# Instala dependências se node_modules não existir
if [ ! -d "node_modules" ]; then
  echo "📦 Installing dependencies..."
  npm install
fi

# Limpa cache se necessário
echo "🧹 Cleaning cache..."
rm -rf public/build || true

# Inicia o Vite
echo "⚡ Starting Vite dev server..."
exec npm run dev -- --host