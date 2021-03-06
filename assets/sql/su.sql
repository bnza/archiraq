--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-1.pgdg18.04+1)
-- Dumped by pg_dump version 10.10 (Ubuntu 10.10-1.pgdg18.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: archiraq; Type: DATABASE; Schema: -; Owner: archiraq_admin
--

CREATE DATABASE "archiraq" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';


ALTER DATABASE "archiraq" OWNER TO "archiraq_admin";

\connect "archiraq"

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
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
-- Name: TABLE "spatial_ref_sys"; Type: ACL; Schema: public; Owner: archiraq_admin
--

REVOKE ALL ON TABLE "public"."spatial_ref_sys" FROM "postgres";
REVOKE SELECT ON TABLE "public"."spatial_ref_sys" FROM PUBLIC;
GRANT ALL ON TABLE "public"."spatial_ref_sys" TO "archiraq_admin";
GRANT SELECT ON TABLE "public"."spatial_ref_sys" TO PUBLIC;


--
-- PostgreSQL database dump complete
--

ALTER TABLE public.spatial_ref_sys OWNER TO archiraq_admin;
