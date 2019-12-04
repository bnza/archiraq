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

--
-- TOC entry 3616 (class 0 OID 37988)
-- Dependencies: 235
-- Data for Name: contribute; Type: TABLE DATA; Schema: public; Owner: archiraq_admin
--

INSERT INTO public.contribute
VALUES (default, 'mail@example.com', 'J. Smith', 'Adams 1952 surveys', 0, 'f71816d1474635145e488fd56f6f14d1d0bc6508',
        'University of Bologna');

--
-- TOC entry 3616 (class 0 OID 66750)
-- Dependencies: 238
-- Data for Name: draft; Type: TABLE DATA; Schema: tmp; Owner: archiraq_admin
--

INSERT INTO tmp.draft(id,
                      contribute_id,
                      entry_id,
                      modern_name,
                      ancient_name,
                      district,
                      nearest_city,
                      cadastre,
                      sbah_no,
                      survey_visit_date,
                      survey_verified_on_field,
                      survey_type, survey_prev_refs,
                      features_epigraphic,
                      features_ancient_structures,
                      features_paleochannels,
                      features_remarks,
                      site_chronology,
                      excavations_whom_when,
                      excavations_bibliography,
                      threats_natural_dunes,
                      threats_looting,
                      threats_cultivation_trenches,
                      threats_modern_structures,
                      threats_modern_canals,
                      remarks, compiler,
                      compilation_date,
                      credits,
                      geom,
                      remote_sensing,
                      threats_bulldozer
                      )
VALUES (
        default,
        1,
        'AKK.001',
        'Tell Harba',
        NULL,
        'Mahawil',
        NULL,
        NULL,
        NULL,
        '1956-1957',
        'y',
        NULL,
        'ADAMS1972.001;ADAMS1972.d;SOMEONE1988.h',
        'n',
        'y',
        'n',
        NULL,
        'EDA;AKK;SAS;ISL1',
        'Some excavations',
        'SOMEONE1987',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'Eleonora Quirico',
        '2018-11-29',
        NULL,
        '0106000020E6100000010000000103000000010000000600000048E17A14AE074640EC51B81E850B4140295C8FC2F5E84640EC51B81E850B41400AD7A3703DEA46405C8FC2F5285C404048E17A14AE0746401F85EB51B85E404048E17A14AE0746401F85EB51B85E404048E17A14AE074640EC51B81E850B4140',
        'n',
        'y');


-- Completed on 2019-02-05 16:55:09 CET

--
-- PostgreSQL database dump complete
--

