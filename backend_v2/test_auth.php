<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$email = 'developer@hfr.gov.ng';
$password = 'password123';

$user = User::where('email', $email)->first();
if (!$user) {
    $user = new User();
    $user->firstname = 'Developer';
    $user->lastname = 'Account';
    $user->username = 'developer';
    $user->email = $email;
}
$user->password = Hash::make($password);
$user->status = 1;
$user->save();

echo "User updated/created: " . $user->email . PHP_EOL;
echo "Attempting login with password123..." . PHP_EOL;

if (Auth::attempt(['email' => $email, 'password' => $password])) {
    echo "SUCCESS: Login works!" . PHP_EOL;
} else {
    echo "FAIL: Login still failing." . PHP_EOL;
}
