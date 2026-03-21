<?php

namespace App\DTO;

class SurveyNotSampledFeatureDTO
{
    public $id;
    public $contribute;
    public $entry_id;
    public $sbah_no;
    public $cadastre;
    public $modern_nam;
    public $nearest_ci;
    public $ancient_na;
    public $district_i;
    public $district;
    public $governorat;
    public $nation;
    public $chronology; // Usually null
    public $survey_typ; // Expected to be "not_sampled"
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
    public $AREA;
    public $X;
    public $Y;

    // Coarse periods
    public $Ubaid;
    public $E_M_Uruk;
    public $L_Uruk;
    public $Jemdet_Nas;
    public $ED_I_II;
    public $ED_III;
    public $AKK;
    public $UR_III;
    public $IL;
    public $OB;
    public $Kassite;
    public $Middle_Bab;
    public $Neo_Babylo;
    public $Achaemenid;
    public $Hellenisti;
    public $Parthian;
    public $Sasanian;
    public $Islamic;
    public $Ottoman;

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
