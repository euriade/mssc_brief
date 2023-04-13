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
            case 'À valider':
                return 'info';
            case 'À compléter':
                return 'danger';
            case '\'validé\'':
                return 'success';
            case 'En cours':
                return 'warning';
            case 'Terminé':
                return 'dark';
        }
    }
}
