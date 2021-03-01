# Утилита для проверки актуальности .env файла в сравнении с версией из репозитория

#                 Выпилить комменты  Выпилить пустые строки
GET_ENV=cat $(1) | sed 's/^\#.*//g' | sed -r '/^\s*$$/d' | sort | awk -F'=' '{print $$1;}'

.PHONY: ensure-env-actual
.ONESHELL:

ensure-env-actual: .env .env.dist
	@echo === Ensure .env is actual: ===;\
	ENV_TMP_SRC=$$(mktemp);\
	ENV_TMP_DST=$$(mktemp);\
	$(call GET_ENV,.env) > $${ENV_TMP_SRC};\
	$(call GET_ENV,.env.dist) > $${ENV_TMP_DST};\
	diff -u $${ENV_TMP_SRC} $${ENV_TMP_DST} && echo [OK] .env in actual state && exit 0\
	|| echo [ERROR] .env differ from dist && exit 1;\

include .env
