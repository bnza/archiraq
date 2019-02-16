#!/usr/bin/env bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd ${DIR}/../../../../;
source .env.local
pg_dump --clean --if-exists --schema-only --quote-all-identifiers --no-password -d ${DATABASE_URL}\
    | grep -v -E "^(SELECT\ pg_catalog\.set_config\('search_path)"\
    | grep -v -E '^(DROP|CREATE\ EXTENSION|COMMENT\ ON\ EXTENSION)'\
    | grep -v -E '^(CREATE\ SCHEMA\ "public")'\
    | grep -v -E '^(ALTER\ SCHEMA\ "public"\ OWNER)'\
    | grep  -v -E 'COMMENT\ ON\ .*;'\
    | sed 's/^\(.* COMMENT\ ON\ .*\)/;\1/g'\
    | sed -e '/^--/d' \
    | sed 's/\"archiraq_admin\"/\"test_archiraq_admin\"/g'\
    > tests/assets/tdd/sql/db.sql
