# 📋 PresenTrack - Sistema de Gestão de Assiduidade

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/PostgreSQL-15-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Docker-Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
</p>

## 📖 Sobre o Projeto

**PresenTrack** é um sistema web desenvolvido para facilitar o registo e gestão de assiduidade (presença/ausência) de estudantes em ambientes acadêmicos. O sistema permite que administradores e professores controlem a assiduidade de forma simples, organizada e eficiente, eliminando o uso de papéis e garantindo um acompanhamento preciso dos alunos.

### ✨ Funcionalidades Principais

- 🔐 **Autenticação de Usuários** - Login seguro para administradores e professores
- 👥 **Gestão de Estudantes** - CRUD completo (criar, ler, atualizar, deletar)
- ✅ **Registro de Presença/Ausência** - Marcação rápida e intuitiva
- 📅 **Consulta por Data** - Visualização de registos por período específico
- 📊 **Histórico Individual** - Acompanhamento completo de cada estudante
- 📈 **Relatórios de Assiduidade** - Percentuais e estatísticas visuais
- 🏫 **Gestão de Turmas** - Criação e organização de turmas/salas
- 🔍 **Pesquisa Rápida** - Busca em tempo real de estudantes

## 🛠️ Tecnologias Utilizadas

- **Backend:** Laravel 11+ com PHP 8.2
- **Banco de Dados:** PostgreSQL 15
- **Frontend:** Blade Templates, HTML5, CSS3, JavaScript Vanilla
- **Containerização:** Docker & Docker Compose
- **Servidor Web:** Nginx
- **Gerenciamento de Processos:** Supervisor

---

## 📋 Requisitos

### ✅ Para Windows (Recomendado para este projeto)

**Programas Necessários:**

1. **[Docker Desktop para Windows](https://docs.docker.com/desktop/install/windows-install/)** ⭐ (Inclui Docker Compose)
   - Baixe e instale a versão mais recente
   - Durante a instalação, aceite instalar o WSL2 se solicitado
   
2. **[Git para Windows](https://git-scm.com/download/win)** ⭐
   - Necessário para clonar o repositório
   - Durante a instalação, escolha "Git Bash" como terminal padrão

3. **Editor de Código (Opcional mas recomendado):**
   - [Visual Studio Code](https://code.visualstudio.com/)
   - [PHPStorm](https://www.jetbrains.com/phpstorm/)

**Requisitos do Sistema Windows:**
- ✅ Windows 10/11 64-bit (versão 2004 ou superior)
- ✅ Virtualização habilitada no BIOS/UEFI
- ✅ Mínimo 4GB de RAM (recomendado 8GB ou mais)
- ✅ 20GB de espaço livre em disco

**Como habilitar Virtualização no Windows:**
1. Reinicie o computador e entre no BIOS/UEFI (geralmente F2, F10, DEL ou ESC)
2. Procure por "Virtualization Technology", "Intel VT-x" ou "AMD-V"
3. Habilite a opção e salve

### 🐧 Para Linux

## 🚀 Como Rodar o Projeto

### 🪟 Instruções para Windows

**1️⃣ Abrir o Terminal**

- Abra o **Git Bash** (instalado junto com Git para Windows), ou
- Abra o **PowerShell** como Administrador

**2️⃣ Clonar o Repositório**

```bash
# Navegue até a pasta onde deseja clonar o projeto (ex: Documentos)
cd ~/Documents

# Clone o repositório
git clone https://github.com/AntonioSebastiaoPedro/attend-check.git

# Entre no diretório do projeto
cd attend-check
```

**3️⃣ Verificar se Docker Desktop está Rodando**

- Abra o Docker Desktop
- Aguarde até ver o ícone da baleia na barra de tarefas
- Verifique se está rodando: o ícone não deve estar com "X"

**4️⃣ Configurar Variáveis de Ambiente**

```bash
# No Git Bash ou PowerShell, execute:
cp .env.example .env

# OU no PowerShell (se o comando acima não funcionar):
Copy-Item .env.example .env

# O arquivo .env já está pré-configurado para Docker
# Não é necessário alterá-lo para desenvolvimento local
```
```bash
# Clone o repositório
git clone https://github.com/AntonioSebastiaoPedro/attend-check.git

# Entre no diretório do projeto
cd attend-check
```

### 2️⃣ Configurar Variáveis de Ambiente

```bash
# Copie o arquivo de exemplo
cp .env.example .env

# O arquivo .env já está pré-configurado para Docker
# Não é necessário alterá-lo para desenvolvimento local
```

### 3️⃣ Iniciar os Containers Docker

**Execute os seguintes comandos no terminal (CMD, PowerShell ou Git Bash no Windows):**

```bash
# 1. Construir as imagens Docker
docker-compose build

# 2. Iniciar os containers em segundo plano
docker-compose up -d
```

Aguarde alguns segundos até os containers iniciarem completamente.

### 4️⃣ Configurar a Aplicação Laravel

```bash
# 3. Instalar dependências do PHP/Composer
docker-compose exec app composer install

# 4. Gerar a chave de segurança da aplicação
docker-compose exec app php artisan key:generate

# 5. Executar as migrations do banco de dados
docker-compose exec app php artisan migrate

# 6. Ajustar permissões (necessário apenas no Linux)
# No Windows, pode pular este passo
```

**⚠️ Nota para Windows:** 
- Use PowerShell ou Git Bash para executar os comandos
- Certifique-se que o Docker Desktop está rodando
- Os comandos são os mesmos para Windows e Linux

### 5️⃣ Acessar a Aplicação

Após concluir os passos anteriores, abra seu navegador e acesse:

- **🌐 Aplicação PresenTrack:** [http://localhost:8000](http://localhost:8000)
- **🗄️ PgAdmin (Gerenciador PostgreSQL):** [http://localhost:5050](http://localhost:5050)
  - Email: `admin@presentrack.com`
  - Senha: `admin`

### 6️⃣ Credenciais do Banco de Dados (Para usar no PgAdmin)

Para conectar ao PostgreSQL via PgAdmin, use:

```
Host: db
Port: 5432
Database: presentrack
Username: presentrack_user
Password: presentrack_pass
```

---

## 🔧 Comandos Úteis

### Gerenciar Containers

```bash
# Iniciar containers
docker-compose up -d

# Parar containers
docker-compose down

# Reiniciar containers
docker-compose restart

# Ver logs em tempo real
docker-compose logs -f

# Ver logs de um serviço específico
docker-compose logs -f app

# Ver status dos containers
docker-compose ps
```

### Laravel Artisan

```bash
# Acessar o container
docker-compose exec app bash

# Executar comandos Artisan
docker-compose exec app php artisan [comando]

# Exemplos:
docker-compose exec app php artisan migrate
docker-compose exec app php artisan make:model Student
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:list
```

### Composer

```bash
# Instalar dependências
docker-compose exec app composer install

# Adicionar pacote
docker-compose exec app composer require [pacote]

# Atualizar dependências
docker-compose exec app composer update
```

---
## 🐛 Solução de Problemas

### ⚠️ Docker Desktop não está rodando (Windows)

**Erro:** `Cannot connect to the Docker daemon`

**Solução:**
1. Abra o Docker Desktop
2. Aguarde até inicializar completamente
3. Tente executar os comandos novamente

### ⚠️ Porta já está em uso

**Erro:** `Bind for 0.0.0.0:8000 failed: port is already allocated`

**Solução:**
```bash
# Descubra qual processo está usando a porta
# Windows (PowerShell):
netstat -ano | findstr :8000

# Pare o processo ou altere a porta no docker-compose.yml
```

### ⚠️ Erro de Permissão (Apenas Linux)

```bash
# Execute o script de correção
./fix-permissions.sh

# Ou manualmente:
docker-compose exec app chmod -R 777 storage bootstrap/cache
docker-compose exec app chown -R www:www storage bootstrap/cache
```

### ⚠️ Container Não Inicia   # Configuração do Nginx
│   ├── php/               # Configuração do PHP
│   └── supervisor/        # Configuração do Supervisor
├── public/                 # Arquivos públicos (CSS, JS, imagens)
├── resources/              # Views Blade, CSS, JS
│   ├── views/             # Templates Blade
│   ├── css/               # Arquivos CSS
│   └── js/                # Arquivos JavaScript
├── routes/                 # Rotas da aplicação
│   ├── web.php            # Rotas web
│   └── api.php            # Rotas da API
├── storage/                # Arquivos gerados (logs, cache)
├── tests/                  # Testes automatizados
├── .env.example            # Exemplo de variáveis de ambiente
├── docker-compose.yml      # Orquestração dos containers
### ⚠️ WSL2 não está instalado (Windows)

**Erro:** `WSL 2 installation is incomplete`

**Solução:**
1. Abra PowerShell como Administrador
2. Execute: `wsl --install`
3. Reinicie o computador
4. Abra o Docker Desktop novamente

### ⚠️ Virtualização não está habilitada (Windows)

**Erro:** `Hardware assisted virtualization and data execution protection must be enabled`

**Solução:**
1. Reinicie o PC e entre no BIOS/UEFI (F2, F10, DEL ou ESC durante boot)
2. Procure por "Virtualization Technology", "Intel VT-x" ou "AMD-V"
3. Habilite e salve (F10)
4. Reinicie o computador

### ⚠️ Comando 'docker-compose' não reconhecido (Windows)

**Solução:**
- Use `docker compose` (sem hífen) em vez de `docker-compose`
- Exemplo: `docker compose up -d`
### Erro de Permissão

```bash
# Execute o script de correção
./fix-permissions.sh

# Ou manualmente:
docker-compose exec app chmod -R 777 storage bootstrap/cache
docker-compose exec app chown -R www:www storage bootstrap/cache
```

### Container Não Inicia

```bash
# Pare e remova os containers
docker-compose down

# Recrie os containers
docker-compose up -d --force-recreate
```

### Banco de Dados Não Conecta

```bash
# Verifique o status dos containers
docker-compose ps

# Reinicie o banco de dados
docker-compose restart db

# Aguarde alguns segundos e tente novamente
sleep 10
docker-compose exec app php artisan migrate
```

### Limpar Tudo e Recomeçar

```bash
# Para e remove containers e volumes
docker-compose down -v

# Remove imagens Docker (opcional)
docker-compose down --rmi all

# Execute o setup novamente
./setup.sh
```

### Porta Já em Uso

Se a porta 8000 já estiver em uso, edite o `docker-compose.yml`:

```yaml
services:
  app:
    ports:
      - "8080:80"  # Altere para outra porta
```

---

## 📚 Documentação

- [Especificação de Requisitos (ERS)](./guide.md)
- [Documentação Laravel](https://laravel.com/docs)
- [Documentação PostgreSQL](https://www.postgresql.org/docs/)
- [Documentação Docker](https://docs.docker.com/)

---

## 👥 Contribuir

Contribuições são bem-vindas! Sinta-se à vontade para:

1. Fazer um fork do projeto
2. Criar uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abrir um Pull Request

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## 👨‍💻 Autor

**Antonio Sebastião Pedro**

- GitHub: [@AntonioSebastiaoPedro](https://github.com/AntonioSebastiaoPedro)
- LinkedIn: [Antonio Sebastião Pedro](https://www.linkedin.com/in/antonio-sebastiao-pedro)

---

## 🙏 Agradecimentos

Desenvolvido como parte do projeto acadêmico da UNIA (Universidade de Informática Aplicada).

---

<p align="center">Feito com ❤️ por Antonio Sebastião Pedro</p>

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
