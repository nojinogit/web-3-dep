<?php
return [
    'stripe_public_key' => env('STRIPE_PUBLIC_KEY'),
    'stripe_secret_key' => env('STRIPE_SECRET_KEY'),
    'webhook' => [
            'secret' => env('STRIPE_WEBHOOK'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
];
