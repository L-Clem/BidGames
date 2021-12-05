<?php

namespace App\Controller;

use App\Entity\User;

class UserToggleActivationController
{
    public function __invoke(User $data): User
    {
        $toggle = $data->getDesactivated();
        $toggle = !$toggle;
        $data->setDesactivated($toggle);
        return $data;
    }
}
