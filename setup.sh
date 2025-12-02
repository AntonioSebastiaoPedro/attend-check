#!/bin/bash

echo "🚀 Iniciando configuração do PresenTrack..."

# Cores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Verificar se Docker está instalado
if ! command -v docker &> /dev/null; then
    echo -e "${RED}❌ Docker não está instalado. Por favor, instale o Docker primeiro.${NC}"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}❌ Docker Compose não está instalado. Por favor, instale o Docker Compose primeiro.${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Docker e Docker Compose encontrados${NC}"

# Parar containers existentes
echo -e "${YELLOW}🛑 Parando containers existentes...${NC}"
docker-compose down

# Criar arquivo .env se não existir
if [ ! -f .env ]; then
    echo -e "${YELLOW}📝 Criando arquivo .env...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✅ Arquivo .env criado${NC}"
else
    echo -e "${YELLOW}⚠️  Arquivo .env já existe, pulando...${NC}"
fi

# Construir e iniciar containers
echo -e "${YELLOW}🔨 Construindo imagens Docker...${NC}"
docker-compose build --no-cache

echo -e "${YELLOW}🚀 Iniciando containers...${NC}"
docker-compose up -d

# Aguardar o banco de dados estar pronto
echo -e "${YELLOW}⏳ Aguardando banco de dados...${NC}"
sleep 10

# Instalar dependências do Laravel
echo -e "${YELLOW}📦 Instalando dependências do Composer...${NC}"
docker-compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader

# Gerar chave da aplicação
echo -e "${YELLOW}🔑 Gerando chave da aplicação...${NC}"
docker-compose exec -T app php artisan key:generate

# Executar migrations
echo -e "${YELLOW}🗄️  Executando migrations...${NC}"
docker-compose exec -T app php artisan migrate --force

# Ajustar permissões
echo -e "${YELLOW}🔐 Ajustando permissões...${NC}"
docker-compose exec -T app chown -R www:www /var/www/html
docker-compose exec -T app chmod -R 755 /var/www/html/storage
docker-compose exec -T app chmod -R 755 /var/www/html/bootstrap/cache

# Limpar cache
echo -e "${YELLOW}🧹 Limpando cache...${NC}"
docker-compose exec -T app php artisan config:clear
docker-compose exec -T app php artisan cache:clear
docker-compose exec -T app php artisan view:clear

echo -e "${GREEN}"
echo "=============================================="
echo "✅ Configuração concluída com sucesso!"
echo "=============================================="
echo -e "${NC}"
echo -e "${YELLOW}🌐 Aplicação disponível em:${NC} http://localhost:8000"
echo -e "${YELLOW}🗄️  PgAdmin disponível em:${NC} http://localhost:5050"
echo -e "   Email: admin@presentrack.com"
echo -e "   Senha: admin"
echo ""
echo -e "${YELLOW}📊 Para visualizar logs:${NC} docker-compose logs -f"
echo -e "${YELLOW}🛑 Para parar:${NC} docker-compose down"
echo -e "${YELLOW}♻️  Para reiniciar:${NC} docker-compose restart"
echo ""
