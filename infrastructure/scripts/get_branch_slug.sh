#!/usr/bin/env bash

BRANCH_SLUG=$(echo $1 | cut -c1-8)
if [ "${BRANCH_SLUG: -1}" = "-" ]; then
    BRANCH_SLUG=${BRANCH_SLUG:0:$((${#BRANCH_SLUG} - 1))};
fi

echo $BRANCH_SLUG
