deploy:
	ssh infoeduquiz "cd ~/sites/touri.bgrfacile.com/Api-touri && git pull origin main && make install"

install: vendor/autoload.php .env public/storage
	php artisan cache:clear
	php artisan config:clear
	php artisan config:cache
	php artisan migrate

.env:
	cp .env.example .env
	php artisan key:generate

public/storage:
	php artisan storage:link

vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php

#public/build/manifest.json: package.json
#	npm install
#	npm run build
