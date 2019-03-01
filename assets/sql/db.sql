

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

ALTER TABLE IF EXISTS ONLY "tmp"."draft_error" DROP CONSTRAINT IF EXISTS "fk___tmp__draft_error___tmp__draft";
ALTER TABLE IF EXISTS ONLY "tmp"."draft" DROP CONSTRAINT IF EXISTS "fk___tmp__draft___public__contribute";
ALTER TABLE IF EXISTS ONLY "public"."site_survey" DROP CONSTRAINT IF EXISTS "pk___site_survey___survey";
ALTER TABLE IF EXISTS ONLY "public"."site_survey" DROP CONSTRAINT IF EXISTS "fk___site_survey___voc__survey";
ALTER TABLE IF EXISTS ONLY "public"."site_chronology" DROP CONSTRAINT IF EXISTS "fk___site_chronology___voc__chronology";
ALTER TABLE IF EXISTS ONLY "public"."site_chronology" DROP CONSTRAINT IF EXISTS "fk___site_chronology___site";
ALTER TABLE IF EXISTS ONLY "public"."site" DROP CONSTRAINT IF EXISTS "fk___public__site___public__contribute";
ALTER TABLE IF EXISTS ONLY "public"."site" DROP CONSTRAINT IF EXISTS "fk___public__site___geom__admbnd2";
ALTER TABLE IF EXISTS ONLY "public"."draft" DROP CONSTRAINT IF EXISTS "fk___public__draft___public__contribute";
ALTER TABLE IF EXISTS ONLY "geom"."site" DROP CONSTRAINT IF EXISTS "fk___geom__site___public__site";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd2" DROP CONSTRAINT IF EXISTS "fk___geom__admbnd2___admbnd1_id__admbnd1_id";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd1" DROP CONSTRAINT IF EXISTS "fk___admbnd1__admbnd0_code__admbnd0__code";
ALTER TABLE IF EXISTS ONLY "voc"."survey" DROP CONSTRAINT IF EXISTS "uq___voc__survey__name";
ALTER TABLE IF EXISTS ONLY "voc"."chronology" DROP CONSTRAINT IF EXISTS "uq___voc__chronology___name";
ALTER TABLE IF EXISTS ONLY "voc"."chronology" DROP CONSTRAINT IF EXISTS "uq___voc__chronology___code";
ALTER TABLE IF EXISTS ONLY "voc"."survey" DROP CONSTRAINT IF EXISTS "pk___voc__survey";
ALTER TABLE IF EXISTS ONLY "voc"."chronology" DROP CONSTRAINT IF EXISTS "pk___voc__chronology";
ALTER TABLE IF EXISTS ONLY "tmp"."draft_error" DROP CONSTRAINT IF EXISTS "pk___tmp__draft_error";
ALTER TABLE IF EXISTS ONLY "tmp"."draft" DROP CONSTRAINT IF EXISTS "pk___tmp__draft";
ALTER TABLE IF EXISTS ONLY "public"."site_chronology" DROP CONSTRAINT IF EXISTS "uq___site_chronology__site_id__chronology_id";
ALTER TABLE IF EXISTS ONLY "public"."site" DROP CONSTRAINT IF EXISTS "uq___public__site___sbah_reg_no";
ALTER TABLE IF EXISTS ONLY "public"."site" DROP CONSTRAINT IF EXISTS "uq___public__site___contribute_id__entry_id";
ALTER TABLE IF EXISTS ONLY "public"."draft" DROP CONSTRAINT IF EXISTS "uq___public__draft__contribute_id__entry_id";
ALTER TABLE IF EXISTS ONLY "public"."site_survey" DROP CONSTRAINT IF EXISTS "pk___site_survey";
ALTER TABLE IF EXISTS ONLY "public"."site_chronology" DROP CONSTRAINT IF EXISTS "pk___site_chronology";
ALTER TABLE IF EXISTS ONLY "public"."site" DROP CONSTRAINT IF EXISTS "pk___public__site";
ALTER TABLE IF EXISTS ONLY "public"."draft" DROP CONSTRAINT IF EXISTS "pk___public__draft";
ALTER TABLE IF EXISTS ONLY "public"."contribute" DROP CONSTRAINT IF EXISTS "pk___public__contribute";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd2" DROP CONSTRAINT IF EXISTS "uq___geom__admbnd2__admbnd1_id__name";
ALTER TABLE IF EXISTS ONLY "geom"."admbnd1" DROP CONSTRAINT IF EXISTS "uq___admbnd1__admbnd0_code__name";
ALTER TABLE IF EXISTS ONLY "geom"."site" DROP CONSTRAINT IF EXISTS "pk___geom__site";
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

CREATE SCHEMA "admin";


ALTER SCHEMA "admin" OWNER TO "archiraq_admin";


COMMENT ON SCHEMA "admin" IS 'Administratin schemao';



CREATE SCHEMA "geom";


ALTER SCHEMA "geom" OWNER TO "archiraq_admin";


COMMENT ON SCHEMA "geom" IS 'Geometry tables schema';







COMMENT ON SCHEMA "public" IS 'standard public schema';



CREATE SCHEMA "tmp";


ALTER SCHEMA "tmp" OWNER TO "archiraq_admin";


CREATE SCHEMA "voc";


ALTER SCHEMA "voc" OWNER TO "archiraq_admin";


COMMENT ON SCHEMA "voc" IS 'Vocabularies schema';














SET default_tablespace = '';

SET default_with_oids = false;


CREATE TABLE "admin"."group_members" (
    "groupname" character varying(128) NOT NULL,
    "username" character varying(128) NOT NULL
);


ALTER TABLE "admin"."group_members" OWNER TO "archiraq_admin";


CREATE TABLE "admin"."group_roles" (
    "groupname" character varying(64) NOT NULL,
    "rolename" character varying(64) NOT NULL
);


ALTER TABLE "admin"."group_roles" OWNER TO "archiraq_admin";


CREATE TABLE "admin"."groups" (
    "name" character varying(128) NOT NULL,
    "enabled" character(1) NOT NULL
);


ALTER TABLE "admin"."groups" OWNER TO "archiraq_admin";


CREATE TABLE "admin"."role_props" (
    "rolename" character varying(128) NOT NULL,
    "propname" character varying(64) NOT NULL,
    "propvalue" character varying(2048)
);


ALTER TABLE "admin"."role_props" OWNER TO "archiraq_admin";


CREATE TABLE "admin"."roles" (
    "name" character varying(64) NOT NULL,
    "parent" character varying(64)
);


ALTER TABLE "admin"."roles" OWNER TO "archiraq_admin";


CREATE TABLE "admin"."user_props" (
    "username" character varying(128) NOT NULL,
    "propname" character varying(64) NOT NULL,
    "propvalue" character varying(2048)
);


ALTER TABLE "admin"."user_props" OWNER TO "archiraq_admin";


CREATE TABLE "admin"."user_roles" (
    "username" character varying(64) NOT NULL,
    "rolename" character varying(64) NOT NULL
);


ALTER TABLE "admin"."user_roles" OWNER TO "archiraq_admin";


CREATE TABLE "admin"."users" (
    "name" character varying(128) NOT NULL,
    "password" character varying(254),
    "enabled" character(1) NOT NULL
);


ALTER TABLE "admin"."users" OWNER TO "archiraq_admin";


COMMENT ON TABLE "admin"."users" IS 'Geoserver JDBC user/group service compliant table 
@see https://docs.geoserver.org/stable/en/user/security/usergrouprole/usergroupservices.html';



CREATE TABLE "geom"."admbnd0" (
    "code" character(2) NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "geom"."admbnd0" OWNER TO "archiraq_admin";


COMMENT ON TABLE "geom"."admbnd0" IS 'Administrative boundaries, level 0 (nations)';



CREATE SEQUENCE "geom"."seq__admbnd1__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 32767
    CACHE 1;


ALTER TABLE "geom"."seq__admbnd1__id" OWNER TO "archiraq_admin";


CREATE TABLE "geom"."admbnd1" (
    "id" smallint DEFAULT "nextval"('"geom"."seq__admbnd1__id"'::"regclass") NOT NULL,
    "admbnd0_code" character(2) NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "geom"."admbnd1" OWNER TO "archiraq_admin";


CREATE SEQUENCE "geom"."seq__admbnd2__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "geom"."seq__admbnd2__id" OWNER TO "archiraq_admin";


CREATE TABLE "geom"."admbnd2" (
    "id" integer DEFAULT "nextval"('"geom"."seq__admbnd2__id"'::"regclass") NOT NULL,
    "admbnd1_id" smallint NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "geom"."admbnd2" OWNER TO "archiraq_admin";


CREATE SEQUENCE "geom"."seq___geom__site"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "geom"."seq___geom__site" OWNER TO "archiraq_admin";


CREATE TABLE "geom"."site" (
    "id" integer NOT NULL,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "geom"."site" OWNER TO "archiraq_admin";


CREATE SEQUENCE "public"."seq___contribute__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___contribute__id" OWNER TO "archiraq_admin";


CREATE TABLE "public"."contribute" (
    "id" integer DEFAULT "nextval"('"public"."seq___contribute__id"'::"regclass") NOT NULL,
    "email" character varying NOT NULL,
    "contributor" character varying,
    "description" character varying,
    "status" smallint DEFAULT 0 NOT NULL,
    "sha1" character(40) NOT NULL,
    "institution" character varying
);


ALTER TABLE "public"."contribute" OWNER TO "archiraq_admin";


COMMENT ON TABLE "public"."contribute" IS 'Shapefile contributes table';



CREATE SEQUENCE "public"."seq___public__draft"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___public__draft" OWNER TO "archiraq_admin";


CREATE TABLE "public"."draft" (
    "id" integer DEFAULT "nextval"('"public"."seq___public__draft"'::"regclass") NOT NULL,
    "contribute_id" integer NOT NULL,
    "entry_id" character varying NOT NULL,
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


ALTER TABLE "public"."draft" OWNER TO "archiraq_admin";


CREATE SEQUENCE "public"."seq___site__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___site__id" OWNER TO "archiraq_admin";


CREATE SEQUENCE "public"."seq___site_chronology__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___site_chronology__id" OWNER TO "archiraq_admin";


CREATE SEQUENCE "public"."seq___site_survey__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___site_survey__id" OWNER TO "archiraq_admin";


CREATE TABLE "public"."site" (
    "id" integer DEFAULT "nextval"('"public"."seq___site__id"'::"regclass") NOT NULL,
    "contribute_id" integer NOT NULL,
    "entry_id" character varying,
    "nearest_city" character varying,
    "ancient_name" character varying,
    "ancient_name_uncertain" boolean,
    "modern_name" character varying,
    "cadastre" character varying,
    "compiler" character varying NOT NULL,
    "compilation_date" "date" NOT NULL,
    "remarks" "text",
    "credits" character varying,
    "sbah_no" character varying,
    "features_epigraphic" boolean,
    "features_ancient_structures" boolean,
    "features_paleochannels" boolean,
    "features_remarks" "text",
    "threats_natural_dunes" boolean,
    "threats_looting" boolean,
    "threats_cultivation_trenches" boolean,
    "threats_modern_structures" boolean,
    "threats_modern_canals" boolean,
    "district_id" smallint NOT NULL
);


ALTER TABLE "public"."site" OWNER TO "archiraq_admin";


CREATE TABLE "public"."site_chronology" (
    "id" integer DEFAULT "nextval"('"public"."seq___site_chronology__id"'::"regclass") NOT NULL,
    "site_id" integer NOT NULL,
    "chronology_id" integer NOT NULL
);


ALTER TABLE "public"."site_chronology" OWNER TO "archiraq_admin";


CREATE TABLE "public"."site_survey" (
    "id" integer DEFAULT "nextval"('"public"."seq___site_survey__id"'::"regclass") NOT NULL,
    "survey_id" integer NOT NULL,
    "site_id" integer NOT NULL,
    "ref" character varying,
    "year_low" smallint,
    "year_high" smallint,
    "remarks" "text"
);


ALTER TABLE "public"."site_survey" OWNER TO "archiraq_admin";


CREATE SEQUENCE "tmp"."seq___draft__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "tmp"."seq___draft__id" OWNER TO "archiraq_admin";


CREATE TABLE "tmp"."draft" (
    "id" integer DEFAULT "nextval"('"tmp"."seq___draft__id"'::"regclass") NOT NULL,
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
    "geom" "public"."geometry"
);


ALTER TABLE "tmp"."draft" OWNER TO "archiraq_admin";


CREATE SEQUENCE "tmp"."seq___draft_error__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "tmp"."seq___draft_error__id" OWNER TO "archiraq_admin";


CREATE TABLE "tmp"."draft_error" (
    "id" integer DEFAULT "nextval"('"tmp"."seq___draft_error__id"'::"regclass") NOT NULL,
    "draft_id" integer NOT NULL,
    "path" character varying,
    "message" "text" NOT NULL
);


ALTER TABLE "tmp"."draft_error" OWNER TO "archiraq_admin";


CREATE SEQUENCE "voc"."seq___chronology__id"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "voc"."seq___chronology__id" OWNER TO "archiraq_admin";


CREATE TABLE "voc"."chronology" (
    "id" smallint DEFAULT "nextval"('"voc"."seq___chronology__id"'::"regclass") NOT NULL,
    "code" character varying NOT NULL,
    "name" character varying NOT NULL,
    "date_low" integer,
    "date_high" integer,
    CONSTRAINT "ck___voc__chronology___date_low___lte___date_high" CHECK (("date_low" <= "date_high"))
);


ALTER TABLE "voc"."chronology" OWNER TO "archiraq_admin";


CREATE SEQUENCE "voc"."seq___survey__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "voc"."seq___survey__id" OWNER TO "archiraq_admin";


CREATE TABLE "voc"."survey" (
    "id" integer DEFAULT "nextval"('"voc"."seq___survey__id"'::"regclass") NOT NULL,
    "code" character varying NOT NULL,
    "name" character varying,
    "remarks" "text"
);


ALTER TABLE "voc"."survey" OWNER TO "archiraq_admin";


ALTER TABLE ONLY "admin"."group_members"
    ADD CONSTRAINT "group_members_pk" PRIMARY KEY ("groupname", "username");



ALTER TABLE ONLY "admin"."group_roles"
    ADD CONSTRAINT "group_roles_pk" PRIMARY KEY ("groupname", "rolename");



ALTER TABLE ONLY "admin"."groups"
    ADD CONSTRAINT "groups_pk" PRIMARY KEY ("name");



ALTER TABLE ONLY "admin"."role_props"
    ADD CONSTRAINT "role_props_pk" PRIMARY KEY ("rolename", "propname");



ALTER TABLE ONLY "admin"."roles"
    ADD CONSTRAINT "roles_pk" PRIMARY KEY ("name");



ALTER TABLE ONLY "admin"."user_props"
    ADD CONSTRAINT "user_props_pk" PRIMARY KEY ("username", "propname");



ALTER TABLE ONLY "admin"."user_roles"
    ADD CONSTRAINT "user_roles_pk" PRIMARY KEY ("username", "rolename");



ALTER TABLE ONLY "admin"."users"
    ADD CONSTRAINT "users_pk" PRIMARY KEY ("name");



ALTER TABLE ONLY "geom"."admbnd1"
    ADD CONSTRAINT "pk___geom__admbnd1" PRIMARY KEY ("id");



ALTER TABLE ONLY "geom"."admbnd2"
    ADD CONSTRAINT "pk___geom__admbnd2" PRIMARY KEY ("id");



ALTER TABLE ONLY "geom"."admbnd0"
    ADD CONSTRAINT "pk___geom__admbndo" PRIMARY KEY ("code");



ALTER TABLE ONLY "geom"."site"
    ADD CONSTRAINT "pk___geom__site" PRIMARY KEY ("id");



ALTER TABLE ONLY "geom"."admbnd1"
    ADD CONSTRAINT "uq___admbnd1__admbnd0_code__name" UNIQUE ("admbnd0_code", "name");



ALTER TABLE ONLY "geom"."admbnd2"
    ADD CONSTRAINT "uq___geom__admbnd2__admbnd1_id__name" UNIQUE ("admbnd1_id", "name");



ALTER TABLE ONLY "public"."contribute"
    ADD CONSTRAINT "pk___public__contribute" PRIMARY KEY ("id");



ALTER TABLE ONLY "public"."draft"
    ADD CONSTRAINT "pk___public__draft" PRIMARY KEY ("id");



ALTER TABLE ONLY "public"."site"
    ADD CONSTRAINT "pk___public__site" PRIMARY KEY ("id");



ALTER TABLE ONLY "public"."site_chronology"
    ADD CONSTRAINT "pk___site_chronology" PRIMARY KEY ("id");



ALTER TABLE ONLY "public"."site_survey"
    ADD CONSTRAINT "pk___site_survey" PRIMARY KEY ("id");



ALTER TABLE ONLY "public"."draft"
    ADD CONSTRAINT "uq___public__draft__contribute_id__entry_id" UNIQUE ("contribute_id", "entry_id");



COMMENT ON CONSTRAINT "uq___public__draft__contribute_id__entry_id" ON "public"."draft" IS 'entry_id MUST be unique for any contribute';



ALTER TABLE ONLY "public"."site"
    ADD CONSTRAINT "uq___public__site___contribute_id__entry_id" UNIQUE ("contribute_id", "entry_id");



ALTER TABLE ONLY "public"."site"
    ADD CONSTRAINT "uq___public__site___sbah_reg_no" UNIQUE ("sbah_no");



ALTER TABLE ONLY "public"."site_chronology"
    ADD CONSTRAINT "uq___site_chronology__site_id__chronology_id" UNIQUE ("site_id", "chronology_id");



ALTER TABLE ONLY "tmp"."draft"
    ADD CONSTRAINT "pk___tmp__draft" PRIMARY KEY ("id");



ALTER TABLE ONLY "tmp"."draft_error"
    ADD CONSTRAINT "pk___tmp__draft_error" PRIMARY KEY ("id");



ALTER TABLE ONLY "voc"."chronology"
    ADD CONSTRAINT "pk___voc__chronology" PRIMARY KEY ("id");



ALTER TABLE ONLY "voc"."survey"
    ADD CONSTRAINT "pk___voc__survey" PRIMARY KEY ("id");



ALTER TABLE ONLY "voc"."chronology"
    ADD CONSTRAINT "uq___voc__chronology___code" UNIQUE ("code");



ALTER TABLE ONLY "voc"."chronology"
    ADD CONSTRAINT "uq___voc__chronology___name" UNIQUE ("name");



ALTER TABLE ONLY "voc"."survey"
    ADD CONSTRAINT "uq___voc__survey__name" UNIQUE ("id");



ALTER TABLE ONLY "geom"."admbnd1"
    ADD CONSTRAINT "fk___admbnd1__admbnd0_code__admbnd0__code" FOREIGN KEY ("admbnd0_code") REFERENCES "geom"."admbnd0"("code") MATCH FULL;



ALTER TABLE ONLY "geom"."admbnd2"
    ADD CONSTRAINT "fk___geom__admbnd2___admbnd1_id__admbnd1_id" FOREIGN KEY ("admbnd1_id") REFERENCES "geom"."admbnd1"("id") MATCH FULL;



ALTER TABLE ONLY "geom"."site"
    ADD CONSTRAINT "fk___geom__site___public__site" FOREIGN KEY ("id") REFERENCES "public"."site"("id") MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;



ALTER TABLE ONLY "public"."draft"
    ADD CONSTRAINT "fk___public__draft___public__contribute" FOREIGN KEY ("contribute_id") REFERENCES "public"."contribute"("id") MATCH FULL ON UPDATE CASCADE;



ALTER TABLE ONLY "public"."site"
    ADD CONSTRAINT "fk___public__site___geom__admbnd2" FOREIGN KEY ("district_id") REFERENCES "geom"."admbnd2"("id") MATCH FULL ON UPDATE CASCADE;



ALTER TABLE ONLY "public"."site"
    ADD CONSTRAINT "fk___public__site___public__contribute" FOREIGN KEY ("contribute_id") REFERENCES "public"."contribute"("id") MATCH FULL ON UPDATE CASCADE;



ALTER TABLE ONLY "public"."site_chronology"
    ADD CONSTRAINT "fk___site_chronology___site" FOREIGN KEY ("site_id") REFERENCES "public"."site"("id") MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;



ALTER TABLE ONLY "public"."site_chronology"
    ADD CONSTRAINT "fk___site_chronology___voc__chronology" FOREIGN KEY ("chronology_id") REFERENCES "voc"."chronology"("id") MATCH FULL ON UPDATE CASCADE;



ALTER TABLE ONLY "public"."site_survey"
    ADD CONSTRAINT "fk___site_survey___voc__survey" FOREIGN KEY ("survey_id") REFERENCES "voc"."survey"("id") MATCH FULL ON UPDATE CASCADE;



ALTER TABLE ONLY "public"."site_survey"
    ADD CONSTRAINT "pk___site_survey___survey" FOREIGN KEY ("site_id") REFERENCES "public"."site"("id") MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;



ALTER TABLE ONLY "tmp"."draft"
    ADD CONSTRAINT "fk___tmp__draft___public__contribute" FOREIGN KEY ("contribute_id") REFERENCES "public"."contribute"("id") MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;



ALTER TABLE ONLY "tmp"."draft_error"
    ADD CONSTRAINT "fk___tmp__draft_error___tmp__draft" FOREIGN KEY ("draft_id") REFERENCES "tmp"."draft"("id") MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;



REVOKE ALL ON SCHEMA "public" FROM PUBLIC;
REVOKE ALL ON SCHEMA "public" FROM "postgres";
GRANT ALL ON SCHEMA "public" TO "postgres";
GRANT ALL ON SCHEMA "public" TO PUBLIC;



