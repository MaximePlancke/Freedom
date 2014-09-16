<?php

namespace Freedom\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FreedomUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
