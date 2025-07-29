# Create the file with all necessary content
cat > fix-permissions << 'EOF'
#!/bin/bash
set -e

echo "🔧 Applying automatic permission fixes..."

# Use host UID/GID from environment or defaults
HOST_UID=${HOST_UID:-1000}
HOST_GID=${HOST_GID:-1000}

# Apply permissions to critical directories
for dir in storage bootstrap/cache; do
    if [ -d "/var/www/$dir" ]; then
        sudo chown -R $HOST_UID:$HOST_GID "/var/www/$dir" || true
        sudo chmod -R 775 "/var/www/$dir" || true
    fi
done

# Special handling for .env
[ -f "/var/www/.env" ] && sudo chmod 664 "/var/www/.env" || true

echo "✅ Automatic permission fixes applied"
EOF