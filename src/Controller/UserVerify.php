<?php

namespace App\Controller;

use App\Entity\User;

class UserVerify
{
    public function __invoke(User $data): User
    {
        $toggle = $data->getVerified();
        $toggle = !$toggle;
        $data->setVerified($toggle);
        return $data;
    }
}
