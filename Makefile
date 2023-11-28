include src/www.lidonation.com/var/www/.env
sail := src/www.lidonation.com/var/www/vendor/bin/sail

$(eval export $(shell sed -ne 's/ *#.*$$//; /./ s/=.*$$// p' src/www.lidonation.com/var/www/.env))

.PHONY: init
init:
	docker run --rm --interactive --tty \
          --volume ${PWD}/src/www.lidonation.com/var/www/:/app \
          composer install --ignore-platform-reqs
	make up
	sleep 10
	make -j2 backend-install frontend-install lucid-install
	$(sail) artisan key:generate
	rm -rf src/www.lidonation.com/var/www/storage/app/public/*

.PHONY: backend-install
backend-install:
	$(sail) composer i

.PHONY: frontend-install
frontend-install:
	make frontend-clean
	make lucid-install
	$(sail) yarn install

.PHONY: image-build
image-build:
	docker build \
	--build-arg=WWWGROUP=9999 \
	--build-arg=WWWUSER=$UID \
	--build-arg=GITHUB_PACKAGE_REGISTRY_TOKEN=${GITHUB_PACKAGE_REGISTRY_TOKEN} \
	-f src/www.lidonation.com/Dockerfile.dev \
	-t lidonation \
	src/www.lidonation.com/.

.PHONY: lucid-install
lucid-install:
	docker-compose run lidonation.lucid yarn install

.PHONY: up
up:
	$(sail) up -d

.PHONY: seed
seed:
	$(sail) artisan db:seed

.PHONY: migrate
migrate:
	$(sail) artisan migrate

.PHONY: watch
watch:
	 $(sail) up -d && $(sail) npx vite

.PHONY: vite
 vite:
	$(sail) npx vite

.PHONY: build
build:
	$(sail) npx vite build

.PHONY: sh
sh:
	$(sail) shell $(filter-out $@,$(MAKECMDGOALS))

.PHONY: artisan
artisan:
	$(sail) artisan $(filter-out $@,$(MAKECMDGOALS))

.PHONY: test-backend
test-backend:
	mkdir -p $(shell pwd)/src/www.lidonation.com/var/www/tests/reports && \
	docker-compose -f docker-compose.testing.yml up -d && \
	docker-compose exec -t lidonation php /var/www/html/vendor/bin/pest --parallel && \
 	docker-compose -f docker-compose.testing.yml down --volumes

.PHONY: down
down:
	$(sail) down


.PHONY: frontend-clean
frontend-clean:
	rm -rf src/www.lidonation.com/var/www/node_modules 2>/dev/null || true
	rm ./src/www.lidonation.com/var/www/package-lock.json 2>/dev/null || true
	rm ./src/www.lidonation.com/var/www/yarn.lock 2>/dev/null || true
	$(sail) yarn cache clean

.PHONY: lucid-clean
lucid-clean:
	rm -rf ./lucid/node_modules 2>/dev/null || true
	rm ./lucid/package-lock.json 2>/dev/null || true
	rm ./lucid/yarn.lock 2>/dev/null || true

.PHONY: rm
rm:
	$(sail) down -v


.PHONY: logs
logs:
	docker logs --follow lidolovelace-web-fpm-service

.PHONY: lint
lint:
	$(sail) php ./vendor/bin/pint


.PHONY:cp-wasm
cp-wasm:
	cp -v src/www.lidonation.com/var/www/node_modules/lucid-cardano/esm/src/core/libs/cardano_message_signing/cardano_message_signing_bg.wasm \
	src/www.lidonation.com/var/www/node_modules/lucid-cardano/esm/src/core/libs/cardano_multiplatform_lib/cardano_multiplatform_lib_bg.wasm \
	src/www.lidonation.com/var/www/node_modules/.vite/*/