<?php

namespace App\DTO;

/**
 * Shares same schema as SURVEY according to the plan, but without flag columns.
 */
class RemoteSensingFeatureDTO
{
    public $id;
    public $contribute;
    public $entry_id;
    public $modern_nam;
    public $nearest_ci;
    public $ancient_na;
    public $district_i;
    public $district;
    public $governorat;
    public $nation;
    public $chronology;
    public $survey_typ;
    public $surveys;
    public $survey_ref;
    public $features;
    public $features_r;
    public $threats;
    public $remote_sen;
    public $survey_ver;
    public $excavation;
    public $excavatio0;
    public $remarks;
    public $x_1;
    public $y_1;
    public $area;

    public $geometry;

    public function __construct(array $properties, array $geometry)
    {
        foreach ($properties as $key => $value) {
            $normalizedKey = str_replace(['-', ' ', '.'], '_', $key);
            if (property_exists($this, $normalizedKey)) {
                $this->$normalizedKey = $value;
            }
        }
        $this->geometry = $geometry;
    }
}
