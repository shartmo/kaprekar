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
        $tab = $this->tableau();

        $nombre = 0;

        $liste = "";

        $tabnombre_ops = $this->verif();

        for ($i = 0; $i <  count($tab); $i++) {
            if($tabnombre_ops[$i]<= 7){
                $nombre ++;
            $liste .= $tab[$i] . '(' . $tabnombre_ops[$i] . ') ';
            }
        }
        return $this->render('calculs/index.html.twig', [
            'liste' => $liste, 'nombre' => $nombre
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

    private function verif()
    {
        $tabnombres = $this->tableau();

        $tabnombreoperations = array();

        for ($i = 0; $i < count($tabnombres); $i++) {
            $chain = $tabnombres[$i];
            $tabnombreoperations[$i] = 1;

            for ($y = 1; $y <= 7; $y++) {

                $tabsort = str_split($chain);
                
                rsort($tabsort);
                $chain_desc=implode($tabsort);

                sort($tabsort);

                $chain_mont=implode($tabsort);

                $resultat = $chain_desc - $chain_mont;
                if ($resultat <> 6174) {
                    $tabnombreoperations[$i]++;
                    $chain = $resultat;
                }
            }
        }
        return $tabnombreoperations;
    }
}
