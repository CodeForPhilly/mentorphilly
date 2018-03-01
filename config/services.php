<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],


    'slack' => [

        'auth_token' => env('SLACK_AUTH_TOKEN'),
        // 'auth_token' => env('TEXT_BOT_OAUTH'),
        'hook' => env('SLACK_WEB_HOOK'),
        'apihook' => env('SLACK_API_HOOK'),

        'text-bot-oauth' => env('TEXT_BOT_OAUTH'),
// =========


    /*
    |--------------------------------------------------------------------------
    | Default Channel
    |--------------------------------------------------------------------------
    |
    | This is the default channel to post bot messages on
    |
    */
    'default_channel' => '#random',
    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | This will be the displayed username of posting slack bot
    |
    */
    'username' => 'incoming_text_bot',
    /*
    |--------------------------------------------------------------------------
    | Base Uri
    |--------------------------------------------------------------------------
    |
    | Base uri for slack api endpoint
    |
    */
    'base_uri' => 'https://slack.com/api/',
    /*
    |--------------------------------------------------------------------------
    | Token
    |--------------------------------------------------------------------------
    |
    | Token to pass to Slack API requests
    |
    */
    'token' => env('TEXT_BOT_OAUTH'),
    /*
    |--------------------------------------------------------------------------
    | Webhook
    |--------------------------------------------------------------------------
    |
    | Token to pass to Slack API requests
    |
    */
    'webhook' => null,
    /*
    |--------------------------------------------------------------------------
    | Emoji Icon
    |--------------------------------------------------------------------------
    |
    | Reference to slack emoji icon
    |
    */
    'emoji_icon' => ':calling:',
    /*
    |--------------------------------------------------------------------------
    | Server IP
    |--------------------------------------------------------------------------
    |
    | Include server public IP in username
    |
    */
    'server_ip' => false,
    /*
    |--------------------------------------------------------------------------
    | Blacklist Ips by Organization
    |--------------------------------------------------------------------------
    |
    | block message if ipInfo lookup returns result with organization from the
    | following.  Or leave blank
    |
    */
    'blacklist_providers' => [],




// =========

    ],




];
