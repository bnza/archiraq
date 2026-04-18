<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to create geom.vw_site_survey_not_sampled_poly and geom.vw_site_survey_not_sampled_point views
 * with WHERE ms.survey_type = 'not_sampled'
 */
final class Version20260418094614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create new views for not sampled site surveys';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("CREATE OR REPLACE VIEW geom.vw_site_survey_not_sampled_poly
            (id, contribute_id, entry_id, sbah_no, cadastre, modern_name, nearest_city, ancient_name, district_id,
             district, governorate, nation, chronology, survey_type, surveys, survey_refs, features, features_remarks,
             threats, remote_sensing, survey_verified_on_field, excavations_whom_when, excavations_bibliography,
             remarks, e, n, area, length, width, geom)
        as
        SELECT ms.id,
               ms.contribute_id,
               ms.entry_id,
               ms.sbah_no,
               ms.cadastre,
               ms.modern_name,
               ms.nearest_city,
               ms.ancient_name,
               ms.district_id,
               ms.district,
               ms.governorate,
               ms.nation,
               ms.chronology,
               ms.survey_type,
               ms.surveys,
               ms.survey_refs,
               ms.features,
               ms.features_remarks,
               ms.threats,
               ms.remote_sensing,
               ms.survey_verified_on_field,
               ms.excavations_whom_when,
               ms.excavations_bibliography,
               ms.remarks,
               ms.e,
               ms.n,
               ms.area,
               ms.length,
               ms.width,
               ms.geom
        FROM geom.mat_site ms
        WHERE ms.remote_sensing = false AND ms.survey_type = 'not_sampled';");

        $this->addSql("ALTER TABLE geom.vw_site_survey_not_sampled_poly OWNER TO archiraq_admin;");

        $this->addSql("CREATE OR REPLACE VIEW geom.vw_site_survey_not_sampled_point
            (id, contribute_id, entry_id, sbah_no, cadastre, modern_name, nearest_city, ancient_name, district_id,
             district, governorate, nation, chronology, survey_type, surveys, survey_refs, features, features_remarks,
             threats, remote_sensing, survey_verified_on_field, excavations_whom_when, excavations_bibliography,
             remarks, e, n, area, length, width, geom)
        as
        SELECT ms.id,
               ms.contribute_id,
               ms.entry_id,
               ms.sbah_no,
               ms.cadastre,
               ms.modern_name,
               ms.nearest_city,
               ms.ancient_name,
               ms.district_id,
               ms.district,
               ms.governorate,
               ms.nation,
               ms.chronology,
               ms.survey_type,
               ms.surveys,
               ms.survey_refs,
               ms.features,
               ms.features_remarks,
               ms.threats,
               ms.remote_sensing,
               ms.survey_verified_on_field,
               ms.excavations_whom_when,
               ms.excavations_bibliography,
               ms.remarks,
               ms.e,
               ms.n,
               ms.area,
               ms.length,
               ms.width,
               ms.centroid AS geom
        FROM geom.mat_site ms
        WHERE ms.remote_sensing = false AND ms.survey_type = 'not_sampled';");

        $this->addSql("ALTER TABLE geom.vw_site_survey_not_sampled_point OWNER TO archiraq_admin;");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP VIEW IF EXISTS geom.vw_site_survey_not_sampled_poly;");
        $this->addSql("DROP VIEW IF EXISTS geom.vw_site_survey_not_sampled_point;");
    }
}
