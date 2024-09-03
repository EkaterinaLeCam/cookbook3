<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SearchData
{
    /**
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    public ?string $q = null;
}
