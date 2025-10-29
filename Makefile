IMAGE=lib-markdown
USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)
WORKDIR=/tmp
VOLUME=${PWD}:${WORKDIR}
DOCKER_RUN=docker run --rm -it -u $(USER_ID):$(GROUP_ID) -w $(WORKDIR) -v $(VOLUME) $(IMAGE)

.PHONY: build install test coverage xdebug

build:
	docker build -t $(IMAGE) .
	$(DOCKER_RUN) composer i

bash:
	$(DOCKER_RUN) /bin/bash

test:
	$(DOCKER_RUN) vendor/bin/phpunit

coverage:
	$(DOCKER_RUN) php -d pcov.enabled=1 -d pcov.directory=$(WORKDIR) vendor/bin/phpunit --coverage-text

test-debug:
	docker run --rm -it --add-host=host.docker.internal:host-gateway -e XDEBUG_MODE=debug -u $(USER_ID):$(GROUP_ID) -w $(WORKDIR) -v $(VOLUME) $(IMAGE) vendor/bin/phpunit

healthcheck:
	$(DOCKER_RUN) /bin/bash /tmp/healthcheck.sh
