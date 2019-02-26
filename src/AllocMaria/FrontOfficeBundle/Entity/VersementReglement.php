<?php

namespace AllocMaria\FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VersementReglement
 *
 * @ORM\Table(name="versement_reglement")
 * @ORM\Entity
 */
class VersementReglement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_versement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVersement;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant_versement", type="integer", nullable=false)
     */
    private $montantVersement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ReglementFamille", mappedBy="idVersement")
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
     * Get idVersement
     *
     * @return integer
     */
    public function getIdVersement()
    {
        return $this->idVersement;
    }

    /**
     * Set montantVersement
     *
     * @param integer $montantVersement
     *
     * @return VersementReglement
     */
    public function setMontantVersement($montantVersement)
    {
        $this->montantVersement = $montantVersement;

        return $this;
    }

    /**
     * Get montantVersement
     *
     * @return integer
     */
    public function getMontantVersement()
    {
        return $this->montantVersement;
    }

    /**
     * Add idReglement
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\ReglementFamille $idReglement
     *
     * @return VersementReglement
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
