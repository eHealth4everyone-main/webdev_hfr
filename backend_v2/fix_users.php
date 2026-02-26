<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$users = [
    [
        'email' => 'admin@hfr.gov.ng',
        'username' => 'admin',
        'password' => 'password123',
        'fname' => 'Admin',
        'lname' => 'User'
    ],
    [
        'email' => 'developer@hfr.gov.ng',
        'username' => 'developer',
        'password' => 'password123',
        'fname' => 'Developer',
        'lname' => 'Account'
    ]
];

foreach ($users as $uData) {
    $user = User::where('email', $uData['email'])->first();
    if (!$user) {
        $user = new User();
        $user->firstname = $uData['fname'];
        $user->lastname = $uData['lname'];
        $user->username = $uData['username'];
        $user->email = $uData['email'];
    }
    $user->password = Hash::make($uData['password']);
    $user->status = 1;
    $user->save();
    echo "Set up user: " . $user->email . PHP_EOL;
}
