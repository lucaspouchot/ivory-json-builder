#!/usr/bin/env bash

set -e

vendor/bin/phpunit --coverage-clover clover.xml
