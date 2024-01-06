<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function index(): Response
    {
        $nummoiscourant = $this->moisencours();
        $nommoisencours = $this->NomDuMois($nummoiscourant);
        $numanencours = $this->anencours();
        $nombrejours = $this->nombrejoursmois($nummoiscourant, $numanencours);
        $tabjoursemaine = $this->tabJourSemaine($nummoiscourant, $numanencours);

        return $this->render('planning/index.html.twig', [
            'moisencours' => $nommoisencours, 'nombrejoursmois' =>  $nombrejours, 'an' => $numanencours, 'tabjour' => $tabjoursemaine
        ]);
    }


    private function jdepaques(int $mois = null, int $an = null)
    {

        $easter_date = date("M-d-Y", easter_date($an));

        return $easter_date;
    }

    private function anencours()
    {
        $an_en_cours = date("Y");
        return $an_en_cours;
    }

    private function moisencours()
    {
        $mois_en_cours = date("m");
        return $mois_en_cours;
    }

    private function nombrejoursmois(int $mois = null, int $annee = null)
    {
        $nombrejours = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
        return $nombrejours;
    }

    private function tabJourSemaine(int $Mois = null, int $Annee = null)
    {
        $Tab = array("LU", "MA", "ME", "JE", "VE", "SA", "DI");

        $longueurmois = $this->nombrejoursmois($Mois, $Annee);
        for ($i = 1; $i <= $longueurmois; $i++) {
            $JourSemaine = date("N", mktime(0, 0, 0, $Mois, $i, $Annee)); // numéro du jour de la semaine
            $tabJoursSemaine[$i] = $Tab[$JourSemaine - 1];
        }
        return $tabJoursSemaine;
    }

    private function NomDuMois(int $mois = null)
    {
        $tab_mois = array(
            1 => "janvier", 2 => "février", 3 => "mars", 4 => "avril",
            5 => "mai", 6 => "juin", 7 => "juillet", 8 => "août",
            9 => "septembre", 10 => "octobre",  11 => "novembre",
            12 => "décembre"
        );
        return $tab_mois[$mois];
    }
}
