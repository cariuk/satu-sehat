<?php

namespace syahrulzzadie\SatuSehat\JsonData;

use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\StrHelper;

class Organization
{
    public static function formCreateData($kode, $name, $instansi)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType" => "Organization",
            "active" => true,
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "http://sys-ids.kemkes.go.id/organization/" . $organizationId,
                    "value" => (string) $kode
                ]
            ],
            "type" => [
                [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/organization-type",
                            "code" => "dept",
                            "display" => "Hospital Department"
                        ]
                    ]
                ]
            ],
            "name" => StrHelper::getName($name),
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => $instansi->TELEPON,
                    "use" => "work"
                ],
                [
                    "system" => "email",
                    "value" => $instansi->EMAIL,
                    "use" => "work"
                ],
                [
                    "system" => "url",
                    "value" => $instansi->WEBSITE,
                    "use" => "work"
                ]
            ],
            "address" => [
                [
                    "use" => "work",
                    "type" => "both",
                    "line" => [
                       $instansi->ALAMAT
                    ],
                    "city" => $instansi->DESWILAYAH,
                    "postalCode" => $instansi->KODEPOS,
                    "country" => "ID",
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                            "extension" => [
                                [
                                    "url" => "province",
                                    "valueCode" => $instansi->WILAYAH
                                ],
                                [
                                    "url" => "city",
                                    "valueCode" => "0"
                                ],
                                [
                                    "url" => "district",
                                    "valueCode" => "0"
                                ],
                                [
                                    "url" => "village",
                                    "valueCode" => "0"
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "partOf" => [
                "reference" => "Organization/" . $organizationId,
                "display" => $instansi->LENGKAP
            ]
        ];
    }

    public static function formUpdateData($ihsNumber, $kode, $name,$instansi)
    {
        $organizationId = Enviroment::organizationId();
        return [
            "resourceType" => "Organization",
            "id" => $ihsNumber,
            "active" => true,
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "http://sys-ids.kemkes.go.id/organization/" . $organizationId,
                    "value" => (string) $kode
                ]
            ],
            "type" => [
                [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/organization-type",
                            "code" => "dept",
                            "display" => "Hospital Department"
                        ]
                    ]
                ]
            ],
            "name" => StrHelper::getName($name),
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => $instansi->TELEPON,
                    "use" => "work"
                ],
                [
                    "system" => "email",
                    "value" => $instansi->EMAIL,
                    "use" => "work"
                ],
                [
                    "system" => "url",
                    "value" => $instansi->WEBSITE,
                    "use" => "work"
                ]
            ],
            "address" => [
                [
                    "use" => "work",
                    "type" => "both",
                    "line" => [
                       $instansi->ALAMAT
                    ],
                    "city" => $instansi->DESWILAYAH,
                    "postalCode" => $instansi->KODEPOS,
                    "country" => "ID",
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                            "extension" => [
                                [
                                    "url" => "province",
                                    "valueCode" => $instansi->WILAYAH
                                ],
                                [
                                    "url" => "city",
                                    "valueCode" => "0"
                                ],
                                [
                                    "url" => "district",
                                    "valueCode" => "0"
                                ],
                                [
                                    "url" => "village",
                                    "valueCode" => "0"
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "partOf" => [
                "reference" => "Organization/" . $organizationId,
                "display" => $instansi->LENGKAP
            ]
        ];
    }
}
