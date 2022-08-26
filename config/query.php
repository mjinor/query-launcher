<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dynamic Mode Or Separate Mode
    |--------------------------------------------------------------------------
    */

    "mode" => \App\Http\Controllers\QueryController::SEPARATE_MODE,

    /*
    |--------------------------------------------------------------------------
    | Queries class & method names - DYNAMIC STRUCTURE
    |--------------------------------------------------------------------------
    */

    "dynamic-structure" => [
        "book" => [
            "selectRefundsByRefId" => [
                "show_as" => "Refund",
                "params" => [
                    [
                        "label" => "Ref ID",
                        "type" => "text",
                        "name" => "ref_id",
                        "priority" => 1,
                        "validation" => "required"
                    ]
                ],
                "response" => \Illuminate\Support\Collection::class,
            ],
            "findByRefId" => [
                "show_as" => "Fetch book by ref ID",
                "params" => [
                    [
                        "label" => "Ref ID",
                        "type" => "text",
                        "name" => "ref_id",
                        "priority" => 1,
                        "validation" => "required"
                    ]
                ],
                "response" => \Illuminate\Support\Collection::class
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Queries route action names with parameters
    |--------------------------------------------------------------------------
    */

    "structure" => [
        "refund" => [
            "show_as" => "Refund",
            "params" => [
                [
                    "label" => "Ref ID",
                    "type" => "text",
                    "name" => "ref_id",
                    "priority" => 1,
                    "validation" => "required"
                ]
            ],
        ],
        "find-book-by-ref-id" => [
            "show_as" => "Fetch book by ref ID",
            "params" => [
                [
                    "label" => "Ref ID",
                    "type" => "text",
                    "name" => "ref_id",
                    "priority" => 1,
                    "validation" => "required"
                ]
            ],
        ],
        "cancel-delete" => [
            "show_as" => "Cancel Book Delete",
            "params" => [
                [
                    "label" => "Ref ID",
                    "type" => "text",
                    "name" => "ref_id",
                    "priority" => 1,
                    "validation" => "required"
                ],
                [
                    "label" => "Reset Payment ?",
                    "type" => "checkbox",
                    "name" => "with_factor",
                    "priority" => 2,
                    "value" => 1
                ]
            ],
        ],
        "expired-to-paid" => [
            "show_as" => "Make Factor From Expired To Paid",
            "params" => [
                [
                    "label" => "Factor ID",
                    "type" => "text",
                    "name" => "factor_id",
                    "priority" => 1,
                    "validation" => "required"
                ]
            ],
        ],
        "find-doctor-by-medical-code" => [
            "show_as" => "Find Doctor By Medical Code",
            "params" => [
                [
                    "label" => "Medical Code",
                    "type" => "text",
                    "name" => "medical_code",
                    "priority" => 1,
                    "validation" => "required",
                ]
            ],
        ],
    ]
];
