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

ALTER TABLE IF EXISTS ONLY "geom"."admbnd2" DROP CONSTRAINT IF EXISTS "fk___geom__admbnd2___admbnd1_id__admbnd1_id";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd1" DROP CONSTRAINT IF EXISTS "fk___admbnd1__admbnd0_code__admbnd0__code";
ALTER TABLE IF EXISTS ONLY "voc"."chronology" DROP CONSTRAINT IF EXISTS "uq___voc__chronology___name";
ALTER TABLE IF EXISTS ONLY "voc"."chronology" DROP CONSTRAINT IF EXISTS "uq___voc__chronology___code";
ALTER TABLE IF EXISTS ONLY "voc"."chronology" DROP CONSTRAINT IF EXISTS "pk___voc__chronology";
ALTER TABLE IF EXISTS ONLY "tmp"."draft" DROP CONSTRAINT IF EXISTS "pk___tmp__draft";
ALTER TABLE IF EXISTS ONLY "public"."draft" DROP CONSTRAINT IF EXISTS "pk___public__draft";
ALTER TABLE IF EXISTS ONLY "public"."contribute" DROP CONSTRAINT IF EXISTS "pk___public__contribute";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd2" DROP CONSTRAINT IF EXISTS "uq___geom__admbnd2__admbnd1_id__name";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd1" DROP CONSTRAINT IF EXISTS "uq___admbnd1__admbnd0_code__name";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd0" DROP CONSTRAINT IF EXISTS "pk___geom__admbndo";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd2" DROP CONSTRAINT IF EXISTS "pk___geom__admbnd2";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd1" DROP CONSTRAINT IF EXISTS "pk___geom__admbnd1";
ALTER TABLE IF EXISTS ONLY "admin"."users" DROP CONSTRAINT IF EXISTS "users_pk";
ALTER TABLE IF EXISTS ONLY "admin"."user_roles" DROP CONSTRAINT IF EXISTS "user_roles_pk";
ALTER TABLE IF EXISTS ONLY "admin"."user_props" DROP CONSTRAINT IF EXISTS "user_props_pk";
ALTER TABLE IF EXISTS ONLY "admin"."roles" DROP CONSTRAINT IF EXISTS "roles_pk";
ALTER TABLE IF EXISTS ONLY "admin"."role_props" DROP CONSTRAINT IF EXISTS "role_props_pk";
ALTER TABLE IF EXISTS ONLY "admin"."groups" DROP CONSTRAINT IF EXISTS "groups_pk";
ALTER TABLE IF EXISTS ONLY "admin"."group_roles" DROP CONSTRAINT IF EXISTS "group_roles_pk";
ALTER TABLE IF EXISTS ONLY "admin"."group_members" DROP CONSTRAINT IF EXISTS "group_members_pk";
--
-- Name: admin; Type: SCHEMA; Schema: -; Owner: archiraq_admin
--

CREATE SCHEMA "admin";


ALTER SCHEMA "admin" OWNER TO "test_archiraq_admin";

--
-- Name: SCHEMA "admin"; Type: COMMENT; Schema: -; Owner: archiraq_admin
--

COMMENT ON SCHEMA "admin" IS 'Administratin schemao';


--
-- Name: geom; Type: SCHEMA; Schema: -; Owner: archiraq_admin
--

CREATE SCHEMA "geom";


ALTER SCHEMA "geom" OWNER TO "test_archiraq_admin";

--
-- Name: SCHEMA "geom"; Type: COMMENT; Schema: -; Owner: archiraq_admin
--

COMMENT ON SCHEMA "geom" IS 'Geometry tables schema';


--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--




--
-- Name: SCHEMA "public"; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA "public" IS 'standard public schema';


--
-- Name: tmp; Type: SCHEMA; Schema: -; Owner: archiraq_admin
--

CREATE SCHEMA "tmp";


ALTER SCHEMA "tmp" OWNER TO "test_archiraq_admin";

--
-- Name: voc; Type: SCHEMA; Schema: -; Owner: archiraq_admin
--

CREATE SCHEMA "voc";


ALTER SCHEMA "voc" OWNER TO "test_archiraq_admin";

--
-- Name: SCHEMA "voc"; Type: COMMENT; Schema: -; Owner: archiraq_admin
--

COMMENT ON SCHEMA "voc" IS 'Vocabularies schema';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--



--
-- Name: EXTENSION "plpgsql"; Type: COMMENT; Schema: -; Owner: 
--



--
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: 
--



--
-- Name: EXTENSION "postgis"; Type: COMMENT; Schema: -; Owner: 
--



SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: group_members; Type: TABLE; Schema: admin; Owner: archiraq_admin
--

CREATE TABLE "admin"."group_members" (
    "groupname" character varying(128) NOT NULL,
    "username" character varying(128) NOT NULL
);


ALTER TABLE "admin"."group_members" OWNER TO "test_archiraq_admin";

--
-- Name: group_roles; Type: TABLE; Schema: admin; Owner: archiraq_admin
--

CREATE TABLE "admin"."group_roles" (
    "groupname" character varying(64) NOT NULL,
    "rolename" character varying(64) NOT NULL
);


ALTER TABLE "admin"."group_roles" OWNER TO "test_archiraq_admin";

--
-- Name: groups; Type: TABLE; Schema: admin; Owner: archiraq_admin
--

CREATE TABLE "admin"."groups" (
    "name" character varying(128) NOT NULL,
    "enabled" character(1) NOT NULL
);


ALTER TABLE "admin"."groups" OWNER TO "test_archiraq_admin";

--
-- Name: role_props; Type: TABLE; Schema: admin; Owner: archiraq_admin
--

CREATE TABLE "admin"."role_props" (
    "rolename" character varying(128) NOT NULL,
    "propname" character varying(64) NOT NULL,
    "propvalue" character varying(2048)
);


ALTER TABLE "admin"."role_props" OWNER TO "test_archiraq_admin";

--
-- Name: roles; Type: TABLE; Schema: admin; Owner: archiraq_admin
--

CREATE TABLE "admin"."roles" (
    "name" character varying(64) NOT NULL,
    "parent" character varying(64)
);


ALTER TABLE "admin"."roles" OWNER TO "test_archiraq_admin";

--
-- Name: user_props; Type: TABLE; Schema: admin; Owner: archiraq_admin
--

CREATE TABLE "admin"."user_props" (
    "username" character varying(128) NOT NULL,
    "propname" character varying(64) NOT NULL,
    "propvalue" character varying(2048)
);


ALTER TABLE "admin"."user_props" OWNER TO "test_archiraq_admin";

--
-- Name: user_roles; Type: TABLE; Schema: admin; Owner: archiraq_admin
--

CREATE TABLE "admin"."user_roles" (
    "username" character varying(64) NOT NULL,
    "rolename" character varying(64) NOT NULL
);


ALTER TABLE "admin"."user_roles" OWNER TO "test_archiraq_admin";

--
-- Name: users; Type: TABLE; Schema: admin; Owner: archiraq_admin
--

CREATE TABLE "admin"."users" (
    "name" character varying(128) NOT NULL,
    "password" character varying(254),
    "enabled" character(1) NOT NULL
);


ALTER TABLE "admin"."users" OWNER TO "test_archiraq_admin";

--
-- Name: TABLE "users"; Type: COMMENT; Schema: admin; Owner: archiraq_admin
--

COMMENT ON TABLE "admin"."users" IS 'Geoserver JDBC user/group service compliant table 
@see https://docs.geoserver.org/stable/en/user/security/usergrouprole/usergroupservices.html';


--
-- Name: admbnd0; Type: TABLE; Schema: geom; Owner: archiraq_admin
--

CREATE TABLE "geom"."admbnd0" (
    "code" character(2) NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "geom"."admbnd0" OWNER TO "test_archiraq_admin";

--
-- Name: TABLE "admbnd0"; Type: COMMENT; Schema: geom; Owner: archiraq_admin
--

COMMENT ON TABLE "geom"."admbnd0" IS 'Administrative boundaries, level 0 (nations)';


--
-- Name: seq__admbnd1__id; Type: SEQUENCE; Schema: geom; Owner: archiraq_admin
--

CREATE SEQUENCE "geom"."seq__admbnd1__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 32767
    CACHE 1;


ALTER TABLE "geom"."seq__admbnd1__id" OWNER TO "test_archiraq_admin";

--
-- Name: admbnd1; Type: TABLE; Schema: geom; Owner: archiraq_admin
--

CREATE TABLE "geom"."admbnd1" (
    "id" smallint DEFAULT "nextval"('"geom"."seq__admbnd1__id"'::"regclass") NOT NULL,
    "admbnd0_code" character(2) NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "geom"."admbnd1" OWNER TO "test_archiraq_admin";

--
-- Name: seq__admbnd2__id; Type: SEQUENCE; Schema: geom; Owner: archiraq_admin
--

CREATE SEQUENCE "geom"."seq__admbnd2__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "geom"."seq__admbnd2__id" OWNER TO "test_archiraq_admin";

--
-- Name: admbnd2; Type: TABLE; Schema: geom; Owner: archiraq_admin
--

CREATE TABLE "geom"."admbnd2" (
    "id" integer DEFAULT "nextval"('"geom"."seq__admbnd2__id"'::"regclass") NOT NULL,
    "admbnd1_id" smallint NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "geom"."admbnd2" OWNER TO "test_archiraq_admin";

--
-- Name: seq___contribute__id; Type: SEQUENCE; Schema: public; Owner: archiraq_admin
--

CREATE SEQUENCE "public"."seq___contribute__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___contribute__id" OWNER TO "test_archiraq_admin";

--
-- Name: contribute; Type: TABLE; Schema: public; Owner: archiraq_admin
--

CREATE TABLE "public"."contribute" (
    "id" integer DEFAULT "nextval"('"public"."seq___contribute__id"'::"regclass") NOT NULL,
    "email" character varying NOT NULL,
    "contributor" character varying,
    "description" character varying,
    "status" smallint DEFAULT 0 NOT NULL,
    "sha1" character(40) NOT NULL,
    "institution" character varying
);


ALTER TABLE "public"."contribute" OWNER TO "test_archiraq_admin";

--
-- Name: TABLE "contribute"; Type: COMMENT; Schema: public; Owner: archiraq_admin
--

COMMENT ON TABLE "public"."contribute" IS 'Shapefile contributes table';


--
-- Name: seq___public__draft; Type: SEQUENCE; Schema: public; Owner: archiraq_admin
--

CREATE SEQUENCE "public"."seq___public__draft"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___public__draft" OWNER TO "test_archiraq_admin";

--
-- Name: draft; Type: TABLE; Schema: public; Owner: archiraq_admin
--

CREATE TABLE "public"."draft" (
    "id" integer DEFAULT "nextval"('"public"."seq___public__draft"'::"regclass") NOT NULL,
    "contribute_id" integer NOT NULL,
    "entry_id" character(7) NOT NULL,
    "modern_name" character varying,
    "ancient_name" character varying,
    "district" character varying NOT NULL,
    "nearest_city" character varying,
    "cadastre" character varying,
    "sbah_no" character varying,
    "survey_visit_date" character varying,
    "survey_verified_on_field" character(1),
    "survey_type" character varying,
    "survey_prev_refs" "text",
    "features_epigraphic" boolean DEFAULT false,
    "features_ancient_structures" boolean DEFAULT false,
    "features_paleochannels" boolean DEFAULT false,
    "features_remarks" "text",
    "site_chronology" character varying,
    "excavations_whom_when" "text",
    "excavations_bibliography" "text",
    "threats_natural_dunes" boolean DEFAULT false,
    "threats_looting" boolean DEFAULT false,
    "threats_cultivation_trenches" boolean DEFAULT false,
    "threats_modern_structures" boolean DEFAULT false,
    "threats_modern_canals" boolean DEFAULT false,
    "remarks" "text",
    "compiler" character varying NOT NULL,
    "compilation_date" "date" NOT NULL,
    "credits" character varying,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "public"."draft" OWNER TO "test_archiraq_admin";

--
-- Name: seq___tmp__draft; Type: SEQUENCE; Schema: tmp; Owner: archiraq_admin
--

CREATE SEQUENCE "tmp"."seq___tmp__draft"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "tmp"."seq___tmp__draft" OWNER TO "test_archiraq_admin";

--
-- Name: draft; Type: TABLE; Schema: tmp; Owner: archiraq_admin
--

CREATE TABLE "tmp"."draft" (
    "id" integer DEFAULT "nextval"('"tmp"."seq___tmp__draft"'::"regclass") NOT NULL,
    "contribute_id" integer,
    "entry_id" character varying,
    "modern_name" character varying,
    "ancient_name" character varying,
    "district" character varying,
    "nearest_city" character varying,
    "cadastre" character varying,
    "sbah_no" character varying,
    "survey_visit_date" character varying,
    "survey_verified_on_field" character varying,
    "survey_type" character varying,
    "survey_prev_refs" "text",
    "features_epigraphic" character varying,
    "features_ancient_structures" character varying,
    "features_paleochannels" character varying,
    "features_remarks" "text",
    "site_chronology" character varying,
    "excavations_whom_when" "text",
    "excavations_bibliography" "text",
    "threats_natural_dunes" character varying,
    "threats_looting" character varying,
    "threats_cultivation_trenches" character varying,
    "threats_modern_structures" character varying,
    "threats_modern_canals" character varying,
    "remarks" "text",
    "compiler" character varying,
    "compilation_date" character varying,
    "credits" character varying,
    "geom" "public"."geometry"(MultiPolygon,4326)
);


ALTER TABLE "tmp"."draft" OWNER TO "test_archiraq_admin";

--
-- Name: seq___chronology__id; Type: SEQUENCE; Schema: voc; Owner: archiraq_admin
--

CREATE SEQUENCE "voc"."seq___chronology__id"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "voc"."seq___chronology__id" OWNER TO "test_archiraq_admin";

--
-- Name: chronology; Type: TABLE; Schema: voc; Owner: archiraq_admin
--

CREATE TABLE "voc"."chronology" (
    "id" smallint DEFAULT "nextval"('"voc"."seq___chronology__id"'::"regclass") NOT NULL,
    "code" character varying NOT NULL,
    "name" character varying NOT NULL,
    "date_low" integer,
    "date_high" integer,
    CONSTRAINT "ck___voc__chronology___date_low___lte___date_high" CHECK (("date_low" <= "date_high"))
);


ALTER TABLE "voc"."chronology" OWNER TO "test_archiraq_admin";

--
-- Name: group_members_pk; Type: CONSTRAINT; Schema: admin; Owner: archiraq_admin
--

ALTER TABLE ONLY "admin"."group_members"
    ADD CONSTRAINT "group_members_pk" PRIMARY KEY ("groupname", "username");


--
-- Name: group_roles_pk; Type: CONSTRAINT; Schema: admin; Owner: archiraq_admin
--

ALTER TABLE ONLY "admin"."group_roles"
    ADD CONSTRAINT "group_roles_pk" PRIMARY KEY ("groupname", "rolename");


--
-- Name: groups_pk; Type: CONSTRAINT; Schema: admin; Owner: archiraq_admin
--

ALTER TABLE ONLY "admin"."groups"
    ADD CONSTRAINT "groups_pk" PRIMARY KEY ("name");


--
-- Name: role_props_pk; Type: CONSTRAINT; Schema: admin; Owner: archiraq_admin
--

ALTER TABLE ONLY "admin"."role_props"
    ADD CONSTRAINT "role_props_pk" PRIMARY KEY ("rolename", "propname");


--
-- Name: roles_pk; Type: CONSTRAINT; Schema: admin; Owner: archiraq_admin
--

ALTER TABLE ONLY "admin"."roles"
    ADD CONSTRAINT "roles_pk" PRIMARY KEY ("name");


--
-- Name: user_props_pk; Type: CONSTRAINT; Schema: admin; Owner: archiraq_admin
--

ALTER TABLE ONLY "admin"."user_props"
    ADD CONSTRAINT "user_props_pk" PRIMARY KEY ("username", "propname");


--
-- Name: user_roles_pk; Type: CONSTRAINT; Schema: admin; Owner: archiraq_admin
--

ALTER TABLE ONLY "admin"."user_roles"
    ADD CONSTRAINT "user_roles_pk" PRIMARY KEY ("username", "rolename");


--
-- Name: users_pk; Type: CONSTRAINT; Schema: admin; Owner: archiraq_admin
--

ALTER TABLE ONLY "admin"."users"
    ADD CONSTRAINT "users_pk" PRIMARY KEY ("name");


--
-- Name: pk___geom__admbnd1; Type: CONSTRAINT; Schema: geom; Owner: archiraq_admin
--

ALTER TABLE ONLY "geom"."admbnd1"
    ADD CONSTRAINT "pk___geom__admbnd1" PRIMARY KEY ("id");


--
-- Name: pk___geom__admbnd2; Type: CONSTRAINT; Schema: geom; Owner: archiraq_admin
--

ALTER TABLE ONLY "geom"."admbnd2"
    ADD CONSTRAINT "pk___geom__admbnd2" PRIMARY KEY ("id");


--
-- Name: pk___geom__admbndo; Type: CONSTRAINT; Schema: geom; Owner: archiraq_admin
--

ALTER TABLE ONLY "geom"."admbnd0"
    ADD CONSTRAINT "pk___geom__admbndo" PRIMARY KEY ("code");


--
-- Name: uq___admbnd1__admbnd0_code__name; Type: CONSTRAINT; Schema: geom; Owner: archiraq_admin
--

ALTER TABLE ONLY "geom"."admbnd1"
    ADD CONSTRAINT "uq___admbnd1__admbnd0_code__name" UNIQUE ("admbnd0_code", "name");


--
-- Name: uq___geom__admbnd2__admbnd1_id__name; Type: CONSTRAINT; Schema: geom; Owner: archiraq_admin
--

ALTER TABLE ONLY "geom"."admbnd2"
    ADD CONSTRAINT "uq___geom__admbnd2__admbnd1_id__name" UNIQUE ("admbnd1_id", "name");


--
-- Name: pk___public__contribute; Type: CONSTRAINT; Schema: public; Owner: archiraq_admin
--

ALTER TABLE ONLY "public"."contribute"
    ADD CONSTRAINT "pk___public__contribute" PRIMARY KEY ("id");


--
-- Name: pk___public__draft; Type: CONSTRAINT; Schema: public; Owner: archiraq_admin
--

ALTER TABLE ONLY "public"."draft"
    ADD CONSTRAINT "pk___public__draft" PRIMARY KEY ("id");


--
-- Name: pk___tmp__draft; Type: CONSTRAINT; Schema: tmp; Owner: archiraq_admin
--

ALTER TABLE ONLY "tmp"."draft"
    ADD CONSTRAINT "pk___tmp__draft" PRIMARY KEY ("id");


--
-- Name: pk___voc__chronology; Type: CONSTRAINT; Schema: voc; Owner: archiraq_admin
--

ALTER TABLE ONLY "voc"."chronology"
    ADD CONSTRAINT "pk___voc__chronology" PRIMARY KEY ("id");


--
-- Name: uq___voc__chronology___code; Type: CONSTRAINT; Schema: voc; Owner: archiraq_admin
--

ALTER TABLE ONLY "voc"."chronology"
    ADD CONSTRAINT "uq___voc__chronology___code" UNIQUE ("code");


--
-- Name: uq___voc__chronology___name; Type: CONSTRAINT; Schema: voc; Owner: archiraq_admin
--

ALTER TABLE ONLY "voc"."chronology"
    ADD CONSTRAINT "uq___voc__chronology___name" UNIQUE ("name");


--
-- Name: fk___admbnd1__admbnd0_code__admbnd0__code; Type: FK CONSTRAINT; Schema: geom; Owner: archiraq_admin
--

ALTER TABLE ONLY "geom"."admbnd1"
    ADD CONSTRAINT "fk___admbnd1__admbnd0_code__admbnd0__code" FOREIGN KEY ("admbnd0_code") REFERENCES "geom"."admbnd0"("code") MATCH FULL;


--
-- Name: fk___geom__admbnd2___admbnd1_id__admbnd1_id; Type: FK CONSTRAINT; Schema: geom; Owner: archiraq_admin
--

ALTER TABLE ONLY "geom"."admbnd2"
    ADD CONSTRAINT "fk___geom__admbnd2___admbnd1_id__admbnd1_id" FOREIGN KEY ("admbnd1_id") REFERENCES "geom"."admbnd1"("id") MATCH FULL;


--
-- Name: SCHEMA "public"; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA "public" FROM PUBLIC;
REVOKE ALL ON SCHEMA "public" FROM "postgres";
GRANT ALL ON SCHEMA "public" TO "postgres";
GRANT ALL ON SCHEMA "public" TO PUBLIC;


--
-- PostgreSQL database dump complete
--

