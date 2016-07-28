<?php

namespace Tfe\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TfeUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
