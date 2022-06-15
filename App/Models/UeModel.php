<?php

namespace App\Models;
use App\Core\Model;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;

class UeModel extends Model{

    protected $isPK='idUE';
    protected $isAI=true;
    var $idUE,$titre_ue,$nom_ue;
    public function __construct(){
        parent::__construct();
    }

    public static function store(){
        Utils::HeaderJS();
        Utils::PAuth();
        $m=new UeModel();
        Utils::UCP('nom_ue');
        Utils::UCP('titre_ue');
        $m->parse($_POST);
        if ($_POST['type']=='a') {
            $res=$m->insert();
            $lastId=intval($res);
            if (isset($lastId)) {
                echo json_encode(['color'=>'info','message'=>'Bien ajouté !','lastId'=>$lastId]);  
            } else {
                echo json_encode(['color'=>'danger','message'=>'Erreur \'ajout !']);     
            }
        } else {
            Utils::int_post('idUE');
            $res=$m->update();
            if ($res=='ok') {
                echo json_encode(['color'=>'info','message'=>'Mise à jour efféctuée !','status'=>'u']);  
            } else {
                echo json_encode(['color'=>'danger','message'=>'Erreur de mise à jour!']);     
            }
            
        }
    }

    public static function getLs(){
        $db=Database::getConnection();
        $sql='SELECT idUE AS id,concat(titre_ue,\' - \',nom_ue) AS value FROM ue';
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }


    public static function generateTitre(){
        $db=Database::getConnection();
        $sql='SELECT titre_ue FROM ue ORDER BY idUE DESC LIMIT 1';
        try {
            $stmt = $db->query($sql);
            $res= $stmt->fetch();
            $titre_ue=$res['titre_ue'];
            if (isset($titre_ue)) {
                $lastId=mb_substr($titre_ue,2);
                $lastId=\intval($lastId)+1;
                echo 'UE'.$lastId;
            } else {
                echo 'UE1';
            }
        } catch (\PDOException $ex) {
            echo 'ko';
        }
    }

}
