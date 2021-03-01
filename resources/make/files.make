DOCKER_RUN=docker run -v $(shell pwd)/src:/app -w /app --rm alpine:latest
ALLOWED_RM_DIRS=tmp|logs|vendor
PERMS_TARGET=.

.PHONY: perms rm%

perms:
	$(DOCKER_RUN) chown -Rf $(shell id -u):$(shell id -u) ${PERMS_TARGET}

rm%:
	$(info Can remove tmp. You can run: rm:tmp, rm:logs, rm:vendor)
	TARGET=$@
# Проверим, что пользователь указал директорию для удаления
	if [ $${#TARGET} -lt 4 ]; then echo 'Allowed rm:tmp, rm:logs, rm:vendor'; exit 1; fi;
# Уберем префикс
	DIR_NAME=$$(echo $@ | sed -E 's/rm:|tmp//g')
# Удаляем только то что можно
	case $${DIR_NAME} in \
		''|${ALLOWED_RM_DIRS}) $(DOCKER_RUN) rm -Rf ./$${DIR_NAME}/*;; \
		*) echo $${DIR_NAME} not in white list. Allowed "${ALLOWED_RM_DIRS}";; \
	esac;
