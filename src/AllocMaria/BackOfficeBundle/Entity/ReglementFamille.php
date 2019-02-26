<?php

namespace AllocMaria\BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReglementFamille
 *
 * @ORM\Table(name="reglement_famille", indexes={@ORM\Index(name="FK_reglement_famille_id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class ReglementFamille
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_reglement", type="string", length=25, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReglement;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_reglement", type="integer", nullable=true)
     */
    private $totalReglement;

    /**
     * @var string
     *
     * @ORM\Column(name="saison_reglement", type="string", length=25, nullable=false)
     */
    private $saisonReglement;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_cotisation_reglement", type="integer", nullable=true)
     */
    private $totalCotisationReglement;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_adhesion_reglement", type="integer", nullable=true)
     */
    private $totalAdhesionReglement;

    /**
     * @var integer
     *
     * @ORM\Column(name="reduction_adhesion_reglement", type="integer", nullable=true)
     */
    private $reductionAdhesionReglement;

    /**
     * @var integer
     *
     * @ORM\Column(name="reduction_autre_reglement", type="integer", nullable=true)
     */
    private $reductionAutreReglement;

    /**
     * @var string
     *
     * @ORM\Column(name="motif_reduction_reglement", type="string", length=50, nullable=true)
     */
    private $motifReductionReglement;

    /**
     * @var \UserBureauAssociation
     *
     * @ORM\ManyToOne(targetEntity="UserBureauAssociation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="FamilleAdherent", mappedBy="idReglement")
     */
    private $idFamille;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ModeDeReglement", inversedBy="idReglement")
     * @ORM\JoinTable(name="regle_avec",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_reglement", referencedColumnName="id_reglement")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Mode", referencedColumnName="Mode")
     *   }
     * )
     */
    private $mode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="VersementReglement", inversedBy="idReglement")
     * @ORM\JoinTable(name="verse",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_reglement", referencedColumnName="id_reglement")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_versement", referencedColumnName="id_versement")
     *   }
     * )
     */
    private $idVersement;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idFamille = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mode = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idVersement = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idReglement
     *
     * @return string
     */
    public function getIdReglement()
    {
        return $this->idReglement;
    }

    /**
     * Set totalReglement
     *
     * @param integer $totalReglement
     *
     * @return ReglementFamille
     */
    public function setTotalReglement($totalReglement)
    {
        $this->totalReglement = $totalReglement;

        return $this;
    }

    /**
     * Get totalReglement
     *
     * @return integer
     */
    public function getTotalReglement()
    {
        return $this->totalReglement;
    }

    /**
     * Set saisonReglement
     *
     * @param string $saisonReglement
     *
     * @return ReglementFamille
     */
    public function setSaisonReglement($saisonReglement)
    {
        $this->saisonReglement = $saisonReglement;

        return $this;
    }

    /**
     * Get saisonReglement
     *
     * @return string
     */
    public function getSaisonReglement()
    {
        return $this->saisonReglement;
    }

    /**
     * Set totalCotisationReglement
     *
     * @param integer $totalCotisationReglement
     *
     * @return ReglementFamille
     */
    public function setTotalCotisationReglement($totalCotisationReglement)
    {
        $this->totalCotisationReglement = $totalCotisationReglement;

        return $this;
    }

    /**
     * Get totalCotisationReglement
     *
     * @return integer
     */
    public function getTotalCotisationReglement()
    {
        return $this->totalCotisationReglement;
    }

    /**
     * Set totalAdhesionReglement
     *
     * @param integer $totalAdhesionReglement
     *
     * @return ReglementFamille
     */
    public function setTotalAdhesionReglement($totalAdhesionReglement)
    {
        $this->totalAdhesionReglement = $totalAdhesionReglement;

        return $this;
    }

    /**
     * Get totalAdhesionReglement
     *
     * @return integer
     */
    public function getTotalAdhesionReglement()
    {
        return $this->totalAdhesionReglement;
    }

    /**
     * Set reductionAdhesionReglement
     *
     * @param integer $reductionAdhesionReglement
     *
     * @return ReglementFamille
     */
    public function setReductionAdhesionReglement($reductionAdhesionReglement)
    {
        $this->reductionAdhesionReglement = $reductionAdhesionReglement;

        return $this;
    }

    /**
     * Get reductionAdhesionReglement
     *
     * @return integer
     */
    public function getReductionAdhesionReglement()
    {
        return $this->reductionAdhesionReglement;
    }

    /**
     * Set reductionAutreReglement
     *
     * @param integer $reductionAutreReglement
     *
     * @return ReglementFamille
     */
    public function setReductionAutreReglement($reductionAutreReglement)
    {
        $this->reductionAutreReglement = $reductionAutreReglement;

        return $this;
    }

    /**
     * Get reductionAutreReglement
     *
     * @return integer
     */
    public function getReductionAutreReglement()
    {
        return $this->reductionAutreReglement;
    }

    /**
     * Set motifReductionReglement
     *
     * @param string $motifReductionReglement
     *
     * @return ReglementFamille
     */
    public function setMotifReductionReglement($motifReductionReglement)
    {
        $this->motifReductionReglement = $motifReductionReglement;

        return $this;
    }

    /**
     * Get motifReductionReglement
     *
     * @return string
     */
    public function getMotifReductionReglement()
    {
        return $this->motifReductionReglement;
    }

    /**
     * Set idUser
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\UserBureauAssociation $idUser
     *
     * @return ReglementFamille
     */
    public function setIdUser(\AllocMaria\BackOfficeBundle\Entity\UserBureauAssociation $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AllocMaria\BackOfficeBundle\Entity\UserBureauAssociation
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Add idFamille
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\FamilleAdherent $idFamille
     *
     * @return ReglementFamille
     */
    public function addIdFamille(\AllocMaria\BackOfficeBundle\Entity\FamilleAdherent $idFamille)
    {
        $this->idFamille[] = $idFamille;

        return $this;
    }

    /**
     * Remove idFamille
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\FamilleAdherent $idFamille
     */
    public function removeIdFamille(\AllocMaria\BackOfficeBundle\Entity\FamilleAdherent $idFamille)
    {
        $this->idFamille->removeElement($idFamille);
    }

    /**
     * Get idFamille
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdFamille()
    {
        return $this->idFamille;
    }

    /**
     * Add mode
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\ModeDeReglement $mode
     *
     * @return ReglementFamille
     */
    public function addMode(\AllocMaria\BackOfficeBundle\Entity\ModeDeReglement $mode)
    {
        $this->mode[] = $mode;

        return $this;
    }

    /**
     * Remove mode
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\ModeDeReglement $mode
     */
    public function removeMode(\AllocMaria\BackOfficeBundle\Entity\ModeDeReglement $mode)
    {
        $this->mode->removeElement($mode);
    }

    /**
     * Get mode
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Add idVersement
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\VersementReglement $idVersement
     *
     * @return ReglementFamille
     */
    public function addIdVersement(\AllocMaria\BackOfficeBundle\Entity\VersementReglement $idVersement)
    {
        $this->idVersement[] = $idVersement;

        return $this;
    }

    /**
     * Remove idVersement
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\VersementReglement $idVersement
     */
    public function removeIdVersement(\AllocMaria\BackOfficeBundle\Entity\VersementReglement $idVersement)
    {
        $this->idVersement->removeElement($idVersement);
    }

    /**
     * Get idVersement
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdVersement()
    {
        return $this->idVersement;
    }
}
