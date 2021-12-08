<?php

namespace App\Controller;


use App\Entity\Individual;

class IndividualToggleActivationController
{
    public function __invoke(Individual $data): Individual
    {
        $toggle = $data->getDesactivated();

        $toggle = !$toggle;
        $data->setDesactivated($toggle);

        return $data;
    }
}
