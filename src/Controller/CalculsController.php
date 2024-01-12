<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculsController extends AbstractController
{
    #[Route('/calculs', name: 'app_calculs')]
    public function index(): Response
    {
        $tabreturn7 = $this->nombres_maxi(7);
        $liste7 = $tabreturn7[0];
        $nombre7 = $tabreturn7[1];

        $tabreturn1 = $this->nombres_maxi(1);
        $liste1 = $tabreturn1[0];
        $nombre1 = $tabreturn1[1];

        $tab_nombres_uniques7 = $this->combinaisons_uniques(7);
        $liste_nombres_uniques7 = $tab_nombres_uniques7[0];
        $nombres_uniques7 = $tab_nombres_uniques7[1];

        $tab_nombres_uniques1 = $this->combinaisons_uniques(1);
        $liste_nombres_uniques1 = $tab_nombres_uniques1[0];
        $nombres_uniques1 = $tab_nombres_uniques1[1];



        return $this->render('calculs/index.html.twig', [
            'liste' => $liste7,
            'liste_une_fois' => $liste1,
            'nombre' => $nombre7,
            'nombre_une_fois' => $nombre1,
            'nombres_uniques7' => $nombres_uniques7,
            'liste_nombres_uniques7' => $liste_nombres_uniques7,
            'nombres_uniques1' => $nombres_uniques1,
            'liste_nombres_uniques1' => $liste_nombres_uniques1,
        ]);
    }
    private function tableau()
    {
        $tabnombres = array();

        for ($i = 1000; $i <= 9999; $i++) {
            $chain = $i;
            $tabnombres[] = $chain;
        }
        return $tabnombres;
    }

    private function verif(int $profondeur)
    {
        $tabnombres = $this->tableau();

        $tabnombreoperations = array();

        for ($i = 0; $i < count($tabnombres); $i++) {
            $chain = $tabnombres[$i];
            $tabnombreoperations[$i] = 1;

            for ($y = 1; $y <= $profondeur; $y++) { // au-delà de 7, ce n'est pas nécessaire...

                $tabsort = str_split($chain);

                rsort($tabsort);
                $chain_desc = implode($tabsort);

                sort($tabsort);

                $chain_mont = implode($tabsort);

                $resultat = $chain_desc - $chain_mont;
                if ($resultat <> 6174) {
                    $tabnombreoperations[$i]++;
                    $chain = $resultat;
                }
            }
        }
        return $tabnombreoperations;
    }

    private function nombres_maxi(int $profondeur)
    {
        $tab = $this->tableau();
        $nombre = 0;
        $liste = "";
        $tabnombre_ops = $this->verif($profondeur);
        for ($i = 0; $i <  count($tab); $i++) {

            if ($tabnombre_ops[$i] <= $profondeur) {
                $nombre++;
                $liste .= $tab[$i] . '(' . $tabnombre_ops[$i] . ') ';
            }
        }

        $tabreturn[0] = $liste;
        $tabreturn[1] = $nombre;
        return $tabreturn;
    }

    private function tab_nombres_maxi(int $profondeur)
    {
        $tab = $this->tableau();

        $tabreturn = array();

        $tabnombre_ops = $this->verif($profondeur);
        for ($i = 0; $i <  count($tab); $i++) {
            if ($tabnombre_ops[$i] <= $profondeur) {

                $tabreturn[] = $tab[$i];
            }
        }


        return $tabreturn;
    }


    private function combinaisons_uniques(int $profondeur)
    {

        $tab = $this->tab_nombres_maxi($profondeur);

        $tab2 = array();

        for ($i = 0; $i < count($tab); $i++) {

            $chain = $tab[$i];

            $tabsort = array();

            $tabsort = str_split($chain);

            rsort($tabsort);

            $chain_desc = implode($tabsort);

            if (!in_array($chain_desc, $tab2)) {

                $tab2[] = $chain_desc;
            }
        }


        $total = count($tab2);
        $liste = "";
        sort($tab2);
        for ($i = 0; $i < count($tab2); $i++) {

            $liste .= $tab2[$i] . ' ';
        }

        $tabreturn[0] = $liste;
        $tabreturn[1] = $total;

        return $tabreturn;
    }
}
