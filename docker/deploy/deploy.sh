#!/bin/ash

echo "--- Downloading SSLs ---"
echo "Connecting to ssl endpoint at: $EXCELL_HELPER"

curl -H "Authorization: Bearer 12345" -o /app/excell/storage/ssl/ssl.zip "$EXCELL_HELPER"
rm -rf /app/excell/ssl/*
7z e /app/excell/storage/ssl/ssl.zip -o/app/excell/ssl -y > /app/excell/logs/nulp7zip

# Perform any necessary setup or configuration tasks here

# Start supervisord with the specified configuration file
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf