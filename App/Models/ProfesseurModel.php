<?php

namespace App\Models;
use App\Core\Model;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;

class ProfesseurModel extends Model{
    protected $isPK='idPR';
    protected $isAI=true;
    
    var $idPR,$nom_pr,$prenom_pr,$sexe_pr,$contacte_pr,$email_pr,$GR_id;
    public function __construct(){
        parent::__construct();
    }

    public static function store(){
        Utils::HeaderJS();
        Utils::PAuth();
        $_POST['sexe_pr']=isset($_POST['sexe_pr'])?1:0;
        $m=new ProfesseurModel();
        Utils::UCP('nom_pr');
        $m->parse($_POST);
        Utils::int_post('GR_id');
        if ($_POST['type']=='a') {
            $res=$m->insert();
            $lastId=intval($res);
            if (isset($lastId)) {
                echo json_encode(['color'=>'info','message'=>'Bien ajouté !','lastId'=>$lastId]);  
            } else {
                echo json_encode(['color'=>'danger','message'=>'Erreur \'ajout !']);     
            }
        } else {
            Utils::int_post('idPR');
            $res=$m->update();
            if ($res=='ok') {
                echo json_encode(['color'=>'info','message'=>'Mise à jour efféctuée !','status'=>'u']);  
            } else {
                echo json_encode(['color'=>'danger','message'=>'Erreur de mise à jour!']);     
            }
            
        }
    }




    public static function getFullName(){
        $db = Database::getConnection();
        try {
            $sql = "SELECT idPR as id,CONCAT(nom_pr,' ',prenom_pr) as fullname  FROM `professeur` ORDER BY nom_pr,prenom_pr ASC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $th) {
            $th->getMessage();
        }
    }

    

    public static function insertProf($nom, $prenom, $sexe, $contact, $email, $grade){
        $db = Database::getConnection();
        try {
            $sql = "INSERT INTO `professeur`(`nom_pr`, `prenom_pr`, `sexe_pr`, `contacte_pr`, `email_pr`, `GR_id`) VALUES (?,?,?,?,?,?)";
            $stm = $db->prepare($sql);
            $stm->bindParam('1', $nom);
            $stm->bindParam('2', $prenom);
            $stm->bindParam('3', $sexe);
            $stm->bindParam('4', $contact);
            $stm->bindParam('5', $email);
            $stm->bindParam('6', $grade);
            $stm->execute();
        } catch (\PDOException $th) {
            $th->getMessage();
        }
    }
    public static function delProf($idPR){
        $db = Database::getConnection();
        try {
            $sql = "DELETE FROM `professeur` WHERE `professeur`.`idPR` = ?";
            $stm = $db->prepare($sql);
            $stm->bindParam('1', $idPR);
            $stm->execute();
        } catch (\PDOException $th) {
            $th->getMessage();
        }
    }

    public static function findPr($nom, $prenom, $sexe){
        $db = Database::getConnection();
        try {
            $sql = "SELECT `idPR`, `nom_pr`, `prenom_pr`, `sexe_pr`, `contacte_pr`, `email_pr`, `GR_id` FROM `professeur` WHERE nom_pr = ? AND sexe_pr=? AND prenom_pr=?";
            $stm = $db->prepare($sql);
            $stm->bindParam('1', $nom);
            $stm->bindParam('2', $sexe);
            $stm->bindParam('3', $prenom);
            $stm->execute();
            return $stm->fetch();
        } catch (\PDOException $th) {
            $th->getMessage();
        }
    }

    public static function getPrById($idPR){
        $db = Database::getConnection();
        try {
            $sql = "SELECT idPR, nom_pr, prenom_pr, sexe_pr, contacte_pr,email_pr, nom_gr FROM `professeur`, gr WHERE gr.idgr=professeur.GR_id  AND professeur.idPR=?";
            $stm = $db->prepare($sql);
            $stm->bindParam('1', $idPR);
            $stm->execute();
            return $stm->fetch();
        } catch (\PDOException $th) {
            $th->getMessage();
        }
    }

    public static function updatePR($idPR, $nom, $prenom, $sexe, $contact, $email, $GR_id){
        $db = Database::getConnection();
        try {
            $sql = "UPDATE `professeur` SET `nom_pr`=?,`prenom_pr`=?,`sexe_pr`=?,`contacte_pr`=?,`email_pr`=?,`GR_id`=? WHERE professeur.idPR=?";
            $stm = $db->prepare($sql);
            $stm->bindParam('1', $nom);
            $stm->bindParam('2', $prenom);
            $stm->bindParam('3', $sexe);
            $stm->bindParam('4', $contact);
            $stm->bindParam('5', $email);
            $stm->bindParam('6', $GR_id);
            $stm->bindParam('7', $idPR);
            $stm->execute();
            return $stm->fetch();
        } catch (\PDOException $th) {
            $th->getMessage();
        }
    }
}