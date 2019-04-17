--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.15
-- Dumped by pg_dump version 11.1 (Ubuntu 11.1-3.pgdg18.04+1)

-- Started on 2019-02-05 16:55:09 CET

SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

ALTER SEQUENCE public.seq___contribute__id RESTART WITH 1;

--
-- TOC entry 3616 (class 0 OID 37988)
-- Dependencies: 235
-- Data for Name: contribute; Type: TABLE DATA; Schema: public; Owner: archiraq_admin
--

INSERT INTO public.contribute VALUES (default, 'mail@example.com', 'J. Smith', 'Adams 1952 surveys', 0, 'f71816d1474635145e488fd56f6f14d1d0bc6508', 'University of Bologna');

--
-- TOC entry 3616 (class 0 OID 66750)
-- Dependencies: 238
-- Data for Name: draft; Type: TABLE DATA; Schema: tmp; Owner: archiraq_admin
--

INSERT INTO tmp.draft
VALUES (
        default,
        1,
        'AKK.001',
        'Tell Harba',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        '1956-1957',
        'y',
        NULL,
        'ADAMS1972.001',
        'n',
        'y',
        'n',
        NULL,
        NULL,
        NULL,
        NULL,
        1,
        'true',
        NULL,
        'n',
        'y',
        NULL,
        'John Smith',
        '2018-11-29',
        NULL,
        '0106000020E41000000200000001030000000100000005000000000000000080594000000000000000400000000000C0594000000000000000400000000000C05940000000000000084000000000008059400000000000000840000000000080594000000000000000400103000000020000000500000000000000000059400000000000000000000000000040594000000000000000000000000000405940000000000000F03F0000000000005940000000000000F03F0000000000005940000000000000000005000000CDCCCCCCCC0C59409A9999999999C93F33333333333359409A9999999999C93F33333333333359409A9999999999E93FCDCCCCCCCC0C59409A9999999999E93FCDCCCCCCCC0C59409A9999999999C93F',
        'n'
        );


-- Completed on 2019-02-05 16:55:09 CET

--
-- PostgreSQL database dump complete
--

