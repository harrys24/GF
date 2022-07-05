<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
class RecusModel extends Model{

    public static function getCurrentRecus(){
        $db=Database::getConnection();
        try {
            $sql = "SELECT idR, recus.NIE, nom, prenom, nom_niv, nom_gp, date_heure, montant, designation, annul_recu, date_p, mode,reste FROM recus, etudiant, inscription, niv, gp WHERE recus.NIE=etudiant.nie AND recus.AU_id=inscription.AU_id AND recus.NIV_id=inscription.NIV_id AND recus.GP_id=inscription.GP_id AND recus.INSC_num_matr=inscription.num_matr AND etudiant.nie=inscription.ETUDIANT_nie AND recus.NIE=inscription.ETUDIANT_nie AND niv.idNIV = recus.NIV_id AND gp.idGP=recus.GP_id ORDER BY date_heure DESC Limit 50";
            $stm = $db->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }
    public static function deleteById($idR){
        $db=Database::getConnection();
        try {
            $sql = "DELETE FROM recus WHERE idR=?";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $idR);
            $stm->execute();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }


    public static function getStudent($nie){
        $db=Database::getConnection();
        try {
            $sql = "SELECT nom, prenom, nom_niv, nom_gp, num_matr FROM etudiant, inscription, niv, gp WHERE etudiant.nie=inscription.ETUDIANT_nie AND inscription.NIV_id=niv.idNIV AND inscription.GP_id=gp.idGP AND etudiant.nie=? AND inscription.AU_id=(SELECT * FROM au_courante)";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $nie);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }
    public static function getStudentByMatr($matr){
        $db=Database::getConnection();
        try {
            $sql = "SELECT nom, prenom, nom_niv, nom_gp, num_matr, idNIV, idGP, inscription.AU_id FROM etudiant, inscription, niv, gp WHERE etudiant.nie=inscription.ETUDIANT_nie AND inscription.NIV_id=niv.idNIV AND inscription.GP_id=gp.idGP AND inscription.num_matr=?";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $matr);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }
    public static function getRecuByDate($date){
        $db=Database::getConnection();
        try {
            $sql = "SELECT idR, recus.NIE, nom, prenom, nom_niv, nom_gp, date_heure, designation, montant, annul_recu, date_p, mode, reste FROM recus, etudiant, inscription, niv, gp WHERE recus.NIE=etudiant.nie AND recus.AU_id=inscription.AU_id AND recus.NIV_id=inscription.NIV_id AND recus.GP_id=inscription.GP_id AND recus.INSC_num_matr=inscription.num_matr AND etudiant.nie=inscription.ETUDIANT_nie AND recus.NIE=inscription.ETUDIANT_nie AND niv.idNIV = recus.NIV_id AND gp.idGP=recus.GP_id AND date_p=? ORDER BY date_heure DESC";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $date);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }
    public static function getTotlaDay($date){
        $db=Database::getConnection();
        try {
            $sql = "SELECT SUM(montant) as montant FROM recus, etudiant, inscription, niv, gp WHERE recus.NIE=etudiant.nie AND recus.AU_id=inscription.AU_id AND recus.NIV_id=inscription.NIV_id AND recus.GP_id=inscription.GP_id AND recus.INSC_num_matr=inscription.num_matr AND etudiant.nie=inscription.ETUDIANT_nie AND recus.NIE=inscription.ETUDIANT_nie AND niv.idNIV = recus.NIV_id AND gp.idGP=recus.GP_id AND ISNULL(annul_recu) AND date_p=? AND mode = 'ESP' ORDER BY date_heure DESC";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $date);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }
    // public static function getTotlaDay($date){
    //     $db=Database::getConnection();
    //     try {
    //         $sql = "SELECT SUM(montant) as montant FROM recus, etudiant, inscription, niv, gp WHERE recus.NIE=etudiant.nie AND recus.AU_id=inscription.AU_id AND recus.NIV_id=inscription.NIV_id AND recus.GP_id=inscription.GP_id AND recus.INSC_num_matr=inscription.num_matr AND etudiant.nie=inscription.ETUDIANT_nie AND recus.NIE=inscription.ETUDIANT_nie AND niv.idNIV = recus.NIV_id AND gp.idGP=recus.GP_id AND ISNULL(annul_recu) AND SUBSTR(date_heure,1,10)=? ORDER BY date_heure DESC";
    //         $stm = $db->prepare($sql);
    //         $stm->bindParam(1, $date);
    //         $stm->execute();
    //         return $stm->fetchAll();
    //     } catch (\PDOException $th) {
    //         return $th->getMessage();
    //     }           
    // }
    public static function getRecusByNie($nie){
        $db=Database::getConnection();
        try {
            $sql = "SELECT idR, recus.NIE, nom, prenom, nom_niv, nom_gp, date_heure, montant, designation, annul_recu, date_p, reste, mode FROM recus, etudiant, inscription, niv, gp WHERE recus.NIE=etudiant.nie AND recus.AU_id=inscription.AU_id AND recus.NIV_id=inscription.NIV_id AND recus.GP_id=inscription.GP_id AND recus.INSC_num_matr=inscription.num_matr AND etudiant.nie=inscription.ETUDIANT_nie AND recus.NIE=inscription.ETUDIANT_nie AND niv.idNIV = recus.NIV_id AND gp.idGP=recus.GP_id AND recus.NIE =?    ORDER BY date_heure DESC";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $nie);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }
    public static function getRecuByStatus($status){
        $db=Database::getConnection();
        try {
            $sql = "SELECT idR, recus.NIE, nom, prenom, nom_niv, nom_gp, date_heure, montant, designation, annul_recu, date_p, mode,reste FROM recus, etudiant, inscription, niv, gp WHERE recus.NIE=etudiant.nie AND recus.AU_id=inscription.AU_id AND recus.NIV_id=inscription.NIV_id AND recus.GP_id=inscription.GP_id AND recus.INSC_num_matr=inscription.num_matr AND etudiant.nie=inscription.ETUDIANT_nie AND recus.NIE=inscription.ETUDIANT_nie AND niv.idNIV = recus.NIV_id AND gp.idGP=recus.GP_id AND annul_recu=? ORDER BY date_heure DESC";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $status);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }

    

    public static function insertRecus($AU_id, $NIV_id, $GP_id, $num_matr, $nie, $montant, $reste, $designation, $mode, $date, $num, $signataire, $recu, $date_p, $date_bv){
        try {
            $db=Database::getConnection();
            $sql = "INSERT INTO `recus`(`AU_id`, `NIV_id`, `GP_id`, `INSC_num_matr`, `NIE`, `montant`, `reste`, `designation`, `mode`,`date_heure`, num, signataire, recu, date_p, date_bv) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $AU_id);
            $stm->bindParam(2, $NIV_id);
            $stm->bindParam(3, $GP_id);
            $stm->bindParam(4, $num_matr);
            $stm->bindParam(5, $nie);
            $stm->bindParam(6, $montant);
            $stm->bindParam(7, $reste);
            $stm->bindParam(8, $designation);
            $stm->bindParam(9, $mode);
            $stm->bindParam(10, $date);
            $stm->bindParam(11, $num);
            $stm->bindParam(12, $signataire);
            $stm->bindParam(13, $recu);
            $stm->bindParam(14, $date_p);
            $stm->bindParam(15, $date_bv);
            $stm->execute();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }       
    }

    public static function getLastId(){
        $db=Database::getConnection();
        try {
            $sql = "SELECT Max(idR) FROM recus";
            $stm = $db->prepare($sql);
            $stm->execute();
            return $stm->fetchColumn();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }  
    }
    public static function annulerRecu($idR, $id){
        $db=Database::getConnection();
        try {
            $sql = "UPDATE `recus` SET `recu`=?, `annul_recu`=1 WHERE idR=?";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $id);
            $stm->bindParam(2, $idR);
            $stm->execute();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }  
    }

    public static function getRecus($idR){
        $db=Database::getConnection();
        try {
            $sql = "SELECT idR,num_matr, num, signataire, date_p, date_bv, recus.NIE, nom, prenom, nom_niv, nom_gp, date_heure, montant, reste, designation, mode FROM recus, etudiant, inscription, niv, gp WHERE recus.NIE=etudiant.nie AND recus.AU_id=inscription.AU_id AND recus.NIV_id=inscription.NIV_id AND recus.GP_id=inscription.GP_id AND recus.INSC_num_matr=inscription.num_matr AND etudiant.nie=inscription.ETUDIANT_nie AND recus.NIE=inscription.ETUDIANT_nie AND niv.idNIV = recus.NIV_id AND gp.idGP=recus.GP_id AND idR = ?";
            $stm = $db->prepare($sql);
            $stm->bindParam(1, $idR);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            return $th->getMessage();
        }           
    }

    
}