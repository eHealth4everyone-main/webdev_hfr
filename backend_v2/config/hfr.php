<?php

return [

    'dhis_url' => env('DHIS_BASE_URI'),

    'dhis_username' => env('DHIS_USERNAME'),

    'dhis_password' => env('DHIS_PASSWORD'),

    'notify_verifier' => env('SEND_EMAIL_NOTIFICATION_TO_VERIFER', true),

    'notify_validator' => env('SEND_EMAIL_NOTIFICATION_T0_VALIDATOR', true),

    'notify_publisher' => env('SEND_EMAIL_NOTIFICATION_TO_PUBLISHER', true),

    'notify_publication' => env('SEND_EMAIL_NOTIFICATION_AFTER_PUBLICATION', true),

    'integration_enabled' => env('DHIS_INTEGRATION', true),


];
