#COLORS
GREEN  := $(shell tput -Txterm setaf 2)
WHITE  := $(shell tput -Txterm setaf 7)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)

# And add help text after each target name starting with '\#\#'
# A category can be added with @category
HELP_COMMAND = \
    %help; \
    while(<>) { push @{$$help{$$2 // 'Commands'}}, [$$1, $$3] if /^([a-zA-Z\-]+)\s*:.*\#\#(?:@([a-zA-Z\-]+))?\s(.*)$$/ }; \
    print "usage: make [target]\n\n"; \
    for (sort keys %help) { \
    print "${WHITE}$$_:${RESET}\n"; \
    for (@{$$help{$$_}}) { \
    $$sep = " " x (32 - length $$_->[0]); \
    print "  ${YELLOW}$$_->[0]${RESET}$$sep${GREEN}$$_->[1]${RESET}\n"; \
    }; \
    print "\n"; }

help: ##@Help Show the list of the commands
	@perl -e '$(HELP_COMMAND)' $(MAKEFILE_LIST)


migrate-db: ## Migrate database
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate -n
	php bin/console doctrine:fixtures:load -n

create-db: ## Create database
	php bin/console doctrine:database:create

drop-db: ## Remove database
	php bin/console doctrine:database:drop --if-exists --force

reset-db: drop-db migrate-db ## Reset database

deploy-prod:
	APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear