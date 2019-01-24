<?php

namespace AllocMaria\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackofficeController extends Controller
{
    public function accueilAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:accueil.html.twig');
    }

    public function BureauPresidenceAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:BureauPresidence.html.twig');
    }

    public function StatistiquesAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:Statistiques.html.twig');
    }

    public function ListeAdherentAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:ListeAdherent.html.twig');
    }

    public function TresorerieAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:Tresorerie.html.twig');
    }

    public function GestionUtilisateurAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:GestionUtilisateur.html.twig');
    }

    public function CreationUtilisateurAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:CreationUtilisateur.html.twig');
    }

    public function ListeUtilisateurAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:ListeUtilisateur.html.twig');
    }

    public function GestionSectionAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:GestionSection.html.twig');
    }

    public function SectionAdulteAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:SectionAdulte.html.twig');
    }

    public function SectionEnfantAction()
    {
        return $this->render('AllocMariaBackOfficeBundle:BackOffice:SectionEnfant.html.twig');
    }
}