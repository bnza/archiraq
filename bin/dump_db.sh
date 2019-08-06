#!/usr/bin/env bash

replace_name="archiraq"

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "${DIR}/../" || exit;
source .env.local

db_name=$(echo "${DATABASE_URL}" | grep -Eio '\w+$')

pg_dump --clean --if-exists --schema-only --quote-all-identifiers --no-password -d "${DATABASE_URL}"\
    | grep -v -E '^(DROP|CREATE\ EXTENSION|COMMENT\ ON\ EXTENSION)'\
    | grep -v -E '^(CREATE\ SCHEMA\ "public")'\
    | grep -v -E '^(ALTER\ SCHEMA\ "public"\ OWNER)'\
    | sed -e '/^--/d' \
    | sed "s/\"${db_name}\"/\"${replace_name}\"/g"\
    > assets/sql/db.sql
