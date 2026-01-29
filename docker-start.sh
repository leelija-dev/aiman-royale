#!/bin/bash

# Docker Quick Start Script for Aiman Fashion

set -e

echo "🚀 Starting Aiman Fashion Docker Setup..."

# Check if .env file exists
if [ ! -f .env ]; then
    echo "⚠️  .env file not found. Creating from .env.example..."
    if [ -f .env.example ]; then
        cp .env.example .env
        echo "✅ .env file created. Please update it with your configuration."
    else
        echo "❌ .env.example not found. Please create .env file manually."
        exit 1
    fi
fi

# Build and start containers
echo "📦 Building and starting Docker containers..."
docker-compose up -d --build

# Wait for MariaDB to be ready
echo "⏳ Waiting for MariaDB to be ready..."
sleep 10

# Install PHP dependencies
echo "📥 Installing PHP dependencies..."
docker-compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader

# Install Bagisto
echo "🔑 Installing Bagisto..."
docker-compose exec -T app php artisan bagisto:install --force

# Set permissions
echo "🔐 Setting permissions..."
docker-compose exec -T app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec -T app chmod -R 775 storage bootstrap/cache

# Install Node dependencies
echo "📦 Installing Node.js dependencies..."
docker-compose exec -T node npm install --production

# Build assets
echo "📦 Building assets..."
docker-compose exec -T node npm run build

echo ""
echo "✅ Docker setup complete!"
echo ""
echo "📋 Next steps:"
echo "   1. Run migrations: docker-compose exec app php artisan migrate"
echo "   2. Access the application: http://localhost"
echo "   3. View logs: docker-compose logs -f"
echo ""
echo "🎉 Happy coding!"

