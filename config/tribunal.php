<?php
return [
    'form1' => [
        'maturity_period' => env('CONF_F1_MATURED_DURATION', 14),
    ],
    'form2' => [
        'maturity_period' => env('CONF_F2_MATURED_DURATION', 14),
    ],
    'form3' => [
        'maturity_period' => env('CONF_F3_MATURED_DURATION', 14),
    ],
    'hearing' => [
        'alert_period' => env('CONF_HEARING_ALERT_DURATION', 14),
        'submission_period' => env('CONF_HEARING_SUBMISSION_DURATION', 14),
    ],
    'claim_amount' => env('CONF_CLAIM_AMOUNT', 50000),
];