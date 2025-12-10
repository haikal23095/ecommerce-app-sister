<?php
require __DIR__ . '/vendor/autoload.php';

$u = new App\Models\Pengguna;
echo method_exists($u, 'getAuthIdentifierName') ? 'yes' : 'no';
