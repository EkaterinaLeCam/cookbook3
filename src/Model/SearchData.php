<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SearchData
{
    public $q = ''; // Propriété pour le champ de recherche

    // Getter et Setter pour $q si nécessaire
    public function getQ(): ?string
    {
        return $this->q;
    }

    public function setQ(string $q): self
    {
        $this->q = $q;
        return $this;
    }
}