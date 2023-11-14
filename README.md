[![Gitpod ready-to-code](https://img.shields.io/badge/Gitpod-ready--to--code-blue?logo=gitpod)](https://gp.raddcreative.io/#https://git.raddcreative.io/lidonation/lidonation)

# Running on docker-compose
### Local ENV [must be set]
**CARDANO_NETWORK**=local

## Pre-Requisites
* docker
* docker-compose
* yarn

## Web root
`./src/www.lidonation.com/var/www/`


## Getting Started

### Create files and folders
Make sure you run these commands from project root. copy and run this as one command to create data dirs.
```bash
mkdir -p ./data/dbsync/data &&\
mkdir -p ./data/dbsync/tmp &&\
mkdir -p ./data/postgres/cdbsync/data &&\
mkdir -p ./data/relay/data/db &&\
mkdir -p ./data/relay/data/ipc &&\
mkdir -p ./data/www/data &&\
mkdir -p ./data/www/db/data
```

### Create .env file from sample
Ask for credentials for these two files from a team member
```bash
cp ./src/www.lidonation.com/var/www/.env.example ./src/www.lidonation.com/var/www/.env
cp ./src/www.lidonation.com/var/www/.npmrc.example ./src/www.lidonation.com/var/www/.npmrc
```
**Ask a teammate for values for your local .env file**

### Make postgres passwords
```bash
echo cexplorer > src/pool/config/db-sync/secrets/postgres_db &&\
echo postgres > src/pool/config/db-sync/secrets/postgres_user &&\
echo v8hlDV0yMAHHlIurYupj > src/pool/config/db-sync/secrets/postgres_password
``` 

### login into docker registry [your gitlab login]  
```bash
docker login registry.lidonation.com
```

Install laravel dependencies
```bash
# cd to web root
cd ./src/www.lidonation.com/var/www/

# composer install
composer install -o --ignore-platform-reqs

# install node packages
yarn install
```

### boot up your box (for mac)
from the root directory. This will boot up all services (on producer node, one relay node, redis, and the website) in the background  
```bash
npm run box:start
``` 

### boot up your box (for linux)
from the root directory. This will boot up all services (on producer node, one relay node, redis, and the website) in the background  
```bash
    sudo su
    docker-compose up -d
``` 

from the root directory. This will start your frontend services
```bash
    npm run build
``` 


### backend migrations
ssh into api container and run some commands:
```bash
npm run ssh:web

## on ubuntu
docker exec -it lido_web bash

# ps; you only have to run this once, the first time your setup your environment
php artisan migrate
```

### build search engine
ssh into api container. Make sure you have two terminal sessions running the api container
```bash
## terminal 1: listen for queued jobs
php artisan queue:listen

## terminal 2: run the following commands to build the search engine
php artisan db:seed --class=SearchIndexSeeder
php artisan scout:import 'App\Models\CatalystExplorer\Proposal'
php artisan scout:import 'App\Models\CatalystExplorer\CatalystUser'
php artisan scout:import "App\Models\CatalystExplorer\Group"
php artisan scout:import 'App\Models\Post'
php artisan scout:import 'App\Models\CatalystExplorer\Assessment'


```





# Folder Structure
#### src/www.lidonation.com/var/www
Root of the laravel application powering www.lidonation.com

## Installing Locally
1. open two terminal sessions
2. navigate to src/www.lidonation.com/var/www
3. run yarn install
4. open src/www.lidonation.com/var/www in another terminal
5. run composer install -o

# Best Practice


# Updating Base image
Set BUILD_BASE_IMAGE to true and set the tag/version via BASE_IMAGE_VER to rebuild the base image.

# Command Issues
git error: `fatal: unable to access 'https://git.raddcreative.io/lidonation/lidonation.git/': server certificate verification failed. CAfile: none CRLfile: none`
Solution: run `git config --global http.sslverify false`

docker registry `denied: access forbidden` error
Solution: run `docker login registry.lidonation.com` and log in using your gitlab credentials

Errors about search index not existing.
Search indexes should be created in a seeder. If your seeder errored while running, you may have to run the seeder for search index directly to resolve this error.
`php artisan db:seed --class='SearchIndexSeeder'` should do it

# Getting an API key from CoinMarketCap
Head over to https://pro.coinmarketcap.com and click on GET YOUR API KEY NOW, sign up or login.
An API key should already be provided on the dashboard. You can just copy and use it.