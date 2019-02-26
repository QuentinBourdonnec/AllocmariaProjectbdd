<?php

namespace AllocMaria\FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adherent
 *
 * @ORM\Table(name="adherent", indexes={@ORM\Index(name="FK_adherent_id_famille", columns={"id_famille"})})
 * @ORM\Entity
 */
class Adherent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_adherent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdherent;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_adherent", type="string", length=25, nullable=false)
     */
    private $nomAdherent;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_adherent", type="string", length=25, nullable=false)
     */
    private $prenomAdherent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance_adherent", type="date", nullable=false)
     */
    private $dateNaissanceAdherent;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_adherent", type="string", length=40, nullable=false)
     */
    private $adresseAdherent;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_postal_adherent", type="integer", nullable=false)
     */
    private $codePostalAdherent;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_adherent", type="string", length=40, nullable=false)
     */
    private $villeAdherent;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_domicile_adherent", type="string", length=15, nullable=true)
     */
    private $telDomicileAdherent;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_portable_adherent", type="string", length=15, nullable=true)
     */
    private $telPortableAdherent;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_adherent", type="string", length=50, nullable=true)
     */
    private $mailAdherent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation_adherent", type="date", nullable=true)
     */
    private $dateCreationAdherent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sexe_adherent", type="boolean", nullable=true)
     */
    private $sexeAdherent;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_adherent", type="integer", nullable=true)
     */
    private $numeroAdherent;

    /**
     * @var \FamilleAdherent
     *
     * @ORM\ManyToOne(targetEntity="FamilleAdherent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_famille", referencedColumnName="id_famille")
     * })
     */
    private $idFamille;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ReferentAdherent", inversedBy="idAdherent")
     * @ORM\JoinTable(name="mineurs_affilie_a",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_adherent", referencedColumnName="id_adherent")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_referent", referencedColumnName="id_referent")
     *   }
     * )
     */
    private $idReferent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ActiviteSection", mappedBy="idAdherent")
     */
    private $idActivite;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idReferent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idActivite = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idAdherent
     *
     * @return integer
     */
    public function getIdAdherent()
    {
        return $this->idAdherent;
    }

    /**
     * Set nomAdherent
     *
     * @param string $nomAdherent
     *
     * @return Adherent
     */
    public function setNomAdherent($nomAdherent)
    {
        $this->nomAdherent = $nomAdherent;

        return $this;
    }

    /**
     * Get nomAdherent
     *
     * @return string
     */
    public function getNomAdherent()
    {
        return $this->nomAdherent;
    }

    /**
     * Set prenomAdherent
     *
     * @param string $prenomAdherent
     *
     * @return Adherent
     */
    public function setPrenomAdherent($prenomAdherent)
    {
        $this->prenomAdherent = $prenomAdherent;

        return $this;
    }

    /**
     * Get prenomAdherent
     *
     * @return string
     */
    public function getPrenomAdherent()
    {
        return $this->prenomAdherent;
    }

    /**
     * Set dateNaissanceAdherent
     *
     * @param \DateTime $dateNaissanceAdherent
     *
     * @return Adherent
     */
    public function setDateNaissanceAdherent($dateNaissanceAdherent)
    {
        $this->dateNaissanceAdherent = $dateNaissanceAdherent;

        return $this;
    }

    /**
     * Get dateNaissanceAdherent
     *
     * @return \DateTime
     */
    public function getDateNaissanceAdherent()
    {
        return $this->dateNaissanceAdherent;
    }

    /**
     * Set adresseAdherent
     *
     * @param string $adresseAdherent
     *
     * @return Adherent
     */
    public function setAdresseAdherent($adresseAdherent)
    {
        $this->adresseAdherent = $adresseAdherent;

        return $this;
    }

    /**
     * Get adresseAdherent
     *
     * @return string
     */
    public function getAdresseAdherent()
    {
        return $this->adresseAdherent;
    }

    /**
     * Set codePostalAdherent
     *
     * @param integer $codePostalAdherent
     *
     * @return Adherent
     */
    public function setCodePostalAdherent($codePostalAdherent)
    {
        $this->codePostalAdherent = $codePostalAdherent;

        return $this;
    }

    /**
     * Get codePostalAdherent
     *
     * @return integer
     */
    public function getCodePostalAdherent()
    {
        return $this->codePostalAdherent;
    }

    /**
     * Set villeAdherent
     *
     * @param string $villeAdherent
     *
     * @return Adherent
     */
    public function setVilleAdherent($villeAdherent)
    {
        $this->villeAdherent = $villeAdherent;

        return $this;
    }

    /**
     * Get villeAdherent
     *
     * @return string
     */
    public function getVilleAdherent()
    {
        return $this->villeAdherent;
    }

    /**
     * Set telDomicileAdherent
     *
     * @param string $telDomicileAdherent
     *
     * @return Adherent
     */
    public function setTelDomicileAdherent($telDomicileAdherent)
    {
        $this->telDomicileAdherent = $telDomicileAdherent;

        return $this;
    }

    /**
     * Get telDomicileAdherent
     *
     * @return string
     */
    public function getTelDomicileAdherent()
    {
        return $this->telDomicileAdherent;
    }

    /**
     * Set telPortableAdherent
     *
     * @param string $telPortableAdherent
     *
     * @return Adherent
     */
    public function setTelPortableAdherent($telPortableAdherent)
    {
        $this->telPortableAdherent = $telPortableAdherent;

        return $this;
    }

    /**
     * Get telPortableAdherent
     *
     * @return string
     */
    public function getTelPortableAdherent()
    {
        return $this->telPortableAdherent;
    }

    /**
     * Set mailAdherent
     *
     * @param string $mailAdherent
     *
     * @return Adherent
     */
    public function setMailAdherent($mailAdherent)
    {
        $this->mailAdherent = $mailAdherent;

        return $this;
    }

    /**
     * Get mailAdherent
     *
     * @return string
     */
    public function getMailAdherent()
    {
        return $this->mailAdherent;
    }

    /**
     * Set dateCreationAdherent
     *
     * @param \DateTime $dateCreationAdherent
     *
     * @return Adherent
     */
    public function setDateCreationAdherent($dateCreationAdherent)
    {
        $this->dateCreationAdherent = $dateCreationAdherent;

        return $this;
    }

    /**
     * Get dateCreationAdherent
     *
     * @return \DateTime
     */
    public function getDateCreationAdherent()
    {
        return $this->dateCreationAdherent;
    }

    /**
     * Set sexeAdherent
     *
     * @param boolean $sexeAdherent
     *
     * @return Adherent
     */
    public function setSexeAdherent($sexeAdherent)
    {
        $this->sexeAdherent = $sexeAdherent;

        return $this;
    }

    /**
     * Get sexeAdherent
     *
     * @return boolean
     */
    public function getSexeAdherent()
    {
        return $this->sexeAdherent;
    }

    /**
     * Set numeroAdherent
     *
     * @param integer $numeroAdherent
     *
     * @return Adherent
     */
    public function setNumeroAdherent($numeroAdherent)
    {
        $this->numeroAdherent = $numeroAdherent;

        return $this;
    }

    /**
     * Get numeroAdherent
     *
     * @return integer
     */
    public function getNumeroAdherent()
    {
        return $this->numeroAdherent;
    }

    /**
     * Set idFamille
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\FamilleAdherent $idFamille
     *
     * @return Adherent
     */
    public function setIdFamille(\AllocMaria\FrontOfficeBundle\Entity\FamilleAdherent $idFamille = null)
    {
        $this->idFamille = $idFamille;

        return $this;
    }

    /**
     * Get idFamille
     *
     * @return \AllocMaria\FrontOfficeBundle\Entity\FamilleAdherent
     */
    public function getIdFamille()
    {
        return $this->idFamille;
    }

    /**
     * Add idReferent
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\ReferentAdherent $idReferent
     *
     * @return Adherent
     */
    public function addIdReferent(\AllocMaria\FrontOfficeBundle\Entity\ReferentAdherent $idReferent)
    {
        $this->idReferent[] = $idReferent;

        return $this;
    }

    /**
     * Remove idReferent
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\ReferentAdherent $idReferent
     */
    public function removeIdReferent(\AllocMaria\FrontOfficeBundle\Entity\ReferentAdherent $idReferent)
    {
        $this->idReferent->removeElement($idReferent);
    }

    /**
     * Get idReferent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdReferent()
    {
        return $this->idReferent;
    }

    /**
     * Add idActivite
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\ActiviteSection $idActivite
     *
     * @return Adherent
     */
    public function addIdActivite(\AllocMaria\FrontOfficeBundle\Entity\ActiviteSection $idActivite)
    {
        $this->idActivite[] = $idActivite;

        return $this;
    }

    /**
     * Remove idActivite
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\ActiviteSection $idActivite
     */
    public function removeIdActivite(\AllocMaria\FrontOfficeBundle\Entity\ActiviteSection $idActivite)
    {
        $this->idActivite->removeElement($idActivite);
    }

    /**
     * Get idActivite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdActivite()
    {
        return $this->idActivite;
    }
}
