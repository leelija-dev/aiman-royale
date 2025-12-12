# Docker Setup for Aiman Fashion

This project uses Docker for development and deployment with the following stack:
- **PHP 8.2** with FPM
- **MariaDB 10.4.32**
- **Node.js 22 LTS** (Alpine)
- **Nginx** (Alpine)
- **Redis** (Alpine)
- **Elasticsearch 7.17.0**
- **Kibana 7.17.0**

## Prerequisites

- Docker Desktop (Windows/Mac) or Docker Engine + Docker Compose (Linux)
- Git

## Quick Start

1. **Clone the repository** (if not already done):
   ```bash
   git clone <repository-url>
   cd aiman-fashion
   ```

2. **Create environment file**:
   ```bash
   cp .env.example .env
   ```

3. **Update `.env` file** with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=mariadb
   DB_PORT=3306
   DB_DATABASE=aiman_fashion
   DB_USERNAME=root
   DB_PASSWORD=root
   
   REDIS_HOST=redis
   REDIS_PORT=6379
   ```

4. **Build and start containers**:
   ```bash
   docker-compose up -d --build
   ```

5. **Install PHP dependencies**:
   ```bash
   docker-compose exec app composer install
   ```

6. **Generate application key**:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

7. **Run database migrations**:
   ```bash
   docker-compose exec app php artisan migrate
   ```

8. **Install Node.js dependencies and build assets**:
   ```bash
   docker-compose exec node npm install
   docker-compose exec node npm run build
   ```

9. **Set proper permissions**:
   ```bash
   docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
   docker-compose exec app chmod -R 775 storage bootstrap/cache
   ```

10. **Access the application**:
    - Application: http://localhost
    - Kibana: http://localhost:5601
    - Elasticsearch: http://localhost:9200

## Common Docker Commands

### Start containers
```bash
docker-compose up -d
```

### Stop containers
```bash
docker-compose down
```

### View logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f mariadb
```

### Execute commands in containers

**PHP/Artisan commands:**
```bash
docker-compose exec app php artisan <command>
docker-compose exec app composer <command>
```

**Node.js/NPM commands:**
```bash
docker-compose exec node npm <command>
docker-compose exec node npm run dev
```

**Database access:**
```bash
docker-compose exec mariadb mysql -u root -proot aiman_fashion
```

**Redis CLI:**
```bash
docker-compose exec redis redis-cli
```

### Rebuild containers
```bash
docker-compose up -d --build
```

### Remove all containers and volumes
```bash
docker-compose down -v
```

## Service Ports

- **Application (Nginx)**: 80 (HTTP), 443 (HTTPS)
- **MariaDB**: 3306
- **Redis**: 6379
- **Elasticsearch**: 9200, 9300
- **Kibana**: 5601
- **Vite Dev Server**: 5173

You can customize these ports in the `.env` file:
```env
APP_PORT=80
APP_HTTPS_PORT=443
FORWARD_DB_PORT=3306
FORWARD_REDIS_PORT=6379
VITE_PORT=5173
```

## Development Workflow

### Running Artisan Commands
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
```

### Running Tests
```bash
docker-compose exec app php artisan test
```

### Frontend Development
For development with hot reload:
```bash
docker-compose exec node npm run dev
```

For production build:
```bash
docker-compose exec node npm run build
```

## Troubleshooting

### Permission Issues
If you encounter permission issues with storage or cache:
```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Database Connection Issues
Ensure your `.env` file has:
```env
DB_HOST=mariadb
DB_PORT=3306
```

### Container Not Starting
Check logs:
```bash
docker-compose logs <service-name>
```

### Clear All Caches
```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

## Production Deployment

For production deployment:

1. Update `.env` with production values
2. Set `APP_ENV=production` and `APP_DEBUG=false`
3. Build optimized assets:
   ```bash
   docker-compose exec node npm run build
   ```
4. Optimize Laravel:
   ```bash
   docker-compose exec app php artisan config:cache
   docker-compose exec app php artisan route:cache
   docker-compose exec app php artisan view:cache
   ```

## Project Structure

```
.
├── docker/
│   ├── nginx/
│   │   └── default.conf          # Nginx configuration
│   ├── php/
│   │   └── local.ini             # PHP configuration
│   └── mariadb/
│       └── my.cnf                # MariaDB configuration
├── Dockerfile                    # PHP 8.2 FPM image
├── docker-compose.yml            # Docker Compose configuration
├── docker-entrypoint.sh          # Container entrypoint script
└── .dockerignore                 # Files to ignore in Docker build
```

## Notes

- The `node_modules` directory is stored in a Docker volume to avoid permission issues
- Database data persists in the `mariadb_data` volume
- Redis data persists in the `redis_data` volume
- Elasticsearch data persists in the `elasticsearch_data` volume

