<?php

namespace AllocMaria\BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeUser
 *
 * @ORM\Table(name="type_user", indexes={@ORM\Index(name="FK_type_user_id_section", columns={"id_section"})})
 * @ORM\Entity
 */
class TypeUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle_type_user", type="string", length=25, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $libelleTypeUser;

    /**
     * @var \Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_section", referencedColumnName="id_section")
     * })
     */
    private $idSection;



    /**
     * Get libelleTypeUser
     *
     * @return string
     */
    public function getLibelleTypeUser()
    {
        return $this->libelleTypeUser;
    }

    /**
     * Set idSection
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\Section $idSection
     *
     * @return TypeUser
     */
    public function setIdSection(\AllocMaria\BackOfficeBundle\Entity\Section $idSection = null)
    {
        $this->idSection = $idSection;

        return $this;
    }

    /**
     * Get idSection
     *
     * @return \AllocMaria\BackOfficeBundle\Entity\Section
     */
    public function getIdSection()
    {
        return $this->idSection;
    }
}
