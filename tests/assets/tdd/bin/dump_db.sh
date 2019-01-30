#!/usr/bin/env bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd ${DIR}/../../../../;
#cd "$(dirname "$0")"/../../../../
source .env.local
pg_dump --clean --if-exists --schema-only --quote-all-identifiers --no-password -d ${DATABASE_URL}| grep -v -E '^(DROP|CREATE\ EXTENSION|COMMENT\ ON\ EXTENSION)'| grep -v -E '^(CREATE\ SCHEMA\ "public")'| grep -v -E '^(ALTER\ SCHEMA\ "public"\ OWNER)'| sed 's/\"archiraq_admin\"/\"test_archiraq_admin\"/g' > tests/assets/tdd/sql/db.sql
