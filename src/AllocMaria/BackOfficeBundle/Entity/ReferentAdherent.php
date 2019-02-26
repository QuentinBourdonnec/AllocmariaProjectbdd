<?php

namespace AllocMaria\BackOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReferentAdherent
 *
 * @ORM\Table(name="referent_adherent")
 * @ORM\Entity
 */
class ReferentAdherent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_referent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReferent;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_referent", type="string", length=25, nullable=false)
     */
    private $nomReferent;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_referent", type="string", length=25, nullable=false)
     */
    private $prenomReferent;

    /**
     * @var integer
     *
     * @ORM\Column(name="telephone_referent", type="integer", nullable=true)
     */
    private $telephoneReferent;

    /**
     * @var integer
     *
     * @ORM\Column(name="portable_referent", type="integer", nullable=true)
     */
    private $portableReferent;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_referent", type="string", length=40, nullable=false)
     */
    private $mailReferent;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_referent", type="string", length=40, nullable=false)
     */
    private $adresseReferent;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_referent", type="string", length=25, nullable=false)
     */
    private $villeReferent;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_postal_referent", type="integer", nullable=false)
     */
    private $codePostalReferent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Adherent", mappedBy="idReferent")
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
     * Get idReferent
     *
     * @return integer
     */
    public function getIdReferent()
    {
        return $this->idReferent;
    }

    /**
     * Set nomReferent
     *
     * @param string $nomReferent
     *
     * @return ReferentAdherent
     */
    public function setNomReferent($nomReferent)
    {
        $this->nomReferent = $nomReferent;

        return $this;
    }

    /**
     * Get nomReferent
     *
     * @return string
     */
    public function getNomReferent()
    {
        return $this->nomReferent;
    }

    /**
     * Set prenomReferent
     *
     * @param string $prenomReferent
     *
     * @return ReferentAdherent
     */
    public function setPrenomReferent($prenomReferent)
    {
        $this->prenomReferent = $prenomReferent;

        return $this;
    }

    /**
     * Get prenomReferent
     *
     * @return string
     */
    public function getPrenomReferent()
    {
        return $this->prenomReferent;
    }

    /**
     * Set telephoneReferent
     *
     * @param integer $telephoneReferent
     *
     * @return ReferentAdherent
     */
    public function setTelephoneReferent($telephoneReferent)
    {
        $this->telephoneReferent = $telephoneReferent;

        return $this;
    }

    /**
     * Get telephoneReferent
     *
     * @return integer
     */
    public function getTelephoneReferent()
    {
        return $this->telephoneReferent;
    }

    /**
     * Set portableReferent
     *
     * @param integer $portableReferent
     *
     * @return ReferentAdherent
     */
    public function setPortableReferent($portableReferent)
    {
        $this->portableReferent = $portableReferent;

        return $this;
    }

    /**
     * Get portableReferent
     *
     * @return integer
     */
    public function getPortableReferent()
    {
        return $this->portableReferent;
    }

    /**
     * Set mailReferent
     *
     * @param string $mailReferent
     *
     * @return ReferentAdherent
     */
    public function setMailReferent($mailReferent)
    {
        $this->mailReferent = $mailReferent;

        return $this;
    }

    /**
     * Get mailReferent
     *
     * @return string
     */
    public function getMailReferent()
    {
        return $this->mailReferent;
    }

    /**
     * Set adresseReferent
     *
     * @param string $adresseReferent
     *
     * @return ReferentAdherent
     */
    public function setAdresseReferent($adresseReferent)
    {
        $this->adresseReferent = $adresseReferent;

        return $this;
    }

    /**
     * Get adresseReferent
     *
     * @return string
     */
    public function getAdresseReferent()
    {
        return $this->adresseReferent;
    }

    /**
     * Set villeReferent
     *
     * @param string $villeReferent
     *
     * @return ReferentAdherent
     */
    public function setVilleReferent($villeReferent)
    {
        $this->villeReferent = $villeReferent;

        return $this;
    }

    /**
     * Get villeReferent
     *
     * @return string
     */
    public function getVilleReferent()
    {
        return $this->villeReferent;
    }

    /**
     * Set codePostalReferent
     *
     * @param integer $codePostalReferent
     *
     * @return ReferentAdherent
     */
    public function setCodePostalReferent($codePostalReferent)
    {
        $this->codePostalReferent = $codePostalReferent;

        return $this;
    }

    /**
     * Get codePostalReferent
     *
     * @return integer
     */
    public function getCodePostalReferent()
    {
        return $this->codePostalReferent;
    }

    /**
     * Add idAdherent
     *
     * @param \AllocMaria\BackOfficeBundle\Entity\Adherent $idAdherent
     *
     * @return ReferentAdherent
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
