<?php
return [
    'secret' => env('TOKEN_SECRET', 'www.Geek-Zoo.com!!!'),
    'alg'    => env('TOKEN_ALG', 'HS256'),
    'ttl'    => env('TOKEN_TTL', 60) // minutes
];