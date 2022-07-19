<?php
namespace App\Models;
use App\Core\Model;
class UMModel extends Model{
    var $admin=[
        'ACCUEIL'=>'/Accueil',
        'FICHE D\'INSCRIPTION'=>'/Inscription',
        'LISTE DES ÉTUDIANTS'=>'/Etudiant/Listes',
        'EMARGEMENTS'=>'/Emargements',
        'STATISTIQUE'=>'/Statistique',
        'RECU' => '/finance/recus',
        // 'ABSENCE ET RETARD'=>[
        //     'id'=>'menu_abs_rt',
        //     ['name'=>'Gestion des ABS/RT','link'=>'/Retard'],
        //     ['name'=>'Justification des ABS/RT','link'=>'/ABS'],
        //     ['name'=>'Statistique des ABS/RT','link'=>'/ABS/statistique']
        // ],
        //'MATIÈRES'=>'/Matieres',
        'AUTRES'=>[
            'id'=>'menu_mat',
            'id'=>'menu_mat',
            ['name'=>'Configuration pour la gestion des notes','link'=>'/Matieres'],
            ['name'=>'Gestion des comptes étudiant','link'=>'/Etudiant/Compte'],
            ['name'=>'Gestion des groupes et parcours','link'=>'/Au'],
            ['name'=>'Gestion des Délégués','link'=>'/Delegues'],
            ['name'=>'Gestion des utilisateurs','link'=>'/Utilisateurs'],
            ['name'=>'Exportation des données','link'=>'/Export'],
            
        ],
        'SYNTHESE'=>[
            'id'=>'menu_mat',
            ['name'=>'Total','link'=>'/Synthese'],
            ['name'=>'Par étudiant','link'=>'/Synthese/student'],
            ['name'=>'Par classe','link'=>'/Synthese/classe'],
           
        ],
        // 'Matieres'=>'/Matieres',
    ],
    $standard=[
        'ACCUEIL'=>'/Accueil',
        'FICHE D\'INSCRIPTION'=>'/Inscription',
        'LISTE DES ÉTUDIANTS'=>'/Etudiant/Listes',
        'EMARGEMENTS'=>'/Emargements',
        // 'RECU' => '/finance/recus',
        // 'ABSENCE ET RETARD'=>[
        //     'id'=>'menu_abs_rt',
        //     ['name'=>'Gestion des ABS/RT','link'=>'/Retard'],
        //     ['name'=>'Justification des ABS/RT','link'=>'/ABS'],
        //     ['name'=>'Statistique des ABS/RT','link'=>'/ABS/statistique']
        // ],
        //'MATIÈRES'=>'/Matieres',
        'AUTRES'=>[
            'id'=>'menu_mat',
            ['name'=>'Configuration pour la gestion des notes','link'=>'/Matieres'],
            ['name'=>'Exportation des données','link'=>'/Export'],
           
        ]
    ],
    $job_etudiant=[
        'ACCUEIL'=>'/Accueil',
        'FICHE D\'INSCRIPTION'=>'/Inscription',
        'LISTE DES ÉTUDIANTS'=>'/Etudiant/Listes'
    ],
    $guest=[
        'ACCUEIL'=>'/Accueil',
        'LISTE DES ÉTUDIANTS'=>'/Etudiant/Listes',
        'RECU' => '/finance/recus'
    ],
    $devmaster=[
        'ACCUEIL'=>'/Accueil',
        'FICHE D\'INSCRIPTION'=>'/Inscription',
        'LISTE DES ÉTUDIANTS'=>'/Etudiant/Listes',
        'EMARGEMENTS'=>'/Emargements',
        'FINANCE'=>'/Finance',
        'STATISTIQUE'=>'/Statistique',
        // 'ABSENCE ET RETARD'=>[
        //     'id'=>'menu_abs_rt',
        //     ['name'=>'Gestion des ABS/RT','link'=>'/Retard'],
        //     ['name'=>'Justification des ABS/RT','link'=>'/ABS'],
        //     ['name'=>'Statistique des ABS/RT','link'=>'/ABS/statistique']
        // ],
        //'MATIÈRES'=>'/Matieres',
        'AUTRES'=>[
            'id'=>'menu_mat',
            ['name'=>'Configuration pour la gestion des notes','link'=>'/Matieres'],
            ['name'=>'Gestion des comptes étudiant','link'=>'/Etudiant/Compte'],
            ['name'=>'Gestion des groupes et parcours','link'=>'/Au'],
            ['name'=>'Gestion des Délégués','link'=>'/Delegues'],
            ['name'=>'Gestion des utilisateurs','link'=>'/Utilisateurs'],
            ['name'=>'Exportation des données','link'=>'/Export'],
            ['name'=>'Upload Files','link'=>'/Upload'],
            ['name'=>'Réinitialisation des données','link'=>'/Data'],
            ['name'=>'Debug inscription','link'=>'/Debug']
           
        ],
        'RECU' => '/finance/recus',
        'SYNTHESE'=>[
            'id'=>'menu_mat',
            ['name'=>'Total','link'=>'/Synthese'],
            ['name'=>'Par étudiant','link'=>'/Synthese/student'],
            ['name'=>'Par classe','link'=>'/Synthese/classe'],
           
        ],
            
    ];

    public function __construct(){
        // parent::__construct();
    }

    

}