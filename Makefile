serve:
	php -S localhost:4000 -t public/

install:
	composer install && cd frontend && npm install


default: serve

build:
	cd frontend && npm run build
