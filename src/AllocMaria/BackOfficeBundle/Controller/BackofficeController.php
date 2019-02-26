<?php

namespace AllocMaria\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;
use AllocMaria\BackOfficeBundle\Entity\Adherent;
use AllocMaria\BackOfficeBundle\Entity\FamilleAdherent;
use AllocMaria\BackOfficeBundle\Entity\UserBureauAssociation;
use AllocMaria\BackOfficeBundle\Entity\Section;

class BackofficeController extends Controller
{
    public function accueilAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        //Formulaire de connexion au bureau des sections
        $form = $this->createFormBuilder()
            ->add('identifiant_administration', TextType::class)
            ->add('mdp_administration', TextType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //On récupère l'identifiant et le mot de passe
            $identifiant_administration = $form["identifiant_administration"]->getData();
            $mdp_administration = $form["mdp_administration"]->getData();

            $submit = $request->request->get('action');

            if ($submit == 'Connexion') {
                //On récupère les informations de l'utilisateur en question
                $query = $em->createQuery("SELECT user FROM AllocMariaFrontOfficeBundle:UserBureauAssociation user WHERE user.identifiantUser=:identifiant_administration AND user.mdpUser=:mdp_administration");
                $query->setParameters(array(
                    'identifiant_administration'=> $identifiant_administration,
                    'mdp_administration'=> $mdp_administration));
                $res=$query->getResult();

                if(count($res) != 0){
                    $libelle = $res[0]->getLibelleTypeUser()->getLibelleTypeUser();
                }
                else{
                    $libelle=NULL;
                }

                if($libelle === 'Administrateur'){

                    //Gestion de la session
                    if(!isset($_SESSION))
                    {
                        session_start();
                    }
                    $_SESSION["id_user"]=$res[0]->getIdUser();
                    $_SESSION["nom_user"]=$res[0]->getNomUser();
                    $_SESSION["prenom_user"]=$res[0]->getPrenomUser();
                    $_SESSION["identifiant_user"]=$res[0]->getIdentifiantUser();
                    $_SESSION["mdp_user"]=$res[0]->getMdpUser();
                    $_SESSION["libelle_activite_user"]=$libelle;
                    //$_SESSION["nom_section"]=$res[0]->getLibelleTypeUser()->getLibelleTypeUser();
                    $_SESSION['connected'] = true;


                    //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array("ress"=>$res));
                    return $this->render('AllocMariaBackOfficeBundle:BackOffice:BureauPresidence.html.twig',array('session'=> $_SESSION));

                    //return $this->redirectToRoute('espace_bureau_sections_alloc_maria_front_office_homepage',array("ress"=>$res));
                }
                elseif($libelle != NULL && $libelle != 'Administrateur'){

                    //$this->addFlash('success', 'Merci de vous connecter dans lespace connexion des encaissement');
                    return $this->render('AllocMariaBackOfficeBundle:BackOffice:accueil.html.twig',array("form" => $form->createView()));
                }
                else{

                    return $this->render('AllocMariaBackOfficeBundle:BackOffice:accueil.html.twig',array("form" => $form->createView()));
                }
            }

        }else

            return $this->render('AllocMariaBackOfficeBundle:BackOffice:accueil.html.twig',array("form" => $form->createView()));



        //return $this->render('AllocMariaBackOfficeBundle:BackOffice:accueil.html.twig');
    }

    public function BureauPresidenceAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:BureauPresidence.html.twig',array('session'=> $_SESSION));
    }

    public function StatistiquesAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/


        /*$em = $this->getDoctrine()->getManager();

        $nb_adherent = $em->createQuery("SELECT count(adherent) FROM AllocMariaBackOfficeBundle:Adherent adherent ");
        $nb_adherents=$nb_adherent->getSingleResult();*/


        $db = $this->getDoctrine()->getManager();

        $nb_adherents = "SELECT COUNT(DISTINCT adherent) AS total_adherent FROM AllocMariaBackOfficeBundle:Adherent adherent";
        $total_adherent = $db->createQuery($nb_adherents)->getSingleScalarResult();

        $nb_familles = "SELECT COUNT(DISTINCT famille) AS total_famille FROM AllocMariaBackOfficeBundle:FamilleAdherent famille";
        $total_famille = $db->createQuery($nb_familles)->getSingleScalarResult();

        $nb_sections = "SELECT COUNT(DISTINCT section) AS total_section FROM AllocMariaBackOfficeBundle:Section section";
        $total_section = $db->createQuery($nb_sections)->getSingleScalarResult();

        $db->flush();

        return $this->render('AllocMariaBackOfficeBundle:BackOffice:Statistiques.html.twig',array('nb_section'=>$total_section, 'nb_adherents'=>$total_adherent, 'nb_famille'=>$total_famille, 'session'=> $_SESSION));
    }

    public function ListeAdherentAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/


        $em = $this->getDoctrine()->getManager();

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AllocMariaFrontOfficeBundle:Adherent');

        $listAdherent = $repository->findAll();

        $db = $this->getDoctrine()->getManager();

        $nb_adherents = "SELECT COUNT(DISTINCT adherent) AS total_adherent FROM AllocMariaBackOfficeBundle:Adherent adherent";
        $total_adherent = $db->createQuery($nb_adherents)->getSingleScalarResult();
        $db->flush();


        return $this->render('AllocMariaBackOfficeBundle:BackOffice:ListeAdherent.html.twig',array('session'=> $_SESSION, 'nb_adherents'=>$total_adherent, "adherents"=>$listAdherent));

        //return $this->render('AllocMariaBackOfficeBundle:BackOffice:ListeAdherent.html.twig',array('session'=> $_SESSION));
    }

    public function TresorerieAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/

        return $this->render('AllocMariaBackOfficeBundle:BackOffice:Tresorerie.html.twig',array('session'=> $_SESSION));
    }

    public function GestionUtilisateurAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/

        return $this->render('AllocMariaBackOfficeBundle:BackOffice:GestionUtilisateur.html.twig',array('session'=> $_SESSION));
    }

    public function CreationUtilisateurAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/

        return $this->render('AllocMariaBackOfficeBundle:BackOffice:CreationUtilisateur.html.twig',array('session'=> $_SESSION));
    }

    public function ListeUtilisateurAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AllocMariaBackOfficeBundle:UserBureauAssociation');

        $listUsers = $repository->findAll();

        $db = $this->getDoctrine()->getManager();

        $nb_users = "SELECT COUNT(DISTINCT user) AS total_users FROM AllocMariaBackOfficeBundle:UserBureauAssociation user";
        $total_users = $db->createQuery($nb_users)->getSingleScalarResult();
        $db->flush();

        return $this->render('AllocMariaBackOfficeBundle:BackOffice:ListeUtilisateur.html.twig',array('nb_users'=>$total_users, 'users'=>$listUsers, 'session'=> $_SESSION));
    }

    public function GestionSectionAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/

        return $this->render('AllocMariaBackOfficeBundle:BackOffice:GestionSection.html.twig',array('session'=> $_SESSION));
    }

    public function SectionAdulteAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/

        return $this->render('AllocMariaBackOfficeBundle:BackOffice:SectionAdulte.html.twig',array('session'=> $_SESSION));
    }

    public function SectionEnfantAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_back_office_homepage");
        }*/
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:SectionEnfant.html.twig',array('session'=> $_SESSION));
    }
}