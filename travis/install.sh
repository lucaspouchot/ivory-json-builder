#!/usr/bin/env bash

set -e

composer self-update
composer remove --no-update --dev friendsofphp/php-cs-fixer

composer update --prefer-source
