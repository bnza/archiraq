<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Fix view definitions to include sites with NULL survey_type.
 */
final class Version20260420185500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Fix view definitions to include sites with NULL survey_type.';
    }

    public function up(Schema $schema) : void
    {
        // Update geom.vw_site_survey_poly
        $this->addSql("CREATE OR REPLACE VIEW geom.vw_site_survey_poly
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
        WHERE ms.remote_sensing = false AND (ms.survey_type IS NULL OR ms.survey_type != 'not_sampled') AND ST_IsEmpty(geom)=false;");

        // Update geom.vw_site_survey_point
        $this->addSql("CREATE OR REPLACE VIEW geom.vw_site_survey_point
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
        WHERE ms.remote_sensing = false AND (ms.survey_type IS NULL OR ms.survey_type != 'not_sampled') AND ST_IsEmpty(geom)=false;");
    }

    public function down(Schema $schema) : void
    {
        // Revert to original behavior where NULL survey_type is excluded
        $this->addSql("CREATE OR REPLACE VIEW geom.vw_site_survey_poly
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
        WHERE ms.remote_sensing = false AND ms.survey_type != 'not_sampled' AND ST_IsEmpty(geom)=false;");

        $this->addSql("CREATE OR REPLACE VIEW geom.vw_site_survey_point
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
        WHERE ms.remote_sensing = false AND ms.survey_type != 'not_sampled' AND ST_IsEmpty(geom)=false;");
    }
}
