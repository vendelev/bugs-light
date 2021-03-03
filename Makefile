RESOURCES_DIR=./resources/make

.ONESHELL:

include ${RESOURCES_DIR}/help.make
include ${RESOURCES_DIR}/env.make
include ${RESOURCES_DIR}/db.make
include ${RESOURCES_DIR}/docker.make
include ${RESOURCES_DIR}/files.make
include ${RESOURCES_DIR}/app.make
