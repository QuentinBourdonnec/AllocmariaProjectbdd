<?php

namespace AllocMaria\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AllocMaria\FrontOfficeBundle\Entity\UserBureauAssociation;
use AllocMaria\FrontOfficeBundle\Entity\Adherent;
use AllocMaria\FrontOfficeBundle\Entity\ActiviteSection;
use AllocMaria\FrontOfficeBundle\Entity\Section;
use AllocMaria\FrontOfficeBundle\Entity\TypeUser;
use AllocMaria\FrontOfficeBundle\Form\AdherentType;
use Symfony\Component\HttpFoundation\Session\Session;

class FrontofficeController extends Controller
{
    public function accueilAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        //Formulaire de connexion au bureau des sections
        $form = $this->createFormBuilder()
            ->add('identifiant_section', TextType::class)
            ->add('mdp_section', TextType::class)
            ->getForm();
        $form->handleRequest($request);

        //Formulaire de connexion au bureau des encaissement
        $form2 = $this->createFormBuilder()
            ->add('identifiant_encaissement', TextType::class)
            ->add('mdp_encaissement', TextType::class)
            ->getForm();
        $form2->handleRequest($request);

        //Si l'utilisateur à cliquer sur le bouton connexion pour accéder au bureau des sections
        if ($form->isSubmitted() && $form->isValid()) {
            echo "form1";
            //On récupère l'identifiant et le mot de passe
            $identifiant_section = $form["identifiant_section"]->getData();
            $mdp_section = $form["mdp_section"]->getData();

            $submit = $request->request->get('action');

            if ($submit == 'Connexion') {
                //On récupère les informations de l'utilisateur en question
                $query = $em->createQuery("SELECT user FROM AllocMariaFrontOfficeBundle:UserBureauAssociation user WHERE user.identifiantUser=:identifiant_section AND user.mdpUser=:mdp_section");
                $query->setParameters(array(
                    'identifiant_section'=> $identifiant_section,
                    'mdp_section'=> $mdp_section));
                $res=$query->getResult();

                if(count($res) != 0){
                    $libelle = $res[0]->getLibelleTypeUser()->getLibelleTypeUser();
                }
                else{
                    $libelle=NULL;
                }

                if($libelle === 'Responsable section'){

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

                    echo $libelle;
                    //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array("ress"=>$res));
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array('session'=> $_SESSION));

                    //return $this->redirectToRoute('espace_bureau_sections_alloc_maria_front_office_homepage',array("ress"=>$res));
                }
                elseif($libelle != NULL && $libelle != 'Responsable section'){
                    echo "nok";
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
                else{
                    echo "ok";
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
            }

        }
        elseif($form2->isSubmitted() && $form2->isValid()){
            echo "form2";
            //On récupère l'identifiant et le mot de passe
            $identifiant_encaissement = $form2["identifiant_encaissement"]->getData();
            $mdp_encaissement = $form2["mdp_encaissement"]->getData();

            $submit = $request->request->get('action');

            if ($submit == 'Connexion') {

                $query = $em->createQuery("SELECT user FROM AllocMariaFrontOfficeBundle:UserBureauAssociation user WHERE user.identifiantUser=:identifiant_encaissement AND user.mdpUser=:mdp_encaissement");
                $query->setParameters(array(
                    'identifiant_encaissement'=> $identifiant_encaissement,
                    'mdp_encaissement'=> $mdp_encaissement));
                $res=$query->getResult();

                if(count($res) != 0){
                    $libelle = $res[0]->getLibelleTypeUser()->getLibelleTypeUser();
                }
                else{
                    $libelle=NULL;
                }

                if($libelle === 'Encaissement'){
                    echo $libelle;
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauEncaissement:BureauEncaissement.html.twig');
                    //return $this->redirectToRoute('espace_bureau_encaissement_alloc_maria_front_office_homepage');
                }
                elseif($libelle != NULL && $libelle != 'Encaissement'){
                    echo "nok1";
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
                else{
                    echo "ok1";
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
            }
        }
        else

            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));

    }

    public function BureauSectionsAction()
    {


        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array('session'=> $_SESSION));
    }

    public function NouvelAdherentAction(Request $request)
    {
        $adherent = new Adherent();
        //On récupère le form
        $form = $this->get('form.factory')->create(AdherentType::class, $adherent);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            //$db = $this->getDoctrine()->getManager();
            /*$db->persist($adherent);
            $db->flush();*/
            return $this->redirectToRoute('espace_bureau_sections_nouvel_adhérent_mineur_alloc_maria_front_office_homepage');
            //$nom=$form['nomAdherent'];
            //return $this->redirectToRoute('espace_bureau_sections_nouvel_adhérent_mineur_alloc_maria_front_office_homepage',array("noms"=>$nom));
        }
        return $this->render("AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig", array("form" => $form->createView()));

        //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig');
    }

    public function NouvelAdherentMineurAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMineur.html.twig');
    }

    public function NouvelAdherentMajeurAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMajeur.html.twig');
    }

    public function ListeAdherentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()
            ->add('recherche', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recherche = $form["recherche"]->getData();
            $submit = $request->request->get('action');

            //Si le bouton qui a été appuyé est celui avec la valeur 'Toutes les villes'
            if ($submit == 'Recherche par nom') {
                $query = $em->createQuery("SELECT adherent FROM AllocMariaFrontOfficeBundle:Adherent adherent WHERE adherent.nomAdherent LIKE :recherche")->setParameter('recherche', '%' . $recherche . '%');
            }
            elseif ($submit == 'Recherche par prénom') {
                $query = $em->createQuery("SELECT adherent FROM AllocMariaFrontOfficeBundle:Adherent adherent WHERE adherent.prenomAdherent LIKE :recherche")->setParameter('recherche', '%' . $recherche . '%');
            }
            $res = $query->getResult();

            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig',array('session'=> $_SESSION, "adherents"=>$res, "form" => $form->createView()));
        }else
        {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AllocMariaFrontOfficeBundle:Adherent');

            $listAdverts = $repository->findAll();



            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig',array('session'=> $_SESSION, "adherents"=>$listAdverts, "form" => $form->createView(),));

        }

        /*$repository = $this

            ->getDoctrine()

            ->getManager()

            ->getRepository('AllocMariaFrontOfficeBundle:Adherent');


        $listAdverts = $repository->findAll();

        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig',array("adherents"=>$listAdverts));
*/

        //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig');

    }

    public function InscriptionAdherentActiviteAction($id)
    {

        $em = $this->getDoctrine()->getManager();


        // On récupère l'$id du trajet

        $advert = $em->getRepository('AllocMariaFrontOfficeBundle:Adherent')->find($id);


        if (null === $advert) {

            // On renvoit une page d'erreur si le trajet d'id ".$id." n'existe pas.
            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig');

        }

        $query2 = $em->createQuery("SELECT act FROM AllocMariaFrontOfficeBundle:ActiviteSection act WHERE act.idSection = 1");

        $listActivites = $query2->getResult();

        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:InscriptionAdherentActivite.html.twig', array(
            'activites'=> $listActivites,
            'details'  => $advert,


        ));


        //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:InscriptionAdherentActivite.html.twig');
    }

    public function MaSectionAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:MaSection.html.twig');
    }

    public function BureauEncaissementAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauEncaissement:BureauEncaissement.html.twig');
    }

    public function ValidationInscriptionAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauEncaissement:ValidationInscription.html.twig');
    }

    public function ReglementInscriptionAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauEncaissement:ReglementInscription.html.twig');
    }




}
