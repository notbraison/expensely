<?php

return [
'paths' => ['api/*', 'sanctum/csrf-cookie','auth/*'],
'allowed_methods' => ['*'],
'allowed_origins' => ['http://localhost:3500','http://127.0.0.1:3500'],
'allowed_origins_patterns' => [],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => true,

];
