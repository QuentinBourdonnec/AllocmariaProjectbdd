<?php

namespace AllocMaria\FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FamilleAdherent
 *
 * @ORM\Table(name="famille_adherent")
 * @ORM\Entity
 */
class FamilleAdherent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_famille", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFamille;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ReglementFamille", inversedBy="idFamille")
     * @ORM\JoinTable(name="effectue_le_reglement",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_famille", referencedColumnName="id_famille")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_reglement", referencedColumnName="id_reglement")
     *   }
     * )
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
     * Get idFamille
     *
     * @return integer
     */
    public function getIdFamille()
    {
        return $this->idFamille;
    }

    /**
     * Add idReglement
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\ReglementFamille $idReglement
     *
     * @return FamilleAdherent
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
