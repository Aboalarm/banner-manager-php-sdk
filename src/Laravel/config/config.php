<?php
return [
    // Base API uri
    'base_uri' => env('BANNER_SDK_API_BASE_URI'),
    // The API user.
    'username' => env('BANNER_SDK_API_USERNAME'),
    // The API password.
    'password' => env('BANNER_SDK_API_PASSWORD'),
    // Proxy URI if API is behind a proxy
    'proxy_uri' => env('BANNER_SDK_API_PROXY_URI'),
    // Path where to store reports downloaded from API
    'reports_path' => env('BANNER_SDK_REPORTS_PATH'),
];
