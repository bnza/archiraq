--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.15
-- Dumped by pg_dump version 11.1 (Ubuntu 11.1-3.pgdg18.04+1)

-- Started on 2019-02-05 16:55:09 CET

SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
-- SELECT pg_catalog.set_config('search_path', '', false);
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
        'Nowhere',
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
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'John Smith',
        '2018-11-29',
        NULL,
        '0106000020E6100000010000000103000000010000000600000048E17A14AE074640EC51B81E850B4140295C8FC2F5E84640EC51B81E850B41400AD7A3703DEA46405C8FC2F5285C404048E17A14AE0746401F85EB51B85E404048E17A14AE0746401F85EB51B85E404048E17A14AE074640EC51B81E850B4140'
        );


-- Completed on 2019-02-05 16:55:09 CET

--
-- PostgreSQL database dump complete
--

