# Sistema de Gestão de Eventos - Instituto de Embalagens

Sistema completo para gerenciar eventos e participantes, desenvolvido com Laravel 11, Supabase (PostgreSQL + Auth + Storage) e deploy no Render.com.

## 🚀 Funcionalidades

- ✅ **Gestão de Eventos**: Criar, editar, visualizar e excluir eventos
- ✅ **Gestão de Pessoas**: Cadastro completo de participantes
- ✅ **Controle de Participações**: Associar pessoas aos eventos
- ✅ **Importação Excel/CSV**: Importar listas de pessoas e participações
- ✅ **Histórico de Participações**: Timeline de eventos por pessoa
- ✅ **Dashboard Completo**: Estatísticas e visão geral do sistema
- ✅ **Interface Responsiva**: Bootstrap 5 com design moderno

## 🛠️ Stack Tecnológica

### Backend
- **Laravel 11** - Framework PHP
- **PostgreSQL** - Banco de dados (Supabase)
- **Laravel Excel** - Importação de planilhas

### Frontend
- **Laravel Blade** - Template engine
- **Bootstrap 5** - Framework CSS
- **Font Awesome** - Ícones

### Deploy & Infraestrutura
- **Render.com** - Deploy gratuito
- **Supabase** - PostgreSQL + Auth + Storage (free tier)

## 📋 Pré-requisitos

- PHP 8.1+
- Composer
- Node.js 16+
- NPM
- Conta no Supabase
- Conta no Render.com

## 🔧 Instalação Local

### 1. Clone o repositório
```bash
git clone <repository-url>
cd instituto-embalagens
```

### 2. Instale as dependências
```bash
# Dependências PHP
composer install

# Dependências Node.js
npm install
```

### 3. Configure o ambiente
```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 4. Configure o Supabase

1. Acesse [supabase.com](https://supabase.com) e crie um novo projeto
2. Vá em **Settings > Database** e copie as informações de conexão
3. Atualize o arquivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=db.your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password

SUPABASE_URL=https://your-project.supabase.co
SUPABASE_ANON_KEY=your-anon-key
SUPABASE_SERVICE_KEY=your-service-key
```

### 5. Execute as migrations
```bash
php artisan migrate
```

### 6. Compile os assets
```bash
npm run build
```

### 7. Inicie o servidor
```bash
php artisan serve
```

Acesse: http://localhost:8000

## 🚀 Deploy no Render

### 1. Prepare o repositório
Certifique-se de que todos os arquivos estão commitados no Git:
- `render.yaml`
- `Procfile`
- `build.sh`
- `.env.example`

### 2. Configure o Render

1. Acesse [render.com](https://render.com) e conecte seu repositório
2. Escolha **Web Service**
3. Configure:
   - **Build Command**: `./build.sh`
   - **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`
   - **Environment**: `php`

### 3. Configure as variáveis de ambiente

No painel do Render, adicione as seguintes variáveis:

```env
APP_NAME=Instituto de Embalagens
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-generated-key
APP_URL=https://your-app.onrender.com

DB_CONNECTION=pgsql
DB_HOST=db.your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-supabase-password

SUPABASE_URL=https://your-project.supabase.co
SUPABASE_ANON_KEY=your-anon-key
SUPABASE_SERVICE_KEY=your-service-key

LOG_CHANNEL=stderr
SESSION_DRIVER=database
CACHE_DRIVER=database
```

### 4. Deploy
Clique em **Deploy** e aguarde o processo de build.

## 📊 Uso do Sistema

### Dashboard
- Visão geral com estatísticas
- Eventos recentes
- Pessoas mais ativas
- Ações rápidas

### Gestão de Eventos
- **Criar**: Nome, data e descrição
- **Visualizar**: Lista de participantes
- **Editar**: Atualizar informações
- **Excluir**: Remove evento e participações

### Gestão de Pessoas
- **Cadastrar**: Nome, email, telefone, empresa
- **Visualizar**: Histórico de participações (timeline)
- **Editar**: Atualizar informações
- **Excluir**: Remove pessoa e participações

### Importação de Dados

#### Importar Pessoas
Formato do arquivo Excel/CSV:
```
Nome,Email,Telefone,Empresa
João Silva,joao@email.com,(11) 99999-9999,Empresa ABC
Maria Santos,maria@email.com,(11) 88888-8888,Empresa XYZ
```

#### Importar Participações
Formato do arquivo Excel/CSV:
```
Email,Data Participação,Observações
joao@email.com,22/07/2025 14:30,Participou ativamente
maria@email.com,22/07/2025 14:35,Chegou um pouco atrasada
```

## 🗄️ Estrutura do Banco de Dados

### Tabelas Principais

#### `pessoas`
- `id` - Chave primária
- `nome` - Nome completo
- `email` - Email único
- `telefone` - Telefone (opcional)
- `empresa` - Empresa (opcional)
- `created_at`, `updated_at`

#### `eventos`
- `id` - Chave primária
- `nome` - Nome do evento
- `data` - Data do evento
- `descricao` - Descrição (opcional)
- `created_at`, `updated_at`

#### `participacoes`
- `id` - Chave primária
- `pessoa_id` - FK para pessoas
- `evento_id` - FK para eventos
- `data_participacao` - Data/hora da participação
- `observacoes` - Observações (opcional)
- `created_at`, `updated_at`
- **Unique**: `pessoa_id + evento_id`

## 🔒 Segurança

- Validação de dados em todas as operações
- Proteção CSRF em formulários
- Sanitização de uploads
- Validação de tipos de arquivo
- Limite de tamanho de upload (10MB)

## 📈 Monitoramento

### Logs
- Logs de erro: `storage/logs/laravel.log`
- Logs de importação com estatísticas
- Tratamento de exceções

### Performance
- Cache de configurações em produção
- Cache de rotas e views
- Otimização do autoloader
- Compressão de assets

## 🆘 Solução de Problemas

### Erro de Conexão com Banco
1. Verifique as credenciais do Supabase
2. Confirme se o IP está liberado no Supabase
3. Teste a conexão: `php artisan tinker` → `DB::connection()->getPdo()`

### Erro de Importação
1. Verifique o formato do arquivo
2. Confirme se os cabeçalhos estão corretos
3. Verifique o tamanho do arquivo (máx 10MB)

### Erro de Deploy
1. Verifique se todas as variáveis de ambiente estão configuradas
2. Confirme se o build script tem permissão de execução
3. Verifique os logs do Render

## 📞 Suporte

Para dúvidas ou problemas:
1. Verifique a documentação
2. Consulte os logs de erro
3. Teste em ambiente local primeiro

## 📄 Licença

Este projeto foi desenvolvido para o Instituto de Embalagens.

---

**Desenvolvido com ❤️ usando Laravel + Supabase + Render**

