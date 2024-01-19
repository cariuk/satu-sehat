<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Condition
{
    public static function formCreateData($encounter,$code,$name)
    {
        return [
            "resourceType"=> "Condition",
            "clinicalStatus"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/condition-clinical",
                        "code"=> "active",
                        "display"=> "Active"
                    ]
                ]
            ],
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/condition-category",
                            "code"=> "encounter-diagnosis",
                            "display"=> "Encounter Diagnosis"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://hl7.org/fhir/sid/icd-10",
                        "code"=> $code,
                        "display"=> $name
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->identifier_satu_sehat,
                "display"=> $encounter->patient->nama
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->identifier_satu_sehat,
                "display"=> "Kunjungan pasien pada ".$encounter->tanggal. " " . $encounter->waktu
            ]
        ];
    }

    public static function formUpdateData($ihsNumber,$encounter,$code,$name)
    {
        return [
            "resourceType"=> "Condition",
            "id"=> $ihsNumber,
            "clinicalStatus"=> [
                "coding"=> [
                    [
                        "system"=> "http://terminology.hl7.org/CodeSystem/condition-clinical",
                        "code"=> "active",
                        "display"=> "Active"
                    ]
                ]
            ],
            "category"=> [
                [
                    "coding"=> [
                        [
                            "system"=> "http://terminology.hl7.org/CodeSystem/condition-category",
                            "code"=> "encounter-diagnosis",
                            "display"=> "Encounter Diagnosis"
                        ]
                    ]
                ]
            ],
            "code"=> [
                "coding"=> [
                    [
                        "system"=> "http://hl7.org/fhir/sid/icd-10",
                        "code"=> $code,
                        "display"=> $name
                    ]
                ]
            ],
            "subject"=> [
                "reference"=> "Patient/".$encounter->patient->identifier_satu_sehat,
                "display"=> $encounter->patient->nama
            ],
            "encounter"=> [
                "reference"=> "Encounter/".$encounter->identifier_satu_sehat,
                "display"=> "Kunjungan pasien pada ".$encounter->tanggal. " " . $encounter->waktu
            ]
        ];
    }
}
