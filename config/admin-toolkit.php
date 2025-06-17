<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Toolkit Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration globale portable et réutilisable.
    | Chaque projet pourra publier et surcharger ces paramètres.
    |
    */

    'protected_tables' => [
        'migrations',
        'users',
        'password_resets',
        'failed_jobs',
        'personal_access_tokens',
    ],

];
