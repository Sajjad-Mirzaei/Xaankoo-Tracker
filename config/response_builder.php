<?php
declare(strict_types=1);

return [
    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Code range settings
    |-------------------------------------------------------------------------------------------------------------------
    */
    'min_code'          => 100,
    'max_code'          => 1024,

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Error code to message mapping
    |-------------------------------------------------------------------------------------------------------------------
    */
    'map'               => [
        \App\ApiCode::REGISTER_FAILED=>'api.register_failed',
        \App\ApiCode::LOGIN_FAILED=>'api.login_failed',
        \App\ApiCode::CHANGE_PASSWORD_FAILED=>'api.change_password_failed',
        \App\ApiCode::INVALID_CREDENTIALS=>'api.invalid_credentials',
        \App\ApiCode::VALIDATION_FAILED  =>'api.validation_failed',
        \App\ApiCode::USER_NOT_FIND      =>'api.user_not_find',
        \App\ApiCode::INVALID_RESET_PASSWORD_TOKEN=>'api.invalid_reset_password_token',
        \App\ApiCode::NOT_ACCESS=>'api.not_access'
    ],
];
