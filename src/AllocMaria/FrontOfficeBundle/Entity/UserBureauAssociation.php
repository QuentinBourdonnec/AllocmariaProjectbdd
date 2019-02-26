<?php

namespace AllocMaria\FrontOfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserBureauAssociation
 *
 * @ORM\Table(name="user_bureau_association", indexes={@ORM\Index(name="FK_user_bureau_association_libelle_type_user", columns={"libelle_type_user"})})
 * @ORM\Entity
 */
class UserBureauAssociation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_user", type="string", length=25, nullable=false)
     */
    private $nomUser;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_user", type="string", length=25, nullable=false)
     */
    private $prenomUser;

    /**
     * @var string
     *
     * @ORM\Column(name="identifiant_user", type="string", length=10, nullable=false)
     */
    private $identifiantUser;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp_user", type="string", length=40, nullable=false)
     */
    private $mdpUser;

    /**
     * @var \TypeUser
     *
     * @ORM\ManyToOne(targetEntity="TypeUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="libelle_type_user", referencedColumnName="libelle_type_user")
     * })
     */
    private $libelleTypeUser;



    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set nomUser
     *
     * @param string $nomUser
     *
     * @return UserBureauAssociation
     */
    public function setNomUser($nomUser)
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    /**
     * Get nomUser
     *
     * @return string
     */
    public function getNomUser()
    {
        return $this->nomUser;
    }

    /**
     * Set prenomUser
     *
     * @param string $prenomUser
     *
     * @return UserBureauAssociation
     */
    public function setPrenomUser($prenomUser)
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    /**
     * Get prenomUser
     *
     * @return string
     */
    public function getPrenomUser()
    {
        return $this->prenomUser;
    }

    /**
     * Set identifiantUser
     *
     * @param string $identifiantUser
     *
     * @return UserBureauAssociation
     */
    public function setIdentifiantUser($identifiantUser)
    {
        $this->identifiantUser = $identifiantUser;

        return $this;
    }

    /**
     * Get identifiantUser
     *
     * @return string
     */
    public function getIdentifiantUser()
    {
        return $this->identifiantUser;
    }

    /**
     * Set mdpUser
     *
     * @param string $mdpUser
     *
     * @return UserBureauAssociation
     */
    public function setMdpUser($mdpUser)
    {
        $this->mdpUser = $mdpUser;

        return $this;
    }

    /**
     * Get mdpUser
     *
     * @return string
     */
    public function getMdpUser()
    {
        return $this->mdpUser;
    }

    /**
     * Set libelleTypeUser
     *
     * @param \AllocMaria\FrontOfficeBundle\Entity\TypeUser $libelleTypeUser
     *
     * @return UserBureauAssociation
     */
    public function setLibelleTypeUser(\AllocMaria\FrontOfficeBundle\Entity\TypeUser $libelleTypeUser = null)
    {
        $this->libelleTypeUser = $libelleTypeUser;

        return $this;
    }

    /**
     * Get libelleTypeUser
     *
     * @return \AllocMaria\FrontOfficeBundle\Entity\TypeUser
     */
    public function getLibelleTypeUser()
    {
        return $this->libelleTypeUser;
    }
}
