<?php

namespace Xshop\Multitenancy\Actions;

use App\Models\User;

class CreateUser
{
    protected $name;
    protected $email;
    protected $password;

    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function execute($tenant)
    {
        // Activate the landlord database
        (new ActivateDatabase())->execute($tenant);

        // Create the user in the landlord database
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => \Hash::make($this->password),
            'role' => 'ADMIN'
        ]);

        return $user;
    }

}
