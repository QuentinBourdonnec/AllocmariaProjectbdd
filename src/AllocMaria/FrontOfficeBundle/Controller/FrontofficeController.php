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
use AllocMaria\FrontOfficeBundle\Form\AdherentType;
use Symfony\Component\HttpFoundation\Session\Session;

class FrontofficeController extends Controller
{
    public function accueilAction(Request $request)
    {

        // creates a task and gives it some dummy data for this example
        /*$task = new UserBureauAssociation();

        $form = $this->createFormBuilder($task)
            ->add('identifiantUser', TextType::class)
            ->add('mdpUser', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Connexion'])
            ->getForm();

        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig', [
            'form' => $form->createView(),
        ]);*/

        $em = $this->getDoctrine()->getManager();


        $form = $this->createFormBuilder()
            ->add('identifiant_section', TextType::class)
            ->add('mdp_section', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $identifiant_section = $form["identifiant_section"]->getData();
            $mdp_section = $form["mdp_section"]->getData();


            $submit = $request->request->get('action');

            //Si le bouton qui a été appuyé est celui avec la valeur 'Toutes les villes'
            if ($submit == 'Connexion') {
                //$query = $em->createQuery("SELECT user FROM AllocMariaFrontOfficeBundle:UserBureauAssociation user WHERE user.identifiantUser=:identifiant_section AND user.mdpUser=:mdp_section")->setParameter('identifiant_section', '%' . $identifiant_section . '%', 'mdp_section', '%' . $section . '%');
                //$query = $em->createQuery("SELECT user FROM AllocMariaFrontOfficeBundle:UserBureauAssociation user WHERE user.identifiantUser=:identifiant_section")->setParameter('identifiant_section', $identifiant_section);
                //$query1 = $em->createQuery("SELECT user FROM AllocMariaFrontOfficeBundle:UserBureauAssociation user WHERE user.mdpUser=:mdp_section")->setParameter('mdp_section', $section);
                //$query = $em->createQuery("SELECT user FROM AllocMariaFrontOfficeBundle:UserBureauAssociation user");

                $query = $em->createQuery("SELECT user FROM AllocMariaFrontOfficeBundle:UserBureauAssociation user WHERE user.identifiantUser=:identifiant_section AND user.mdpUser=:mdp_section");
                $query->setParameters(array(
                    'identifiant_section'=> $identifiant_section,
                    'mdp_section'=> $mdp_section));
                $res=$query->getResult();
                $prenom = $res[0]->getLibelleTypeUser()->getLibelleTypeUser();
                echo $prenom;

                $query2 = $em->createQuery("SELECT 'IDENTITY(user.libelleTypeUser)' from AllocMariaFrontOfficeBundle:UserBureauAssociation user where user.identifiantUser=:identifiant_section AND user.mdpUser=:mdp_section");
                $query2->setParameters(array(
                    'identifiant_section'=> $identifiant_section,
                    'mdp_section'=> $mdp_section));
                $res2=$query2->getResult();



                //$res1=$query1->getResult();

                //$res = isset($res) ? $res : NULL;
                //$res1 = isset($res1) ? $res1 : NULL;

                $test=1;
                if($prenom == 'Encaissement'){

                    //$_SESSION['prenom'] = $res[''];
                    //$res=1;
                    //return $this->redirectToRoute('espace_bureau_sections_alloc_maria_front_office_homepage');
                    //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("ress"=>$res, "form" => $form->createView()));


                    return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array("ress"=>$res));
                }
                else
                    return $this->redirectToRoute('espace_bureau_sections_ma_section_alloc_maria_front_office_homepage');
                    //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("form" => $form->createView(),));
                //$res = $query->getResult();
            }

            /*elseif ($submit == 'identifiant_section ') {
                $query = $em->createQuery("SELECT adherent FROM AllocMariaFrontOfficeBundle:Adherent adherent WHERE adherent.prenomAdherent LIKE :recherche")->setParameter('identifiant_section', '%' . $identifiant_section . '%');
            }*/


            //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig',array("adherents"=>$res, "form" => $form->createView()));
        }else
            $res = 0;
            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig',array("ress"=>$res, "form" => $form->createView()));




        //return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig');
    }

    public function BureauSectionsAction()
    {
        $ress = "";
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig',array("ress"=>$ress));
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

            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig',array("adherents"=>$res, "form" => $form->createView()));
        }else
        {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AllocMariaFrontOfficeBundle:Adherent');

            $listAdverts = $repository->findAll();



            return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig',array("adherents"=>$listAdverts, "form" => $form->createView(),));

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
