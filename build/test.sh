#!/usr/bin/env bash

REGISTERY=financialhouse

docker run --rm ${REGISTERY} ./vendor/bin/phpunit
