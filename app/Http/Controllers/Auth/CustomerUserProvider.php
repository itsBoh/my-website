<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return Customer::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        // Not needed for this example
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Not needed for this example
    }

    public function retrieveByCredentials(array $credentials)
    {
        return Customer::where('cust_username', $credentials['username'])->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }
}
