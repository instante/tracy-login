#!/usr/bin/env bash
pushd "$(dirname "$0")/.."

if [ -f "./tests/php.ini" ]; then # remove old php.ini from tests
    rm "./tests/php.ini"
fi

if [ -f "./tests/php-local.ini" ]; then
    cp ./tests/php-local.ini ./tests/php.ini
fi

rm -rf ./tests/temp/*

./vendor/bin/tester ./tests/$1 -p php -c ./tests
EXITCODE=$?

popd

exit "$EXITCODE"
