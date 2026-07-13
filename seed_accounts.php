<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$m = User::updateOrCreate(['email' => 'mahasiswa@demo.com'], ['name' => 'Demo Mahasiswa', 'password' => Hash::make('password123'), 'role' => 'mahasiswa']);
$m->markEmailAsVerified();

$p = User::updateOrCreate(['email' => 'perusahaan@demo.com'], ['name' => 'Demo Perusahaan', 'password' => Hash::make('password123'), 'role' => 'perusahaan']);
$p->markEmailAsVerified();

echo "Accounts created successfully!\n";
