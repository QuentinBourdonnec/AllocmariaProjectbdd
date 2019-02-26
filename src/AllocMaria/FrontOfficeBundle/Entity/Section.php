<?php

namespace AllocMaria\FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="section", indexes={@ORM\Index(name="FK_section_libelle_type_section", columns={"libelle_type_section"})})
 * @ORM\Entity
 */
class Section
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_section", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSection;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_section", type="string", length=25, nullable=false)
     */
    private $nomSection;

    /**
     * @var \TypeSection
     *
     * @ORM\ManyToOne(targetEntity="TypeSection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="libelle_type_section", referencedColumnName="libelle_type_section")
     * })
     */
    private $libelleTypeSection;



    /**
     * Get idSection
     *
     * @return integer
     */
    public function getIdSection()
    {
        return $this->idSection;
    }

    /**
     * Set nomSection
     *
     * @param string $nomSection
     *
     * @return Section
     */
    public function setNomSection($nomSection)
    {
        $this->nomSection = $nomSection;

        return $this;
    }

    /**
     * Get nomSection
     *
     * @return string
     */
    public function getNomSection()
    {
        return $this->nomSection;
    }

    /**
     * Set libelleTypeSection
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\TypeSection $libelleTypeSection
     *
     * @return Section
     */
    public function setLibelleTypeSection(\AllocMaria\FrontOfficeBundle\Entity\TypeSection $libelleTypeSection = null)
    {
        $this->libelleTypeSection = $libelleTypeSection;

        return $this;
    }

    /**
     * Get libelleTypeSection
     *
     * @return \AllocMaria\FrontOfficeBundle\Entity\TypeSection
     */
    public function getLibelleTypeSection()
    {
        return $this->libelleTypeSection;
    }
}
