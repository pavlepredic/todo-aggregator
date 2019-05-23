#!/usr/bin/env bash

URL=todo.${DOMAIN}
if [ ! $BRANCH_SLUG = "master" ]; then
    URL=todo.${BRANCH_SLUG}.${DOMAIN};
fi

echo $URL
