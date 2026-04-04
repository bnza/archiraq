SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;

SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

INSERT INTO admin.users(
    name, password, enabled)
VALUES (
        'testUser',
        'digest1:20Dqw3d6cMPDz1b0VrZo+jxieH+Rt7HRCZ5Wk5AFpL0WhzCq1YxsTdUrzUmdqWU5', -- stands for 'testPassword'
        'Y')
ON CONFLICT (name) DO NOTHING;

INSERT INTO admin.users(
    name, password, enabled)
VALUES (
           'geoserverUser',
           'digest1:YgaweuS60t+mJNobGlf9hzUC6g7gGTtPEu0TlnUxFlv0fYtBuTsQDzZcBM4AfZHd', -- stands for 'geoserver'
           'Y')
ON CONFLICT (name) DO NOTHING;

INSERT INTO admin.roles(
    name, parent)
VALUES ('ROLE_USER', null)
ON CONFLICT (name) DO NOTHING;

INSERT INTO admin.user_roles(
    username, rolename)
VALUES ('testUser', 'ROLE_USER')
ON CONFLICT (username, rolename) DO NOTHING;
