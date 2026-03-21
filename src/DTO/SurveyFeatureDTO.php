<?php

namespace App\DTO;

class SurveyFeatureDTO
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

    // Chronology Flags
    public $UBA;
    public $UB12;
    public $UB3;
    public $LCA;
    public $LC13;
    public $LC45;
    public $JNA;
    public $LCJN;
    public $EDA;
    public $ED12;
    public $ED1;
    public $ED2;
    public $ED23;
    public $ED3;
    public $AKK_1;
    public $EBA;
    public $MBA;
    public $MB12;
    public $MB1;
    public $UR3;
    public $MB23;
    public $ILA;
    public $OBA;
    public $LBA;
    public $KAS1;
    public $KAS2;
    public $IRA;
    public $NB1;
    public $NB2;
    public $ACH;
    public $SEL;
    public $PART;
    public $PRSAS;
    public $ISLA;
    public $SAS;
    public $ISL1;
    public $ISL2;
    public $OTT;

    // Coarse periods (often null in SURVEY)
    public $Ubaid;
    public $E_M_Uruk; // E-M Uruk -> E_M_Uruk
    public $L_Uruk;   // L Uruk -> L_Uruk
    public $Jemdet_Nas; // Jemdet Nas -> Jemdet_Nas
    public $ED_I_II;    // ED I-II -> ED_I_II
    public $ED_III;     // ED III -> ED_III
    public $Akk;
    public $Ur_III;     // Ur III -> Ur_III
    public $IL;
    public $OB;
    public $Kassite;
    public $Middle_Bab; // Middle Bab -> Middle_Bab
    public $Neo_Babylo; // Neo Babylo -> Neo_Babylo
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
            // Normalize keys with dashes or spaces to underscores
            $normalizedKey = str_replace(['-', ' ', '.'], '_', $key);
            if (property_exists($this, $normalizedKey)) {
                $this->$normalizedKey = $value;
            }
        }
        $this->geometry = $geometry;
    }
}
