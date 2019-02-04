#!/usr/bin/env bash

replace_name="archiraq"

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd ${DIR}/../;
source .env.local

db_name=$(echo "${DATABASE_URL}" | grep -Eio '\w+$')

pg_dump --create --schema-only --quote-all-identifiers --no-password --exclude-schema='*' -d ${DATABASE_URL}\
    | sed "s/\"${db_name}\"/\"${replace_name}\"/g"\
    > assets/sql/su.sql
