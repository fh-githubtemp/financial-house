#!/usr/bin/env bash

REGISTERY=financialhouse

docker build \
    -t ${REGISTERY} \
    -f ./Dockerfile ../
