<?php

return [
    /*
      |--------------------------------------------------------------------------
      | API Keys
      |--------------------------------------------------------------------------
      |
      | Set the public and private API keys as provided by reCAPTCHA.
      |
      | In version 2 of reCAPTCHA, public_key is the Site key,
      | and private_key is the Secret key.
      |
     */
    'public_key' => env('RECAPTCHA_PUBLIC_KEY', '6Le7_G4UAAAAABFzJdeiK4xH6DotajfvMuEVLP_D'),
    'private_key' => env('RECAPTCHA_PRIVATE_KEY', '6Le7_G4UAAAAAF0YO7rgORbnEmRGEXQoxg1xn1Ev'),
    /*
      |--------------------------------------------------------------------------
      | Template
      |--------------------------------------------------------------------------
      |
      | Set a template to use if you don't want to use the standard one.
      |
     */
    'template' => '',
    /*
      |--------------------------------------------------------------------------
      | Driver
      |--------------------------------------------------------------------------
      |
      | Determine how to call out to get response; values are 'curl' or 'native'.
      | Only applies to v2.
      |
     */
    'driver' => 'native',
    /*
      |--------------------------------------------------------------------------
      | Options
      |--------------------------------------------------------------------------
      |
      | Various options for the driver
      |
     */
    'options' => [
        'curl_timeout' => 1,
        'curl_verify' => true,
    ],
    /*
      |--------------------------------------------------------------------------
      | Version
      |--------------------------------------------------------------------------
      |
      | Set which version of ReCaptcha to use.
      |
     */
    'version' => 2,
];
