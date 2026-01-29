# Docker Quick Start Script for Aiman Fashion (PowerShell)

Write-Host "🚀 Starting Aiman Fashion Docker Setup..." -ForegroundColor Cyan

# Check if .env file exists
if (-not (Test-Path .env)) {
    Write-Host "⚠️  .env file not found. Creating from .env.example..." -ForegroundColor Yellow
    if (Test-Path .env.example) {
        Copy-Item .env.example .env
        Write-Host "✅ .env file created. Please update it with your configuration." -ForegroundColor Green
    } else {
        Write-Host "❌ .env.example not found. Please create .env file manually." -ForegroundColor Red
        exit 1
    }
}

# Build and start containers
Write-Host "📦 Building and starting Docker containers..." -ForegroundColor Cyan
docker-compose up -d --build

# Wait for MariaDB to be ready
Write-Host "⏳ Waiting for MariaDB to be ready..." -ForegroundColor Yellow
Start-Sleep -Seconds 10

# Install PHP dependencies
Write-Host "📥 Installing PHP dependencies..." -ForegroundColor Cyan
docker-compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate application key if needed
Write-Host "🔑 Checking application key..." -ForegroundColor Cyan
$keyCheck = docker-compose exec -T app php artisan key:generate --show 2>&1
if (-not ($keyCheck -match "base64:")) {
    Write-Host "🔑 Generating application key..." -ForegroundColor Cyan
    docker-compose exec -T app php artisan key:generate --force
}

# Set permissions
Write-Host "🔐 Setting permissions..." -ForegroundColor Cyan
docker-compose exec -T app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec -T app chmod -R 775 storage bootstrap/cache

# Install Node dependencies
Write-Host "📦 Installing Node.js dependencies..." -ForegroundColor Cyan
docker-compose exec -T node npm install

Write-Host ""
Write-Host "✅ Docker setup complete!" -ForegroundColor Green
Write-Host ""
Write-Host "📋 Next steps:" -ForegroundColor Cyan
Write-Host "   1. Run migrations: docker-compose exec app php artisan migrate"
Write-Host "   2. Access the application: http://localhost"
Write-Host "   3. View logs: docker-compose logs -f"
Write-Host ""
Write-Host "🎉 Happy coding!" -ForegroundColor Green

