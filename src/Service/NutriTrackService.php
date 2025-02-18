<?php

namespace App\Service;

use App\Entity\Tracking;
use App\Repository\UserRepository;
use Cassandra\Date;

class NutriTrackService
{


    function calcul_calories($sexe, $poids, $taille, $age, $niveau_activite) {
        // Calcul du BMR en fonction du sexe
        if ($sexe == "homme") {
            $bmr = 88.362 + (13.397 * $poids) + (4.799 * $taille) - (5.677 * $age);
        } elseif ($sexe == "femme") {
            $bmr = 447.593 + (9.247 * $poids) + (3.098 * $taille) - (4.330 * $age);
        } else {
            return "Sexe non valide. Veuillez entrer 'homme' ou 'femme'.";
        }

        // Définir les facteurs d'activité selon l'entrée
        switch ($niveau_activite) {
            case 1:
                $facteur_activite = 1.2; // Sédentaire
                break;
            case 2:
                $facteur_activite = 1.375; // Activité légère
                break;
            case 3:
                $facteur_activite = 1.55; // Activité modérée
                break;
            case 4:
                $facteur_activite = 1.725; // Activité intense
                break;
            case 5:
                $facteur_activite = 1.9; // Activité très intense
                break;
            default:
                return "Niveau d'activité non valide. Choisissez entre 1 (sédentaire) et 5 (très intense).";
        }

        // Calcul des calories nécessaires
        $calories = $bmr * $facteur_activite;
        return round($calories);
    }



    public function addCalories(Tracking $tracking, $calories){
        $today = new \DateTime();
        $trackingDate = $tracking->getDate();
        if ($today->format("Y-m-d") != $trackingDate->format("Y-m-d")) {
            $tracking->setConsumedCalories(0);
        }
        $tracking->setConsumedCalories($calories);
        return $tracking;
    }

}