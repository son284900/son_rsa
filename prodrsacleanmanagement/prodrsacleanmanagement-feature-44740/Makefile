#!make
## -----------------------------
## |  RSA PROJECT              |
## -----------------------------
## -- MAINTAINER --
##  y_kishimoto<yumiko.kishimoto@tap-ic.co.jp>
##
## -- CREATED DATE --
##　2020/01/30
##
## -- REQUIRED PARAMETERS --
##
## -- PERMISSION DENIED --
##  $ cd project/to/
##  $ chmod +x Makefile
##
## -----------------------------

# makefile directory
MAKEFILE_DIR := $(dir $(lastword $(MAKEFILE_LIST)))

# current directory
DIR=${CURDIR}

# read env file
include .env
export $(shell sed 's/=.*//' .env)

# prject name
PROJECT_NAME=$(APP_NAME)

# environment (default dev)
ENV=$(APP_ENV)

# option
OP=

# service name
SN=

# container name
CN=rsa_dev_app

# test optput directory
TOD=all


lint:
	@npm run lint -s


lint-fix:
	@npm run lint:fix -s


sniffer:
	@./vendor/bin/phpcs --standard=phpcs.xml ./


sniffer-fix:
	@./vendor/bin/phpcbf --standard=phpcs.xml ./


jest:
	@npm run test:jest -s


kahlan-html:
	# ex
	# make kahlan-html TOD=rsa
	- rm -r coverage/backend/${TOD}
	- rmdir coverage/backend/${TOD}
	- mkdir coverage/backend/${TOD}

	@if [ ${TOD} == rsa ] ;\
	then \
		docker exec -it $(CN) ./vendor/bin/kahlan --src=app/ --lcov="coverage/backend/rsa-coverage.info"; \
		docker exec -it $(CN) genhtml --output-director coverage/backend/rsa coverage/backend/rsa-coverage.info; \
		rm coverage/backend/*-coverage.info; \
	elif [ ${TOD} == tapfront ];\
	then \
		docker exec -it $(CN) ./vendor/bin/kahlan --src=plugins/tapfront --config=kahlan-config-plugin.php --spec=plugins/tapfront --lcov="coverage/backend/tapfront-coverage.info"; \
		docker exec -it $(CN) genhtml --output-director coverage/backend/tapfront coverage/backend/tapfront-coverage.info; \
		rm coverage/backend/*-coverage.info; \
	elif [ ${TOD} == all ];\
	then \
		docker exec -it $(CN) ./vendor/bin/kahlan --src=app/ --lcov="coverage/backend/tmp-rsa-coverage.info"; \
		docker exec -it $(CN) ./vendor/bin/kahlan --src=plugins/tapfront --config=kahlan-config-plugin.php --spec=plugins/tapfront --lcov="coverage/backend/tmp-tapfront-coverage.info"; \
		docker exec -it $(CN) /bin/sh -c "cd coverage/backend/ && cat tmp-rsa-coverage.info tmp-tapfront-coverage.info > all-coverage.info"; \
		docker exec -it $(CN) genhtml --output-director coverage/backend/all coverage/backend/all-coverage.info; \
		rm coverage/backend/*-coverage.info; \
	fi

	- open coverage/backend/${TOD}/index.html;


kahlan:
	# ex
	# make kahlan TOD=rsa
	# docker exec -it $(CN) ./vendor/bin/kahlan --src=app/ --spec=spec/v1/data;

	@if [ ${TOD} == rsa ] ;\
	then \
		docker exec -it $(CN) ./vendor/bin/kahlan --src=app/; \
	elif [ ${TOD} == tapfront ];\
	then \
		docker exec -it $(CN) ./vendor/bin/kahlan --src=plugins/tapfront --config=kahlan-config-plugin.php --spec=plugins/tapfront; \
	elif [ ${TOD} == all ];\
	then \
		docker exec -it $(CN) ./vendor/bin/kahlan --src=app/; \
		docker exec -it $(CN) ./vendor/bin/kahlan --src=plugins/tapfront --config=kahlan-config-plugin.php --spec=plugins/tapfront; \
	fi


clean:
	@php artisan optimize:clear
	@docker exec -it rsa_dev_app php artisan optimize:clear


info:
	@echo -----------------------
	@echo [ Npm Installed packages ]
	- @npm list

	@echo -----------------------
	@echo [ Composer Installed packages ]
	- @composer list

	@echo -----------------------
	@echo [ Root List ]
	- @php artisan route:list

	@echo -----------------------
