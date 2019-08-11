

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET xmloption = content;
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
CREATE OR REPLACE VIEW "public"."vw_site" AS
SELECT
    NULL::integer AS "id",
    NULL::integer AS "contribute_id",
    NULL::character varying AS "sbah_no",
    NULL::character varying AS "cadastre",
    NULL::character varying AS "modern_name",
    NULL::character varying AS "nearest_city",
    NULL::"text" AS "ancient_name",
    NULL::integer AS "district_id",
    NULL::character varying AS "district",
    NULL::character varying AS "governorate",
    NULL::character varying AS "nation",
    NULL::"text" AS "chronology",
    NULL::"text" AS "surveys",
    NULL::"text" AS "survey_refs",
    NULL::character varying AS "features",
    NULL::character varying AS "threats",
    NULL::boolean AS "remote_sensing",
    NULL::boolean AS "survey_verified_on_field",
    NULL::"text" AS "remarks",
    NULL::numeric AS "e",
    NULL::numeric AS "n",
    NULL::numeric AS "area",
    NULL::numeric AS "length",
    NULL::numeric AS "width";
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
ALTER TABLE IF EXISTS ONLY "geom"."mat_site" DROP CONSTRAINT IF EXISTS "pk___geom__mat_site";
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


ALTER SCHEMA "admin" OWNER TO "test_archiraq_admin";





CREATE SCHEMA "geom";


ALTER SCHEMA "geom" OWNER TO "test_archiraq_admin";












CREATE SCHEMA "tmp";


ALTER SCHEMA "tmp" OWNER TO "test_archiraq_admin";


CREATE SCHEMA "voc";


ALTER SCHEMA "voc" OWNER TO "test_archiraq_admin";

















CREATE FUNCTION "geom"."refresh_mat_site"() RETURNS "void"
    LANGUAGE "plpgsql"
    AS $$DECLARE
    id integer;
BEGIN
	TRUNCATE geom.mat_site;
	FOR id IN SELECT * FROM public.vw_site ORDER BY id LOOP
		INSERT INTO geom.mat_site SELECT * FROM geom.select_vw_site_by_index(id);
	END LOOP;
END;$$;


ALTER FUNCTION "geom"."refresh_mat_site"() OWNER TO "test_archiraq_admin";

SET default_tablespace = '';

SET default_with_oids = false;


CREATE TABLE "geom"."mat_site" (
    "id" integer NOT NULL,
    "contribute_id" integer,
    "sbah_no" character varying,
    "cadastre" character varying,
    "modern_name" character varying,
    "nearest_city" character varying,
    "ancient_name" "text",
    "district_id" integer,
    "district" character varying,
    "governorate" character varying,
    "nation" character varying,
    "chronology" "text",
    "surveys" "text",
    "survey_refs" "text",
    "features" character varying,
    "threats" character varying,
    "remote_sensing" boolean,
    "survey_verified_on_field" boolean,
    "remarks" "text",
    "e" numeric,
    "n" numeric,
    "area" numeric,
    "length" numeric,
    "width" numeric,
    "centroid" "public"."geometry"(Point,4326),
    "geom" "public"."geometry"(MultiPolygon,4326)
);


ALTER TABLE "geom"."mat_site" OWNER TO "test_archiraq_admin";


CREATE FUNCTION "geom"."select_vw_site_by_index"("site_id" integer) RETURNS "geom"."mat_site"
    LANGUAGE "sql"
    AS $$SELECT ws.*, st_centroid(gs.geom) AS centroid, gs.geom FROM public.vw_site ws
     LEFT JOIN geom.site gs ON ws.id = gs.id WHERE ws.id=site_id;$$;


ALTER FUNCTION "geom"."select_vw_site_by_index"("site_id" integer) OWNER TO "test_archiraq_admin";


CREATE FUNCTION "geom"."tf___delete_geom_mat_site"() RETURNS "trigger"
    LANGUAGE "plpgsql"
    AS $$BEGIN
	DELETE FROM geom.mat_site WHERE id = OLD.id;
	RETURN OLD;
END$$;


ALTER FUNCTION "geom"."tf___delete_geom_mat_site"() OWNER TO "test_archiraq_admin";


CREATE FUNCTION "geom"."tf___insert_into_geom_mat_site"() RETURNS "trigger"
    LANGUAGE "plpgsql"
    AS $$BEGIN
	INSERT INTO geom.mat_site SELECT * FROM geom.select_vw_site_by_index(NEW.id);
	RETURN NEW;
END;$$;


ALTER FUNCTION "geom"."tf___insert_into_geom_mat_site"() OWNER TO "test_archiraq_admin";


CREATE FUNCTION "geom"."tf___update_geom_mat_site"() RETURNS "trigger"
    LANGUAGE "plpgsql"
    AS $$BEGIN
	DELETE FROM geom.mat_site WHERE id = OLD.id;
	DELETE FROM geom.mat_site WHERE id = NEW.id;
	INSERT INTO geom.mat_site SELECT * FROM geom.select_vw_site_by_index(NEW.id);
	RETURN NEW;
END$$;


ALTER FUNCTION "geom"."tf___update_geom_mat_site"() OWNER TO "test_archiraq_admin";


CREATE FUNCTION "geom"."tf___update_geom_mat_site___geom"() RETURNS "trigger"
    LANGUAGE "plpgsql"
    AS $$BEGIN
	IF TG_OP <> 'INSERT' THEN
		DELETE FROM geom.mat_site WHERE id = OLD.id;
	END IF;
	IF TG_OP <> 'DELETE' THEN
		DELETE FROM geom.mat_site WHERE id = NEW.id;
		INSERT INTO geom.mat_site SELECT * FROM geom.select_vw_site_by_index(NEW.id);
	END IF;
	RETURN NEW;
END$$;


ALTER FUNCTION "geom"."tf___update_geom_mat_site___geom"() OWNER TO "test_archiraq_admin";


CREATE FUNCTION "geom"."tf___update_geom_mat_site_child"() RETURNS "trigger"
    LANGUAGE "plpgsql"
    AS $$BEGIN
	IF TG_OP <> 'INSERT' THEN
		DELETE FROM geom.mat_site WHERE id = OLD.site_id;
	END IF;
	IF TG_OP <> 'DELETE' THEN
		DELETE FROM geom.mat_site WHERE id = NEW.site_id;
		INSERT INTO geom.mat_site SELECT * FROM geom.select_vw_site_by_index(NEW.site_id);
	END IF;
	RETURN NEW;
END$$;


ALTER FUNCTION "geom"."tf___update_geom_mat_site_child"() OWNER TO "test_archiraq_admin";


CREATE FUNCTION "geom"."update_mat_site_by_index"("new_site_id" integer, "old_site_id" integer) RETURNS "void"
    LANGUAGE "plpgsql"
    AS $$BEGIN
	DELETE FROM geom.mat_site WHERE id = old_site_id;
	IF EXISTS (SELECT FROM public.vw_site WHERE id = new_site_id) THEN
		DELETE FROM geom.mat_site WHERE id = new_site_id;
		INSERT INTO geom.mat_site SELECT * FROM geom.select_vw_site_by_index(new_site_id);
	END IF;
END;$$;


ALTER FUNCTION "geom"."update_mat_site_by_index"("new_site_id" integer, "old_site_id" integer) OWNER TO "test_archiraq_admin";


CREATE FUNCTION "public"."orientedenvelope"("g" "public"."geometry") RETURNS "public"."geometry"
    LANGUAGE "plpgsql" IMMUTABLE
    AS $$
declare
    p record;
    p0 geometry(point);
    p1 geometry(point);
    ctr geometry(point);
    angle_min float;
    angle_cur float;
    area_min float;
    area_cur float;
begin
    -- Approach is based on the rotating calipers method:
    -- <https://en.wikipedia.org/wiki/Rotating_calipers>
    g := ST_ConvexHull(g);
    ctr := ST_Centroid(g);
    for p in (select (ST_DumpPoints(g)).geom) loop
        p0 := p1;
        p1 := p.geom;
        if p0 is null then
            continue;
        end if;
        angle_cur := ST_Azimuth(p0, p1) - pi()/2;
        area_cur := ST_Area(ST_Envelope(ST_Rotate(g, angle_cur, ctr)));
        if area_cur < area_min or area_min is null then
            area_min := area_cur;
            angle_min := angle_cur;
        end if;
    end loop;
    return ST_Rotate(ST_Envelope(ST_Rotate(g, angle_min, ctr)), -angle_min, ctr);
end;
$$;


ALTER FUNCTION "public"."orientedenvelope"("g" "public"."geometry") OWNER TO "test_archiraq_admin";


CREATE FUNCTION "public"."orientedenvelopesides"("g" "public"."geometry") RETURNS double precision[]
    LANGUAGE "plpgsql" IMMUTABLE
    AS $$
declare
	l geometry(linestring);
    p1 geometry(point);
    p2 geometry(point);
    p3 geometry(point);
    length1 float;
    length2 float;
begin
	l := ST_ExteriorRing(OrientedEnvelope(g));
	p1 = ST_PointN(l, 1)::geography;
	p2 = ST_PointN(l, 2)::geography;
	p3 = ST_PointN(l, 3)::geography;
	length1 := ST_Distance(p1,p2,true);
	length2 := ST_Distance(p2,p3,true);
	return ARRAY[GREATEST(length1,length2), LEAST(length1,length2)];
end;
$$;


ALTER FUNCTION "public"."orientedenvelopesides"("g" "public"."geometry") OWNER TO "test_archiraq_admin";


CREATE FUNCTION "public"."site_features_to_string"("features_epigraphic" boolean, "features_ancient_structures" boolean, "features_paleochannels" boolean) RETURNS character varying
    LANGUAGE "plpgsql"
    AS $$DECLARE
	features varchar[];
	results varchar;
BEGIN
	IF features_epigraphic THEN
		features := array_append(features, 'epigraphic');
	END IF;
	IF features_ancient_structures THEN
		features := array_append(features, 'structures');
	END IF;
	IF features_paleochannels THEN
		features := array_append(features, 'paleochannels');
	END IF;
	RETURN array_to_string(features, ';');
END;$$;


ALTER FUNCTION "public"."site_features_to_string"("features_epigraphic" boolean, "features_ancient_structures" boolean, "features_paleochannels" boolean) OWNER TO "test_archiraq_admin";





CREATE FUNCTION "public"."site_threats_to_string"("threats_natural_dunes" boolean, "threats_looting" boolean, "threats_cultivation_trenches" boolean, "threats_modern_structures" boolean, "threats_modern_canals" boolean) RETURNS character varying
    LANGUAGE "plpgsql"
    AS $$
DECLARE
	threats varchar[];
BEGIN
	IF threats_natural_dunes THEN
		threats := array_append(threats, 'dunes');
	END IF;
	IF threats_looting THEN
		threats := array_append(threats, 'looting');
	END IF;
	IF threats_cultivation_trenches THEN
		threats := array_append(threats, 'cultivation');
	END IF;
	IF threats_modern_structures THEN
		threats := array_append(threats, 'structures');
	END IF;
		IF threats_modern_canals THEN
		threats := array_append(threats, 'canals');
	END IF;
	RETURN array_to_string(threats, ';');
END;$$;


ALTER FUNCTION "public"."site_threats_to_string"("threats_natural_dunes" boolean, "threats_looting" boolean, "threats_cultivation_trenches" boolean, "threats_modern_structures" boolean, "threats_modern_canals" boolean) OWNER TO "test_archiraq_admin";





CREATE TABLE "admin"."group_members" (
    "groupname" character varying(128) NOT NULL,
    "username" character varying(128) NOT NULL
);


ALTER TABLE "admin"."group_members" OWNER TO "test_archiraq_admin";


CREATE TABLE "admin"."group_roles" (
    "groupname" character varying(64) NOT NULL,
    "rolename" character varying(64) NOT NULL
);


ALTER TABLE "admin"."group_roles" OWNER TO "test_archiraq_admin";


CREATE TABLE "admin"."groups" (
    "name" character varying(128) NOT NULL,
    "enabled" character(1) NOT NULL
);


ALTER TABLE "admin"."groups" OWNER TO "test_archiraq_admin";


CREATE TABLE "admin"."role_props" (
    "rolename" character varying(128) NOT NULL,
    "propname" character varying(64) NOT NULL,
    "propvalue" character varying(2048)
);


ALTER TABLE "admin"."role_props" OWNER TO "test_archiraq_admin";


CREATE TABLE "admin"."roles" (
    "name" character varying(64) NOT NULL,
    "parent" character varying(64)
);


ALTER TABLE "admin"."roles" OWNER TO "test_archiraq_admin";


CREATE TABLE "admin"."user_props" (
    "username" character varying(128) NOT NULL,
    "propname" character varying(64) NOT NULL,
    "propvalue" character varying(2048)
);


ALTER TABLE "admin"."user_props" OWNER TO "test_archiraq_admin";


CREATE TABLE "admin"."user_roles" (
    "username" character varying(64) NOT NULL,
    "rolename" character varying(64) NOT NULL
);


ALTER TABLE "admin"."user_roles" OWNER TO "test_archiraq_admin";


CREATE TABLE "admin"."users" (
    "name" character varying(128) NOT NULL,
    "password" character varying(254),
    "enabled" character(1) NOT NULL
);


ALTER TABLE "admin"."users" OWNER TO "test_archiraq_admin";


COMMENT ON TABLE "admin"."users" IS 'Geoserver JDBC user/group service compliant table
@see https://docs.geoserver.org/stable/en/user/security/usergrouprole/usergroupservices.html';



CREATE TABLE "geom"."admbnd0" (
    "code" character(2) NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry" NOT NULL
);


ALTER TABLE "geom"."admbnd0" OWNER TO "test_archiraq_admin";





CREATE SEQUENCE "geom"."seq__admbnd1__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 32767
    CACHE 1;


ALTER TABLE "geom"."seq__admbnd1__id" OWNER TO "test_archiraq_admin";


CREATE TABLE "geom"."admbnd1" (
    "id" smallint DEFAULT "nextval"('"geom"."seq__admbnd1__id"'::"regclass") NOT NULL,
    "admbnd0_code" character(2) NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry" NOT NULL
);


ALTER TABLE "geom"."admbnd1" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "geom"."seq__admbnd2__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "geom"."seq__admbnd2__id" OWNER TO "test_archiraq_admin";


CREATE TABLE "geom"."admbnd2" (
    "id" integer DEFAULT "nextval"('"geom"."seq__admbnd2__id"'::"regclass") NOT NULL,
    "admbnd1_id" smallint NOT NULL,
    "name" character varying NOT NULL,
    "altname" character varying,
    "geom" "public"."geometry" NOT NULL
);


ALTER TABLE "geom"."admbnd2" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "geom"."seq___geom__site"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "geom"."seq___geom__site" OWNER TO "test_archiraq_admin";


CREATE TABLE "geom"."site" (
    "id" integer NOT NULL,
    "geom" "public"."geometry"(MultiPolygon,4326) NOT NULL
);


ALTER TABLE "geom"."site" OWNER TO "test_archiraq_admin";

CREATE VIEW "geom"."vw_site_point" AS
 SELECT "ws"."id",
    "ws"."contribute_id",
    "ws"."sbah_no",
    "ws"."cadastre",
    "ws"."modern_name",
    "ws"."nearest_city",
    "ws"."ancient_name",
    "ws"."district_id",
    "ws"."district",
    "ws"."governorate",
    "ws"."nation",
    "ws"."chronology",
    "ws"."surveys",
    "ws"."survey_refs",
    "ws"."features",
    "ws"."threats",
    "ws"."remote_sensing",
    "ws"."survey_verified_on_field",
    "ws"."remarks",
    "ws"."e",
    "ws"."n",
    "ws"."area",
    "ws"."length",
    "ws"."width",
    "public"."st_centroid"("gs"."geom") AS "geom"
   FROM ("public"."vw_site" "ws"
     LEFT JOIN "geom"."site" "gs" ON (("ws"."id" = "gs"."id")));


ALTER TABLE "geom"."vw_site_point" OWNER TO "test_archiraq_admin";


CREATE VIEW "geom"."vw_site_poly" AS
 SELECT "ws"."id",
    "ws"."contribute_id",
    "ws"."sbah_no",
    "ws"."cadastre",
    "ws"."modern_name",
    "ws"."nearest_city",
    "ws"."ancient_name",
    "ws"."district_id",
    "ws"."district",
    "ws"."governorate",
    "ws"."nation",
    "ws"."chronology",
    "ws"."surveys",
    "ws"."survey_refs",
    "ws"."features",
    "ws"."threats",
    "ws"."remote_sensing",
    "ws"."survey_verified_on_field",
    "ws"."remarks",
    "ws"."e",
    "ws"."n",
    "ws"."area",
    "ws"."length",
    "ws"."width",
    "gs"."geom"
   FROM ("public"."vw_site" "ws"
     LEFT JOIN "geom"."site" "gs" ON (("ws"."id" = "gs"."id")));


ALTER TABLE "geom"."vw_site_poly" OWNER TO "test_archiraq_admin";


CREATE VIEW "geom"."vw_site_rs_point" AS
 SELECT "ms"."id",
    "ms"."contribute_id",
    "ms"."sbah_no",
    "ms"."cadastre",
    "ms"."modern_name",
    "ms"."nearest_city",
    "ms"."ancient_name",
    "ms"."district_id",
    "ms"."district",
    "ms"."governorate",
    "ms"."nation",
    "ms"."chronology",
    "ms"."surveys",
    "ms"."survey_refs",
    "ms"."features",
    "ms"."threats",
    "ms"."remote_sensing",
    "ms"."survey_verified_on_field",
    "ms"."remarks",
    "ms"."e",
    "ms"."n",
    "ms"."area",
    "ms"."length",
    "ms"."width",
    "ms"."centroid" AS "geom"
   FROM "geom"."mat_site" "ms"
  WHERE ("ms"."remote_sensing" = true);


ALTER TABLE "geom"."vw_site_rs_point" OWNER TO "test_archiraq_admin";


CREATE VIEW "geom"."vw_site_rs_poly" AS
 SELECT "ms"."id",
    "ms"."contribute_id",
    "ms"."sbah_no",
    "ms"."cadastre",
    "ms"."modern_name",
    "ms"."nearest_city",
    "ms"."ancient_name",
    "ms"."district_id",
    "ms"."district",
    "ms"."governorate",
    "ms"."nation",
    "ms"."chronology",
    "ms"."surveys",
    "ms"."survey_refs",
    "ms"."features",
    "ms"."threats",
    "ms"."remote_sensing",
    "ms"."survey_verified_on_field",
    "ms"."remarks",
    "ms"."e",
    "ms"."n",
    "ms"."area",
    "ms"."length",
    "ms"."width",
    "ms"."geom"
   FROM "geom"."mat_site" "ms"
  WHERE ("ms"."remote_sensing" = true);


ALTER TABLE "geom"."vw_site_rs_poly" OWNER TO "test_archiraq_admin";


CREATE VIEW "geom"."vw_site_survey_point" WITH ("security_barrier"='false') AS
 SELECT "ms"."id",
    "ms"."contribute_id",
    "ms"."sbah_no",
    "ms"."cadastre",
    "ms"."modern_name",
    "ms"."nearest_city",
    "ms"."ancient_name",
    "ms"."district_id",
    "ms"."district",
    "ms"."governorate",
    "ms"."nation",
    "ms"."chronology",
    "ms"."surveys",
    "ms"."survey_refs",
    "ms"."features",
    "ms"."threats",
    "ms"."remote_sensing",
    "ms"."survey_verified_on_field",
    "ms"."remarks",
    "ms"."e",
    "ms"."n",
    "ms"."area",
    "ms"."length",
    "ms"."width",
    "ms"."centroid" AS "geom"
   FROM "geom"."mat_site" "ms"
  WHERE ("ms"."remote_sensing" = false);


ALTER TABLE "geom"."vw_site_survey_point" OWNER TO "test_archiraq_admin";


CREATE VIEW "geom"."vw_site_survey_poly" AS
 SELECT "ms"."id",
    "ms"."contribute_id",
    "ms"."sbah_no",
    "ms"."cadastre",
    "ms"."modern_name",
    "ms"."nearest_city",
    "ms"."ancient_name",
    "ms"."district_id",
    "ms"."district",
    "ms"."governorate",
    "ms"."nation",
    "ms"."chronology",
    "ms"."surveys",
    "ms"."survey_refs",
    "ms"."features",
    "ms"."threats",
    "ms"."remote_sensing",
    "ms"."survey_verified_on_field",
    "ms"."remarks",
    "ms"."e",
    "ms"."n",
    "ms"."area",
    "ms"."length",
    "ms"."width",
    "ms"."geom"
   FROM "geom"."mat_site" "ms"
  WHERE ("ms"."remote_sensing" = false);


ALTER TABLE "geom"."vw_site_survey_poly" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "public"."seq___contribute__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___contribute__id" OWNER TO "test_archiraq_admin";


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





CREATE SEQUENCE "public"."seq___public__draft"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___public__draft" OWNER TO "test_archiraq_admin";


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
    "geom" "public"."geometry" NOT NULL
);


ALTER TABLE "public"."draft" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "public"."seq___site__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___site__id" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "public"."seq___site_chronology__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___site_chronology__id" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "public"."seq___site_survey__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "public"."seq___site_survey__id" OWNER TO "test_archiraq_admin";


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
    "district_id" smallint NOT NULL,
    "threats_bulldozer" boolean,
    "remote_sensing" boolean NOT NULL,
    "survey_verified_on_field" boolean
);


ALTER TABLE "public"."site" OWNER TO "test_archiraq_admin";


CREATE TABLE "public"."site_chronology" (
    "id" integer DEFAULT "nextval"('"public"."seq___site_chronology__id"'::"regclass") NOT NULL,
    "site_id" integer NOT NULL,
    "chronology_id" integer NOT NULL
);


ALTER TABLE "public"."site_chronology" OWNER TO "test_archiraq_admin";


CREATE TABLE "public"."site_survey" (
    "id" integer DEFAULT "nextval"('"public"."seq___site_survey__id"'::"regclass") NOT NULL,
    "survey_id" integer NOT NULL,
    "site_id" integer NOT NULL,
    "ref" character varying,
    "year_low" smallint,
    "year_high" smallint,
    "remarks" "text"
);


ALTER TABLE "public"."site_survey" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "tmp"."seq___draft__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "tmp"."seq___draft__id" OWNER TO "test_archiraq_admin";


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
    "geom" "public"."geometry",
    "remote_sensing" character varying,
    "threats_bulldozer" character varying
);


ALTER TABLE "tmp"."draft" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "tmp"."seq___draft_error__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "tmp"."seq___draft_error__id" OWNER TO "test_archiraq_admin";


CREATE TABLE "tmp"."draft_error" (
    "id" integer DEFAULT "nextval"('"tmp"."seq___draft_error__id"'::"regclass") NOT NULL,
    "draft_id" integer NOT NULL,
    "path" character varying,
    "message" "text" NOT NULL
);


ALTER TABLE "tmp"."draft_error" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "voc"."seq___chronology__id"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "voc"."seq___chronology__id" OWNER TO "test_archiraq_admin";


CREATE TABLE "voc"."chronology" (
    "id" smallint DEFAULT "nextval"('"voc"."seq___chronology__id"'::"regclass") NOT NULL,
    "code" character varying NOT NULL,
    "name" character varying NOT NULL,
    "date_low" integer,
    "date_high" integer,
    CONSTRAINT "ck___voc__chronology___date_low___lte___date_high" CHECK (("date_low" <= "date_high"))
);


ALTER TABLE "voc"."chronology" OWNER TO "test_archiraq_admin";


CREATE SEQUENCE "voc"."seq___survey__id"
    START WITH 1
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE "voc"."seq___survey__id" OWNER TO "test_archiraq_admin";


CREATE TABLE "voc"."survey" (
    "id" integer DEFAULT "nextval"('"voc"."seq___survey__id"'::"regclass") NOT NULL,
    "code" character varying NOT NULL,
    "name" character varying,
    "remarks" "text"
);


ALTER TABLE "voc"."survey" OWNER TO "test_archiraq_admin";


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



ALTER TABLE ONLY "geom"."mat_site"
    ADD CONSTRAINT "pk___geom__mat_site" PRIMARY KEY ("id");



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



CREATE INDEX "idx___geom__mat_site___geom" ON "geom"."mat_site" USING "gist" ("geom");



CREATE INDEX "idx___geom__mat_site___remote_sensing" ON "geom"."mat_site" USING "btree" ("remote_sensing");



CREATE OR REPLACE VIEW "public"."vw_site" WITH ("security_barrier"='false') AS
 WITH "oriented_envelop_sides" AS (
         SELECT "site"."id",
            "public"."orientedenvelopesides"("site"."geom") AS "sides"
           FROM "geom"."site"
        )
 SELECT "s"."id",
    "s"."contribute_id",
    "s"."sbah_no",
    "s"."cadastre",
    "s"."modern_name",
    "s"."nearest_city",
    (("s"."ancient_name")::"text" ||
        CASE
            WHEN "s"."ancient_name_uncertain" THEN '?'::"text"
            ELSE ''::"text"
        END) AS "ancient_name",
    "ab2"."id" AS "district_id",
    "ab2"."name" AS "district",
    "ab1"."name" AS "governorate",
    "ab0"."name" AS "nation",
    "string_agg"(DISTINCT ("vc"."code")::"text", ';'::"text") AS "chronology",
    "string_agg"(DISTINCT ("vs"."code")::"text", ';'::"text") AS "surveys",
    "array_to_string"("array_agg"(DISTINCT "concat_ws"('.'::"text", "vs"."code", "ss"."ref")), ';'::"text") AS "survey_refs",
    "public"."site_features_to_string"("s"."features_epigraphic", "s"."features_ancient_structures", "s"."features_paleochannels") AS "features",
    "public"."site_threats_to_string"("s"."threats_natural_dunes", "s"."threats_looting", "s"."threats_cultivation_trenches", "s"."threats_modern_structures", "s"."threats_modern_canals") AS "threats",
    "s"."remote_sensing",
    "s"."survey_verified_on_field",
    "s"."remarks",
    "round"(("public"."st_x"("public"."st_centroid"("gs"."geom")))::numeric, 7) AS "e",
    "round"(("public"."st_y"("public"."st_centroid"("gs"."geom")))::numeric, 7) AS "n",
    "round"((("public"."st_area"(("gs"."geom")::"public"."geography") / (10000)::double precision))::numeric, 3) AS "area",
    "round"(("oes"."sides"[1])::numeric, 2) AS "length",
    "round"(("oes"."sides"[2])::numeric, 2) AS "width"
   FROM ((((((((("public"."site" "s"
     LEFT JOIN "geom"."admbnd2" "ab2" ON (("s"."district_id" = "ab2"."id")))
     LEFT JOIN "geom"."admbnd1" "ab1" ON (("ab2"."admbnd1_id" = "ab1"."id")))
     LEFT JOIN "geom"."admbnd0" "ab0" ON (("ab1"."admbnd0_code" = "ab0"."code")))
     LEFT JOIN "public"."site_chronology" "sc" ON (("s"."id" = "sc"."site_id")))
     LEFT JOIN "voc"."chronology" "vc" ON (("sc"."chronology_id" = "vc"."id")))
     LEFT JOIN "public"."site_survey" "ss" ON (("s"."id" = "ss"."site_id")))
     LEFT JOIN "voc"."survey" "vs" ON (("ss"."survey_id" = "vs"."id")))
     LEFT JOIN "geom"."site" "gs" ON (("s"."id" = "gs"."id")))
     LEFT JOIN "oriented_envelop_sides" "oes" ON (("s"."id" = "oes"."id")))
  GROUP BY "s"."id", "ab2"."id", "ab2"."name", "ab1"."name", "ab0"."name", "gs"."geom", "oes"."sides";



CREATE TRIGGER "tr_aud___update_geom_mat_site___geom" AFTER INSERT OR DELETE OR UPDATE ON "geom"."site" FOR EACH ROW EXECUTE PROCEDURE "geom"."tf___update_geom_mat_site___geom"();



CREATE TRIGGER "tr_ad___delete_geom_mat_site" AFTER DELETE ON "public"."site" FOR EACH ROW EXECUTE PROCEDURE "geom"."tf___delete_geom_mat_site"();



CREATE TRIGGER "tr_ai___insert_into_geom_mat_site" AFTER INSERT ON "public"."site" FOR EACH ROW EXECUTE PROCEDURE "geom"."tf___insert_into_geom_mat_site"();



CREATE TRIGGER "tr_au___update_geom_mat_site" AFTER UPDATE ON "public"."site" FOR EACH ROW EXECUTE PROCEDURE "geom"."tf___update_geom_mat_site"();



CREATE TRIGGER "tr_aud___update_geom_mat_site___chronology" AFTER INSERT OR DELETE OR UPDATE ON "public"."site_chronology" FOR EACH ROW EXECUTE PROCEDURE "geom"."tf___update_geom_mat_site_child"();



CREATE TRIGGER "tr_aud___update_geom_mat_site___survey" AFTER INSERT OR DELETE OR UPDATE ON "public"."site_survey" FOR EACH ROW EXECUTE PROCEDURE "geom"."tf___update_geom_mat_site_child"();



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



GRANT ALL ON SCHEMA "public" TO PUBLIC;



