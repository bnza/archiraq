DO $$
  BEGIN
    CREATE ROLE "archiraq_admin";
    ALTER ROLE "archiraq_admin" WITH NOSUPERUSER NOINHERIT CREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS;
    EXCEPTION WHEN OTHERS THEN
      RAISE NOTICE 'not creating role archiraq_admin -- it already exists';
  END
$$;
DO $$
  BEGIN
    CREATE ROLE "archiraq_member";
    ALTER ROLE archiraq_member WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB NOLOGIN NOREPLICATION NOBYPASSRLS;
    EXCEPTION WHEN OTHERS THEN
      RAISE NOTICE 'not creating role archiraq_member -- it already exists';
  END
$$;
