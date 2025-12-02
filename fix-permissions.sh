#!/bin/bash

echo "🔐 Ajustando permissões do PresenTrack..."

# Cores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Ajustar permissões do storage e bootstrap/cache
echo -e "${YELLOW}📁 Configurando permissões de diretórios...${NC}"

# Criar diretórios se não existirem
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Ajustar permissões
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Ajustar proprietário (se executado com sudo)
if [ "$EUID" -eq 0 ]; then 
    chown -R www-data:www-data storage
    chown -R www-data:www-data bootstrap/cache
fi

echo -e "${GREEN}✅ Permissões ajustadas com sucesso!${NC}"

# Se estiver usando Docker
if [ -f "docker-compose.yml" ]; then
    echo -e "${YELLOW}🐳 Ajustando permissões no container...${NC}"
    docker-compose exec app chown -R www:www /var/www/html/storage
    docker-compose exec app chown -R www:www /var/www/html/bootstrap/cache
    docker-compose exec app chmod -R 775 /var/www/html/storage
    docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache
    echo -e "${GREEN}✅ Permissões do container ajustadas!${NC}"
fi
