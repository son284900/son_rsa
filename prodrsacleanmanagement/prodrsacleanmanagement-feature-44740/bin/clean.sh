#!/bin/bash
## -----------------------------
## |  RSA PROJECT              |
## -----------------------------
## -- MAINTAINER --
##  y_kishimoto<yumiko.kishimoto@tap-ic.co.jp>
##
## -- CREATED DATE --
##　2020/01/24
##
## -- PERMISSION DENIED --
##  $ cd project/to/
##  $ chmod +x Makefile
##
## -----------------------------

. config.sh

echo "************************************"
echo "Clean Processing Start....."
source ~/.bash_profile
source ~/.bashrc

cd $ROOT_DIR
composer dump-autoload
npm run dev
php artisan optimize:clear
php artisan route:list

echo "Clean Processing End....."
