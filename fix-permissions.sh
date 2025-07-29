#!/bin/bash
set -e

echo "🔧 Applying permission fixes on host..."

HOST_UID=$(id -u)
HOST_GID=$(id -g)

# Apply permissions to critical directories
for dir in storage bootstrap/cache; do
    if [ -d "$dir" ]; then
        sudo chown -R $HOST_UID:$HOST_GID "$dir"
        sudo chmod -R 775 "$dir"
        echo "Fixed permissions for $dir"
    fi
done

# Special handling for .env
[ -f ".env" ] && sudo chmod 664 ".env" && echo "Fixed permissions for .env"

echo "✅ Permission fixes applied on host"