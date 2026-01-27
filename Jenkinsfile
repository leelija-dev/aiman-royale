pipeline {
    agent any
    stages {
        stage('Checking Current Time') {
            steps {
                script {
                    sh '''
                        echo "🚀 Deploying Staging..."
                        date
                    '''
                }
            }
        }
        stage('Deploy') {
            steps {
                script {
                    sh '''
                        echo "🚀 Deploying Staging..."
                        cd /var/www/leelija-dev
                        git checkout staging
                        git pull origin staging

                        # Install PHP dependencies with Composer
                        if command -v composer >/dev/null 2>&1; then
                          echo "📦 Installing PHP dependencies (Composer)"
                          composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
                        else
                          echo "⚠️ Composer is not installed on this agent. Skipping composer install."
                        fi

                        # Run Laravel optimizations and migrations
                        if command -v php >/dev/null 2>&1; then
                          echo "🧹 Clearing and caching Laravel config/routes/views"
                          php artisan cache:clear || true
                          php artisan config:clear || true
                          php artisan route:clear || true
                          php artisan view:clear || true

                          php artisan config:cache || true
                          php artisan route:cache || true
                          php artisan view:cache || true

                          echo "🗄️ Running database migrations"
                          php artisan migrate --force

                          #echo "⚙️ Optimizing framework"
                          #php artisan optimize
                        else
                          echo "⚠️ PHP CLI is not available. Skipping Laravel artisan commands."
                        fi


                        # Install Node dependencies and build assets
                        # Prepare Node environment (supports both system install and nvm)
                        export NVM_DIR="$HOME/.nvm"
                        if [ -s "$NVM_DIR/nvm.sh" ]; then
                          . "$NVM_DIR/nvm.sh"
                          # Try to use LTS if nvm is available
                          nvm use --lts >/dev/null 2>&1 || true
                        fi

                        # Ensure common bin dirs are in PATH so command -v can find npm
                        export PATH="/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin:$PATH"

                        echo "PATH is: $PATH"
                        command -v node >/dev/null 2>&1 && echo "Node: $(node -v)" || echo "Node not found"
                        command -v npm  >/dev/null 2>&1 && echo "NPM:  $(npm -v)"  || echo "NPM not found"

                        NPM_BIN=$(command -v npm || true)
                        if [ -n "$NPM_BIN" ]; then
                          echo "📦 Installing Node dependencies (using $NPM_BIN)"
                          # Prefer clean; fall back to install
                          if "$NPM_BIN" ci --no-audit --quiet; then
                            echo "✅ npm ci completed"
                          else
                            echo "ℹ️ npm ci failed or not applicable, falling back to npm install"
                            "$NPM_BIN" install --no-audit --quiet
                          fi

                          echo "🏗️ Building frontend assets (vite)"
                          NODE_ENV=production "$NPM_BIN" run build
                        else
                          echo "⚠️ npm is not installed or not on PATH for this Jenkins user. Skipping asset build."
                          echo "🔎 Tip: If you use nvm, ensure it's installed for the Jenkins user and available at $NVM_DIR."
                          echo "🔎 Tip: If Node was installed system-wide, ensure npm exists at /usr/bin/npm or /usr/local/bin/npm and PATH includes it."
                        fi
                    '''
                }
            }
        }
    }
}
