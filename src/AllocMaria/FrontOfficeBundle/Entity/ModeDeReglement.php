<?php

namespace AllocMaria\FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeDeReglement
 *
 * @ORM\Table(name="mode_de_reglement")
 * @ORM\Entity
 */
class ModeDeReglement
{
    /**
     * @var string
     *
     * @ORM\Column(name="Mode", type="string", length=25, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mode;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant_reglement", type="integer", nullable=true)
     */
    private $montantReglement;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validation_reglement", type="boolean", nullable=true)
     */
    private $validationReglement;

    /**
     * @var string
     *
     * @ORM\Column(name="informations_reglement", type="string", length=50, nullable=true)
     */
    private $informationsReglement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ReglementFamille", mappedBy="mode")
     */
    private $idReglement;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idReglement = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set montantReglement
     *
     * @param integer $montantReglement
     *
     * @return ModeDeReglement
     */
    public function setMontantReglement($montantReglement)
    {
        $this->montantReglement = $montantReglement;

        return $this;
    }

    /**
     * Get montantReglement
     *
     * @return integer
     */
    public function getMontantReglement()
    {
        return $this->montantReglement;
    }

    /**
     * Set validationReglement
     *
     * @param boolean $validationReglement
     *
     * @return ModeDeReglement
     */
    public function setValidationReglement($validationReglement)
    {
        $this->validationReglement = $validationReglement;

        return $this;
    }

    /**
     * Get validationReglement
     *
     * @return boolean
     */
    public function getValidationReglement()
    {
        return $this->validationReglement;
    }

    /**
     * Set informationsReglement
     *
     * @param string $informationsReglement
     *
     * @return ModeDeReglement
     */
    public function setInformationsReglement($informationsReglement)
    {
        $this->informationsReglement = $informationsReglement;

        return $this;
    }

    /**
     * Get informationsReglement
     *
     * @return string
     */
    public function getInformationsReglement()
    {
        return $this->informationsReglement;
    }

    /**
     * Add idReglement
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\ReglementFamille $idReglement
     *
     * @return ModeDeReglement
     */
    public function addIdReglement(\AllocMaria\FrontOfficeBundle\Entity\ReglementFamille $idReglement)
    {
        $this->idReglement[] = $idReglement;

        return $this;
    }

    /**
     * Remove idReglement
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\ReglementFamille $idReglement
     */
    public function removeIdReglement(\AllocMaria\FrontOfficeBundle\Entity\ReglementFamille $idReglement)
    {
        $this->idReglement->removeElement($idReglement);
    }

    /**
     * Get idReglement
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdReglement()
    {
        return $this->idReglement;
    }
}
