<?php
return [

    /*
    |----------------------------------------------------------------------
    | Authentication Defaults
    |----------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',  // Default guard is 'web'
        'passwords' => 'users',  // Default password reset for 'users'
    ],

    /*
    |----------------------------------------------------------------------
    | Authentication Guards
    |----------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | A guard is responsible for authenticating a user for the application.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',  // Use the 'users' provider for the 'web' guard
        ],

        // Add the manager guard for authentication
        'manager' => [
            'driver' => 'session',  // 'session' means we'll use session-based authentication
            'provider' => 'managers',  // Use the 'managers' provider for the 'manager' guard
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | User Providers
    |----------------------------------------------------------------------
    |
    | All authentication guards must have an associated user provider. 
    | The provider defines how users are retrieved from the database.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,  // Model for regular users
        ],

        // Add the provider for managers
        'managers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Manager::class,  // Model for managers
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Resetting Passwords
    |----------------------------------------------------------------------
    |
    | Password reset settings for each user provider. You can define
    | separate settings for different user types.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Add password reset settings for managers
        'managers' => [
            'provider' => 'managers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Password Confirmation Timeout
    |----------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen.
    |
    */

    'password_timeout' => 10800,  // 3 hours
];
