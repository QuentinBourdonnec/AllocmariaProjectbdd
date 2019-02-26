<?php

namespace AllocMaria\BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActiviteSection
 *
 * @ORM\Table(name="activite_section", indexes={@ORM\Index(name="FK_activite_section_id_section", columns={"id_section"})})
 * @ORM\Entity
 */
class ActiviteSection
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_activite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idActivite;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_activite", type="string", length=25, nullable=false)
     */
    private $nomActivite;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_activite", type="string", length=25, nullable=true)
     */
    private $lieuActivite;

    /**
     * @var string
     *
     * @ORM\Column(name="jour_activite", type="string", length=25, nullable=true)
     */
    private $jourActivite;

    /**
     * @var string
     *
     * @ORM\Column(name="horaire_activite", type="string", length=25, nullable=true)
     */
    private $horaireActivite;

    /**
     * @var string
     *
     * @ORM\Column(name="duree_activite", type="string", length=25, nullable=true)
     */
    private $dureeActivite;

    /**
     * @var integer
     *
     * @ORM\Column(name="tarif_activite", type="integer", nullable=true)
     */
    private $tarifActivite;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_cours_activite", type="integer", nullable=true)
     */
    private $nombreCoursActivite;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Adherent", inversedBy="idActivite")
     * @ORM\JoinTable(name="s_inscrit_a",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_activite", referencedColumnName="id_activite")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_adherent", referencedColumnName="id_adherent")
     *   }
     * )
     */
    private $idAdherent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idAdherent = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idActivite
     *
     * @return integer
     */
    public function getIdActivite()
    {
        return $this->idActivite;
    }

    /**
     * Set nomActivite
     *
     * @param string $nomActivite
     *
     * @return ActiviteSection
     */
    public function setNomActivite($nomActivite)
    {
        $this->nomActivite = $nomActivite;

        return $this;
    }

    /**
     * Get nomActivite
     *
     * @return string
     */
    public function getNomActivite()
    {
        return $this->nomActivite;
    }

    /**
     * Set lieuActivite
     *
     * @param string $lieuActivite
     *
     * @return ActiviteSection
     */
    public function setLieuActivite($lieuActivite)
    {
        $this->lieuActivite = $lieuActivite;

        return $this;
    }

    /**
     * Get lieuActivite
     *
     * @return string
     */
    public function getLieuActivite()
    {
        return $this->lieuActivite;
    }

    /**
     * Set jourActivite
     *
     * @param string $jourActivite
     *
     * @return ActiviteSection
     */
    public function setJourActivite($jourActivite)
    {
        $this->jourActivite = $jourActivite;

        return $this;
    }

    /**
     * Get jourActivite
     *
     * @return string
     */
    public function getJourActivite()
    {
        return $this->jourActivite;
    }

    /**
     * Set horaireActivite
     *
     * @param string $horaireActivite
     *
     * @return ActiviteSection
     */
    public function setHoraireActivite($horaireActivite)
    {
        $this->horaireActivite = $horaireActivite;

        return $this;
    }

    /**
     * Get horaireActivite
     *
     * @return string
     */
    public function getHoraireActivite()
    {
        return $this->horaireActivite;
    }

    /**
     * Set dureeActivite
     *
     * @param string $dureeActivite
     *
     * @return ActiviteSection
     */
    public function setDureeActivite($dureeActivite)
    {
        $this->dureeActivite = $dureeActivite;

        return $this;
    }

    /**
     * Get dureeActivite
     *
     * @return string
     */
    public function getDureeActivite()
    {
        return $this->dureeActivite;
    }

    /**
     * Set tarifActivite
     *
     * @param integer $tarifActivite
     *
     * @return ActiviteSection
     */
    public function setTarifActivite($tarifActivite)
    {
        $this->tarifActivite = $tarifActivite;

        return $this;
    }

    /**
     * Get tarifActivite
     *
     * @return integer
     */
    public function getTarifActivite()
    {
        return $this->tarifActivite;
    }

    /**
     * Set nombreCoursActivite
     *
     * @param integer $nombreCoursActivite
     *
     * @return ActiviteSection
     */
    public function setNombreCoursActivite($nombreCoursActivite)
    {
        $this->nombreCoursActivite = $nombreCoursActivite;

        return $this;
    }

    /**
     * Get nombreCoursActivite
     *
     * @return integer
     */
    public function getNombreCoursActivite()
    {
        return $this->nombreCoursActivite;
    }

    /**
     * Set idSection
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\Section $idSection
     *
     * @return ActiviteSection
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

    /**
     * Add idAdherent
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\Adherent $idAdherent
     *
     * @return ActiviteSection
     */
    public function addIdAdherent(\AllocMaria\BackOfficeBundle\Entity\Adherent $idAdherent)
    {
        $this->idAdherent[] = $idAdherent;

        return $this;
    }

    /**
     * Remove idAdherent
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\Adherent $idAdherent
     */
    public function removeIdAdherent(\AllocMaria\BackOfficeBundle\Entity\Adherent $idAdherent)
    {
        $this->idAdherent->removeElement($idAdherent);
    }

    /**
     * Get idAdherent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdAdherent()
    {
        return $this->idAdherent;
    }
}
