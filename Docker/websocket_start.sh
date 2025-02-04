#!/bin/bash
# Inicia o Apache em background
apache2-foreground &

# Verifica se há um script de WebSocket e o inicia
if [ -f "/var/www/html/websocket_server.php" ]; then
    php /var/www/html/websocket_server.php &
fi

# Mantém o container rodando
wait -n