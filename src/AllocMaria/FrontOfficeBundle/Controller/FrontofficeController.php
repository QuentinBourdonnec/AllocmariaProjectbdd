<?php

namespace AllocMaria\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class FrontofficeController extends Controller
{
    public function accueilAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice:accueil.html.twig');
    }

    public function BureauSectionsAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:BureauSections.html.twig');
    }

    public function NouvelAdherentAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherent.html.twig');
    }

    public function NouvelAdherentMineurAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMineur.html.twig');
    }

    public function NouvelAdherentMajeurAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:NouvelAdherentMajeur.html.twig');
    }

    public function ListeAdherentAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:ListeAdherent.html.twig');
    }

    public function InscriptionAdherentActiviteAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:FrontOffice\BureauDesSections:InscriptionAdherentActivite.html.twig');
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
