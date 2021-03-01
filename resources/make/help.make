.ONESHELL:
.PHONY: help

H1=echo === ${1} ===
BR=echo
TAB=echo "\t"

help:
	@$(call H1,Application)
	@$(TAB) make configure - Настройка конфигов
	@$(TAB) make reinstall - полная переустановка сервиса \(сборка контейнера, сброс БД, composer install\)
	@$(TAB) make install - первоначальная установка или обновление сервиса \(сборка контейнера, composer install\)
	@$(TAB) make status - статус приложения
	@$(TAB) make app-ok - проверка всего сервиса
	@$(TAB) make clean - удаление всех файлов, которые созданы во время установки
	@$(TAB) make cs - проверка качества кода
	$(call H1,Docker)
	@$(TAB) make up - поднять сервис
	@$(TAB) make down - остановка с удалением контейнера
	@$(TAB) make php-cli - войти в bash сервиса php
	@$(TAB) make nginx-cli - войти в shell сервиса nginx
	@$(TAB) make php-log - stdout сервиса php
	@$(TAB) make nginx-log - stdout сервиса nginx
	$(call H1,Files)
	@$(TAB) make perms - выставляет нужные разрешения на все созданные файлы в ходе установки или работы контейнера
	@$(TAB) make rm:vendor - сносит полностью каталог vendor
