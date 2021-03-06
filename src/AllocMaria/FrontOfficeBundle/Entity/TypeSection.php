<?php

namespace AllocMaria\FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeSection
 *
 * @ORM\Table(name="type_section")
 * @ORM\Entity
 */
class TypeSection
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle_type_section", type="string", length=25, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $libelleTypeSection;



    /**
     * Get libelleTypeSection
     *
     * @return string
     */
    public function getLibelleTypeSection()
    {
        return $this->libelleTypeSection;
    }
}
