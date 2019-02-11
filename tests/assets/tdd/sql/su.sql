-- Unit test DB script. intended to be used in CI
-- Creates "archiraq_admin" role with encrypted password "password", the archiraq DB with the required extension
-- Requires superuser

\set ON_ERROR_STOP on

DROP ROLE IF EXISTS "test_archiraq_admin";
CREATE ROLE "test_archiraq_admin";
ALTER ROLE "test_archiraq_admin" WITH NOSUPERUSER NOINHERIT CREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'md5d5e83e13a426bfe2e4ccf93a10f3f931';

DROP DATABASE IF EXISTS "test_archiraq";

-- pg_dump --create --schema-only --quote-all-identifiers --no-password --exclude-schema='*' -d postgresql://superuser:password@localhost:5432/archiraq

--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.15
-- Dumped by pg_dump version 9.5.15

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: test_archiraq; Type: DATABASE; Schema: -; Owner: archiraq_admin
--

CREATE DATABASE "test_archiraq" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';


ALTER DATABASE "test_archiraq" OWNER TO "test_archiraq_admin";

\connect "test_archiraq"

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS "plpgsql" WITH SCHEMA "pg_catalog";


--
-- Name: EXTENSION "plpgsql"; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION "plpgsql" IS 'PL/pgSQL procedural language';


--
-- Name: postgis; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS "postgis" WITH SCHEMA "public";


--
-- Name: EXTENSION "postgis"; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION "postgis" IS 'Postgis extension';


--
-- PostgreSQL database dump complete
--

ALTER SCHEMA "public" OWNER TO "test_archiraq_admin";
