
.ONESHELL:
.PHONY: migrate

migrate-exec:
	${EXEC} php-bugs bin/cake migrations migrate
	${EXEC} php-bugs bin/cake migrations seed

migrate-add:
	${EXEC} php-bugs bin/cake migrations create $(name)
	make perms

migrate-rollback:
	${EXEC} php-bugs bin/cake migrations rollback

