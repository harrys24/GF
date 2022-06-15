<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
class SyntheseModel extends Model{

    public static function getTotalPercu(){
        try {
            $db = Database::getConnection();
            $sql = 'SELECT SUM(montant) as total_percu FROM `recus` WHERE (annul_recu = 0 OR ISNULL(annul_recu))';
            $stm = $db->prepare($sql);
            $stm->execute();
            return $stm->fetchColumn();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }
    }

    public static function getAllStudent(){
        $db = Database::getConnection();
        try {
            $sql = "SELECT nie, nom, prenom, nom_niv, nom_gp, num_matr FROM `inscription`, etudiant, niv, gp, au,gp_has_au WHERE inscription.AU_id=gp_has_au.AU_id AND inscription.NIV_id=gp_has_au.NIV_id AND inscription.GP_id=gp_has_au.GP_id AND inscription.NIV_id=niv.idNIV AND inscription.GP_id=gp.idGP AND inscription.AU_id=au.idAU AND gp_has_au.NIV_id=niv.idNIV AND gp_has_au.AU_id=au.idAU AND gp_has_au.GP_id=gp.idGP AND etudiant.nie=inscription.ETUDIANT_nie AND au.idAU = (SELECT * FROM au_courante) ORDER BY nom,prenom ASC";
            $stm = $db->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            $th->getMessage();
        }
    }
    public static function getPercusByStudents($num_matr, $debut, $fin){
        $db = Database::getConnection();
        try {
            $sql = "SELECT SUM(montant) as total_percu FROM `recus` WHERE (annul_recu = 0 OR ISNULL(annul_recu)) AND INSC_num_matr=? AND (date_p >=? AND date_p <=?)";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $num_matr);
            $stm->bindParam(2, $debut);
            $stm->bindParam(3, $fin);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }
    }
    public static function getPercusByClasse($NIV_id, $GP_id, $debut, $fin){
        $db = Database::getConnection();
        try {
            $sql = "SELECT SUM(montant) as total_percu, num_matr, etudiant.nie, nom, prenom FROM `recus`, inscription, etudiant WHERE inscription.num_matr=recus.INSC_num_matr AND inscription.ETUDIANT_nie=etudiant.nie AND (annul_recu = 0 OR ISNULL(annul_recu)) AND inscription.AU_id=(SELECT * FROM au_courant) AND inscription.NIV_id=? AND inscription.GP_id=? AND (date_p >=? AND date_p <=?)";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $NIV_id);
            $stm->bindParam(2, $GP_id);
            $stm->bindParam(3, $debut);
            $stm->bindParam(4, $fin);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }
    }
    public static function getPercusByStudentsFiltre($num_matr, $debut, $fin, $filtre){
        $db = Database::getConnection();
        try {
            $sql = "SELECT SUM(montant) as total_percu FROM `recus` WHERE (annul_recu = 0 OR ISNULL(annul_recu)) AND INSC_num_matr=? AND (date_p >=? AND date_p <=?) AND designation=?";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $num_matr);
            $stm->bindParam(2, $debut);
            $stm->bindParam(3, $fin);
            $stm->bindParam(4, $filtre);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }
    }
    public static function getReste($num_matr){
        $db = Database::getConnection();
        try {
            $sql = "SELECT reste FROM `recus` WHERE (annul_recu = 0 OR ISNULL(annul_recu)) AND INSC_num_matr=? GROUP BY INSC_num_matr ORDER BY date_p ASC";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $num_matr);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }
    }

    public static function getStudent($matr){
        $db=Database::getConnection();
        try {
            $sql = "SELECT nom, prenom, nom_niv, nom_gp, num_matr, nie FROM etudiant, inscription, niv, gp WHERE etudiant.nie=inscription.ETUDIANT_nie AND inscription.NIV_id=niv.idNIV AND inscription.GP_id=gp.idGP AND num_matr=?";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $matr);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }

    
}