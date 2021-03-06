<?php

namespace AllocMaria\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use AllocMaria\FrontOfficeBundle\Entity\UserBureauAssociation;
use AllocMaria\FrontOfficeBundle\Entity\Adherent;
use AllocMaria\FrontOfficeBundle\Entity\ActiviteSection;
use AllocMaria\FrontOfficeBundle\Entity\Section;
use AllocMaria\FrontOfficeBundle\Entity\TypeUser;
use AllocMaria\FrontOfficeBundle\Entity\FamilleAdherent;
use AllocMaria\FrontOfficeBundle\Form\AdherentType;
use Symfony\Component\HttpFoundation\Session\Session;
use \Date;
use \DateInterval;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\ServerInfoAwareConnection;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\DriverManager;
use PDO;
use Doctrine\ORM\Query\bindValue;

class FrontofficeController extends Controller
{
    public function accueilAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        //Formulaire de connexion au bureau des sections
        $form = $this->createFormBuilder()
            ->add('identifiant_section', TextType::class)
            ->add('mdp_section', PasswordType::class)
            ->getForm();
        $form->handleRequest($request);

        //Formulaire de connexion au bureau des encaissement
        $form2 = $this->createFormBuilder()
            ->add('identifiant_encaissement', TextType::class)
            ->add('mdp_encaissement', PasswordType::class)
            ->getForm();
        $form2->handleRequest($request);

        //Si l'utilisateur à cliquer sur le bouton connexion pour accéder au bureau des sections
        if ($form->isSubmitted() && $form->isValid()) {
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
                    //On récupère les informations sur la section de l'utilisateur
                    $query2 = $em->createQuery("SELECT section FROM AllocMariaFrontOfficeBundle:Section section, AllocMariaFrontOfficeBundle:TypeUser typeuser, AllocMariaFrontOfficeBundle:UserBureauAssociation user WHERE typeuser.libelleTypeUser=:libelle and typeuser.idSection = section.idSection");
                    $query2->setParameters(array(
                        'libelle'=> $libelle));
                    $section=$query2->getResult();

                    $sec = $section[0]->getNomSection();


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
                    $_SESSION["nom_section"]=$sec;
                    $_SESSION['connected'] = true;
                    $_SESSION["id_section"] = $section[0]->getIdSection();

                    //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array("ress"=>$res));
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array('session'=> $_SESSION));

                    //return $this->redirectToRoute('espace_bureau_sections_alloc_maria_front_office_homepage',array("ress"=>$res));
                }
                elseif($libelle != NULL && $libelle == 'Encaissement'){
                    $this->addFlash('warning_encaissement', "Veuillez vous connecter sur l'accès encaissement.");
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
                elseif($libelle != NULL && $libelle == 'Administrateur'){
                    $this->addFlash('warning_administrateur', "Veuillez vous connecter sur l'espace administrateur.");
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
                else{
                    $this->addFlash('error1', "L'identifiant ou le mot de passe est incorrect");
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
            }

        }
        elseif($form2->isSubmitted() && $form2->isValid()){

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

                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauEncaissement:BureauEncaissement.html.twig');
                    //return $this->redirectToRoute('espace_bureau_encaissement_alloc_maria_front_office_homepage'); 
                }
                elseif($libelle != NULL && $libelle == 'Responsable section'){

                    $this->addFlash('warning_section', "Veuillez vous connecter sur l'accès du bureau des sections");
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
                elseif($libelle != NULL && $libelle == 'Administrateur'){

                    $this->addFlash('warning_administrateur', "Veuillez vous connecter sur l'espace administrateur.");
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
                else{

                    $this->addFlash('error2', "L'identifiant ou le mot de passe est incorrect");
                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));
                }
            }
        }
        else

            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(), "form2" => $form2->createView()));

    }

    public function BureauSectionsAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/

        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array('session'=> $_SESSION));
    }






    public function NouvelAdherentAction(Request $request)
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/
        $adherent = new Adherent();
        //On récupère le form
        $form = $this->get('form.factory')->create(AdherentType::class, $adherent);

        /*if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            //$db = $this->getDoctrine()->getManager();
            /*$db->persist($adherent);
            $db->flush();*/
            //return $this->redirectToRoute('espace_bureau_sections_nouvel_adhérent_mineur_alloc_maria_front_office_homepage');
            //$nom=$form['nomAdherent'];
            //return $this->redirectToRoute('espace_bureau_sections_nouvel_adhérent_mineur_alloc_maria_front_office_homepage',array("noms"=>$nom));
        /*}*/

        if ($request->isMethod('POST')) {
            /*Vérification des champs (expressions regulieres) */


            $form->handleRequest($request);
            $sexe = $form->get('sexeAdherent')->getData();
            $nom = $form->get('nomAdherent')->getData();
            $prenom = $form->get('prenomAdherent')->getData();
            $adresse = $form->get('adresseAdherent')->getData();
            $ville = $form->get('villeAdherent')->getData();
            $cp = $form->get('codePostalAdherent')->getData();
            $date_naissance = $form->get('dateNaissanceAdherent')->getData();
            echo $sexe;

            if ( preg_match ( "/^[a-zA-Z]+$/" , $nom ) )
            {
                $erreur = 1;
            }else{
                $this->addFlash('warning_nom', "Votre saisie nom est incorrecte");
                return $this->render("AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig", array("form" => $form->createView()));
            }

            if ( preg_match ( " /^[a-zA-Z]+$/ " , $prenom ) )
            {
                $erreur = 1;
            }else{
                $this->addFlash('warning_prenom', "Votre saisie prenom est incorrecte");
                return $this->render("AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig", array("form" => $form->createView()));
            }

            if ( preg_match ( "#[0-9]{0,3}(?:(?:[,. ]){1}[-a-zA-Zàâäéèêëïîôöùûüç]+)+#i" , $adresse ) )
            {
                $erreur = 1;
            }else{
                $this->addFlash('warning_adresse', "Votre saisie adresse est incorrecte");
                return $this->render("AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig", array("form" => $form->createView()));
            }

            if ( preg_match ( "/^(([0-8][0-9])|(9[0-5]))[0-9]{3}$/" , $cp ) )
            {
                $erreur = 1;
            }else{
                $this->addFlash('warning_cp', "Votre saisie code postal est incorrecte");
                return $this->render("AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig", array("form" => $form->createView()));
            }

            if ( preg_match ( "/^[a-zA-Z]+$/" , $ville ) )
            {
                $erreur = 1;
            }else{
                $this->addFlash('warning_ville', "Votre saisie ville est incorrecte");
                return $this->render("AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig", array("form" => $form->createView()));
            }

            if ($sexe == true){
                $_SESSION['sexeAdherent'] = "Homme";
            }
            else
                $_SESSION['sexeAdherent'] = "Femme";

            $_SESSION['nomAdherent'] = $nom;
            $_SESSION['prenomAdherent'] = $prenom;
            $_SESSION['adresseAdherent'] = $adresse;
            $_SESSION['villeAdherent'] = $ville;
            $_SESSION['codePostalAdherent'] = $cp;
            $_SESSION['dateNaissanceAdherent'] = $date_naissance->format('d/m/Y');
            $_SESSION['dateNaissanceAdherent1'] = $date_naissance->format('Y-m-d');

            //$date_aujourdhui = new Date();
            //$date_18 = $date_aujourdhui->sub(new DateInterval('P18Y'));
            $diff = (new \DateTime())->diff(new \DateTime($_SESSION['dateNaissanceAdherent']));
            $annee = $diff->y;

            if($annee >= 18){
                return $this->redirectToRoute('espace_bureau_sections_nouvel_adhérent_majeur_alloc_maria_front_office_homepage',array('session'=> $_SESSION));
                //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMajeur.html.twig',array('session'=> $_SESSION, "form2" => $form->createView()));
            }else{
                return $this->redirectToRoute('espace_bureau_sections_nouvel_adhérent_mineur_alloc_maria_front_office_homepage',array('session'=> $_SESSION));
                //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMineur.html.twig',array('session'=> $_SESSION));
            }
        }
        return $this->render("AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig", array("form" => $form->createView()));

        //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig');
    }






    public function NouvelAdherentMineurAction(Request $request)
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/

        $em = $this->getDoctrine()->getManager();

        //Formulaire d'information des personnes référentes aux mineurs
        $form = $this->createFormBuilder()
            ->add('nomReferent', TextType::class, ['attr' => ['placeholder' => 'Nom']])
            ->add('prenomReferent', TextType::class, ['attr' => ['placeholder' => 'Prénom']])
            ->add('telephoneReferent', TextType::class, ['required'   => false, 'attr' => ['placeholder' => 'Numéro domicile']])
            ->add('portableReferent', TextType::class, ['attr' => ['placeholder' => 'Numéro portable']])
            ->add('mailReferent', TextType::class, ['attr' => ['placeholder' => 'Mail']])
            ->add('adresseReferent', TextType::class, ['required'   => false, 'attr' => ['placeholder' => 'Adresse']])
            ->add('villeReferent', TextType::class, ['required'   => false, 'attr' => ['placeholder' => 'Ville']])
            ->add('codePostalReferent', TextType::class, ['required'   => false, 'attr' => ['placeholder' => 'Code postal']])
            ->add('nomReferent1', TextType::class, ['attr' => ['placeholder' => 'Nom']])
            ->add('prenomReferent1', TextType::class, ['attr' => ['placeholder' => 'Prénom']])
            ->add('telephoneReferent1', TextType::class, ['required'   => false, 'attr' => ['placeholder' => 'Numéro domicile']])
            ->add('portableReferent1', TextType::class, ['attr' => ['placeholder' => 'Numéro portable']])
            ->add('mailReferent1', TextType::class, ['attr' => ['placeholder' => 'Mail']])
            ->add('adresseReferent1', TextType::class, ['required'   => false, 'attr' => ['placeholder' => 'Adresse']])
            ->add('villeReferent1', TextType::class, ['required'   => false, 'attr' => ['placeholder' => 'Ville']])
            ->add('codePostalReferent1', TextType::class, ['required'   => false, 'attr' => ['placeholder' => 'Code postal']])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted()) {

            /* On vérifie si la case d'acceptation de l'utilisation des informations à été cochée */
            if(isset($_POST['conditions'])){
                $res=1;
            }
            else{
                $this->addFlash('warning_condition', "Vous n'avez pas accepté l'utilisation de vos informations");
                return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMineur.html.twig', array('session'=> $_SESSION, "form" => $form->createView()));
            }


            $nom = $form->get('nomReferent')->getData();
            $prenom = $form->get('prenomReferent')->getData();
            $telephone = $form->get('telephoneReferent')->getData();
            $portable = $form->get('portableReferent')->getData();
            $mail = $form->get('mailReferent')->getData();
            $adresse = $form->get('adresseReferent')->getData();
            $ville = $form->get('villeReferent')->getData();
            $codepostal = $form->get('codePostalReferent')->getData();
            $nom1 = $form->get('nomReferent1')->getData();
            $prenom1 = $form->get('prenomReferent1')->getData();
            $telephone1 = $form->get('telephoneReferent1')->getData();
            $portable1 = $form->get('portableReferent1')->getData();
            $mail1 = $form->get('mailReferent1')->getData();
            $adresse1 = $form->get('adresseReferent1')->getData();
            $ville1 = $form->get('villeReferent1')->getData();
            $codepostal1 = $form->get('codePostalReferent1')->getData();

            if(!isset($adresse) && !isset($ville) && !isset($codepostal)){
                $adresse = $_SESSION['adresseAdherent'];
                $ville = $_SESSION['villeAdherent'];
                $codepostal = $_SESSION['codePostalAdherent'];
            }

            if(!isset($adresse1) && !isset($ville1) && !isset($codepostal1)){
                $adresse1 = $_SESSION['adresseAdherent'];
                $ville1 = $_SESSION['villeAdherent'];
                $codepostal1 = $_SESSION['codePostalAdherent'];
            }

            if(!isset($telephone)){
                $telephone = 0;
            }


            /* On veut récupérer un id non utilisé */
            $query = $em->createQuery("SELECT adherent.idAdherent FROM AllocMariaFrontOfficeBundle:Adherent adherent");
            $res=$query->getResult();
            $nb_id = count($res)+1;

            /* On récupère le sexe de l'adhérent */
            if($_SESSION['sexeAdherent'] == "Homme"){
                $sexe = 1;
            }else{
                $sexe =0;
            }

            $date_du_jour = date("Y-m-d");

            /* On créer le nouvel adhérent */
            $sql = 'INSERT INTO adherent (id_adherent, nom_adherent, prenom_adherent, date_naissance_adherent, adresse_adherent, code_postal_adherent, ville_adherent, date_creation_adherent, sexe_adherent, id_famille) VALUES ("'.$nb_id.'", "'.$_SESSION['nomAdherent'].'", "'.$_SESSION['prenomAdherent'].'", "'.$_SESSION['dateNaissanceAdherent1'].'", "'.$_SESSION['adresseAdherent'].'", "'.$_SESSION['codePostalAdherent'].'", "'.$_SESSION['villeAdherent'].'", "'.$date_du_jour.'",  "'.$sexe.'", 1)';
            $stmt = $em->getConnection()->prepare($sql);
            $result = $stmt->execute();

            /* On veut récupérer un id non utilisé */
            $query = $em->createQuery("SELECT referent.idReferent FROM AllocMariaFrontOfficeBundle:ReferentAdherent referent");
            $res=$query->getResult();
            $nb_id1 = count($res)+1;
            $nb_id2 = count($res)+2;

            /* On créer les nouveaux referents */
            $sql = 'INSERT INTO referent_adherent (id_referent, Nom_referent, prenom_referent, telephone_referent, portable_referent, mail_referent, adresse_referent, ville_referent, code_postal_referent) VALUES ("'.$nb_id1.'", "'.$nom.'", "'.$prenom.'", "'.$telephone.'", "'.$portable.'", "'.$mail.'", "'.$adresse.'", "'.$ville.'",  "'.$codepostal.'")';
            $stmt = $em->getConnection()->prepare($sql);
            $result = $stmt->execute();

            /* On créer les nouveaux referents */
            $sql = 'INSERT INTO referent_adherent (id_referent, Nom_referent, prenom_referent, telephone_referent, portable_referent, mail_referent, adresse_referent, ville_referent, code_postal_referent) VALUES ("'.$nb_id2.'", "'.$nom1.'", "'.$prenom1.'", "'.$telephone1.'", "'.$portable1.'", "'.$mail1.'", "'.$adresse1.'", "'.$ville1.'",  "'.$codepostal1.'")';
            $stmt = $em->getConnection()->prepare($sql);
            $result = $stmt->execute();


            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array('session'=> $_SESSION));

        }

        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMineur.html.twig',array('session'=> $_SESSION, "form" => $form->createView()));
    }


    public function NouvelAdherentMajeurAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $adherent = new Adherent();

        $form = $this->get('form.factory')->create(AdherentType::class, $adherent);
        $form->handleRequest($request);


        if($form->isSubmitted()){

            $mail = $form->get('mailAdherent')->getData();
            $tel = $form->get('telPortableAdherent')->getData();
            $_SESSION['mailAdherent'] = $mail;
            $_SESSION['telPortableAdherent'] = $tel;
            $_SESSION['idFamille'] = "1";

            /* On veut récupérer un id non utilisé */
            $query = $em->createQuery("SELECT adherent.idAdherent FROM AllocMariaFrontOfficeBundle:Adherent adherent");
            $res=$query->getResult();
            $nb_id = count($res)+1;

            /* On récupère le sexe de l'adhérent */
            if($_SESSION['sexeAdherent'] == "Homme"){
                $sexe = 1;
            }else{
                $sexe =0;
            }

            $date_du_jour = date("Y-m-d");


            $sql = 'INSERT INTO adherent (id_adherent, nom_adherent, prenom_adherent, date_naissance_adherent, adresse_adherent, code_postal_adherent, ville_adherent, tel_portable_adherent, mail_adherent, date_creation_adherent, sexe_adherent, id_famille) VALUES ("'.$nb_id.'", "'.$_SESSION['nomAdherent'].'", "'.$_SESSION['prenomAdherent'].'", "'.$_SESSION['dateNaissanceAdherent1'].'", "'.$_SESSION['adresseAdherent'].'", "'.$_SESSION['codePostalAdherent'].'", "'.$_SESSION['villeAdherent'].'", "'.$_SESSION['telPortableAdherent'].'", "'.$_SESSION['mailAdherent'].'", "'.$date_du_jour.'",  "'.$sexe.'", 1)';
            $stmt = $em->getConnection()->prepare($sql);
            $result = $stmt->execute();


            /* On vérifie si la case d'acceptation de l'utilisation des informations à été cochée */
            if(isset($_POST['conditions'])){
                $res=1;
            }
            else{
                $this->addFlash('warning_condition', "Vous n'avez pas accepté l'utilisation de vos informations");
                return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMajeur.html.twig', array('session'=> $_SESSION, "form" => $form->createView()));
            }


            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array('session'=> $_SESSION));
        }
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMajeur.html.twig', array('session'=> $_SESSION, "form" => $form->createView()));
    }





    public function ListeAdherentAction(Request $request)
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/
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
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/
        $em = $this->getDoctrine()->getManager();


        // On récupère l'$id du trajet

        $advert = $em->getRepository('AllocMariaFrontOfficeBundle:Adherent')->find($id);


        if (null === $advert) {

            // On renvoit une page d'erreur si le trajet d'id ".$id." n'existe pas.
            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig');

        }

        $query2 = $em->createQuery("SELECT act FROM AllocMariaFrontOfficeBundle:ActiviteSection act WHERE act.idSection =1");
        //$query2 = $em->createQuery("SELECT act FROM AllocMariaFrontOfficeBundle:ActiviteSection act WHERE act.idSection =:id");
        /*$query2->setParameters(array(
            'identifiant_section'=> $_SESSION["id_section"]));*/

        $listActivites = $query2->getResult();

        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:InscriptionAdherentActivite.html.twig', array(
            'activites'=> $listActivites,
            'details'  => $advert,
            'session'=> $_SESSION

        ));


        //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:InscriptionAdherentActivite.html.twig');
    }

    public function MaSectionAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:MaSection.html.twig',array('session'=> $_SESSION));
    }

    public function BureauEncaissementAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauEncaissement:BureauEncaissement.html.twig');
    }

    public function ValidationInscriptionAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauEncaissement:ValidationInscription.html.twig');
    }

    public function ReglementInscriptionAction()
    {
        /*if(empty($_POST)){
            return $this->redirectToRoute("accueil_alloc_maria_front_office_homepage");
        }*/
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauEncaissement:ReglementInscription.html.twig');
    }




}
