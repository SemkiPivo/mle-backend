<?php

return [

    'status' => env('CODE_VERIFICATION_STATUS', false),
    'code_length' => env('CODE_VERIFICATION_LENGTH', 4),
    'code_lifetime' => env('CODE_VERIFICATION_LIFETIME_MINUTES', 30)

];
