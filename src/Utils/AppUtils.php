<?php

namespace App\Utils;

class AppUtils
{
    // Change la couleur du badge Bootstrap selon la donnée récupérée
    public static function getBadgeColor($data)
    {
        switch ($data) {
            case 'Nouveau':
                return 'primary';
                break;
            case 'À valider':
                return 'info';
                break;
            case 'À compléter':
                return 'danger';
                break;
            case 'Validé':
                return 'success';
                break;
            case 'En cours':
                return 'warning';
                break;
            case 'Terminé':
                return 'dark';
                break;
        }
    }
}
