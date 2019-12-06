<?php
/**
 * Config of passport
 */

 return [
    'personal_client_id' => env('PASSPORT_PERSONAL_CLIENT_ID', ''),
    'personal_client_secret' => env('PASSPORT_PERSONAL_CLIENT_SECRET', ''),

    'password_client_id' => env('PASSPORT_PASSWORD_CLIENT_ID', ''),
    'password_client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET', ''),
 ];