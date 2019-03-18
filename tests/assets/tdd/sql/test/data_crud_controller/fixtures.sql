INSERT INTO public.contribute VALUES (104, 'mail1@example.com', 'J. White', 'Bannon 1966 surveys', 3, 'ae4f281df5a5d0ff3cad6371f76d5c29b6d953ec', 'University of Toronto');
INSERT INTO public.contribute VALUES (105, 'mail2@example.com', 'J. Smith', 'Adams 1952 surveys', 3, 'f71816d1474635145e488fd56f6f14d1d0bc6508', 'University of Bologna');

INSERT INTO voc.survey(
  id, code, name, remarks)
VALUES (1, 'SURVEY1988', 'The survey 1988', 'Some remarks on 1988');

INSERT INTO voc.survey(
  id, code, name, remarks)
VALUES (2, 'SURVEY1989', 'The survey 1989', 'Some remarks on 1989');

INSERT INTO public.site(
  id, contribute_id, entry_id, nearest_city, ancient_name, ancient_name_uncertain, modern_name, cadastre, compiler, compilation_date, remarks, credits, sbah_no, features_epigraphic, features_ancient_structures, features_paleochannels, features_remarks, threats_natural_dunes, threats_looting, threats_cultivation_trenches, threats_modern_structures, threats_modern_canals, district_id)
VALUES (1, 104, null, 'Hilla', 'Ancient Name', true, 'Tell Ishnayt', 'Cadastre', 'T. Compiler', '2019-03-18', 'Some remarks', 'Some credits', 'IQ234', true, true, false, 'Some remarks', true, false, true, null, null, 88);

INSERT INTO public.site_chronology(
  id, site_id, chronology_id)
VALUES (1, 1, 4);

INSERT INTO public.site_chronology(
  id, site_id, chronology_id)
VALUES (2, 1, 24);

INSERT INTO public.site_survey(
  id, survey_id, site_id, ref, year_low, year_high, remarks)
VALUES (1, 1, 1, 'a', null, null, 'Some remarks on survey');

INSERT INTO public.site_survey(
  id, survey_id, site_id, ref, year_low, year_high, remarks)
VALUES (2, 2, 1, 5, 1989, null, 'Some remarks on survey');
