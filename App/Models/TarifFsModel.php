<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
class TarifFsModel extends Model{
    protected $isPK='id';
    protected $isAI=true;
    protected $table_name='tarif_fs';
    
    var $id,$montant_tar,$au_id,$niv_id;
    public function __construct(){
        parent::__construct();
    }

    public static function insertList($ls){
        $db=Database::getConnection();
        $sql='INSERT INTO tarif_fs (montant_tar,au_id,niv_id) VALUES (:montant_tar,:au_id,:niv_id)';
        $db->beginTransaction();
        $count=0;
        foreach ($ls['detail'] as $item) {
            $stmt=$db->prepare($sql);
            $stmt->bindParam(':montant_tar',$item['montant']);
            $stmt->bindParam(':au_id',$ls['au']);
            $stmt->bindParam(':niv_id',$item['niv']);
            if ($stmt->execute()) {$count++;}
        }
        if ($count==count($ls['detail'])) {
            $db->commit();
            return true;
        } else {
            $db->rollBack();
            return false;
        }
    }

    public static function getAll($ls=[]){
        $db=Database::getConnection();
        $sql='SELECT a.nom_au,n.nom_niv,t.montant_tar FROM tarif_fs t 
        INNER JOIN au a ON t.AU_id=a.idAU 
        INNER JOIN niv n ON t.NIV_id=n.idNIV';
        $stmt=$db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        
    }
    public static function checkAU($au=''){
        $db=Database::getConnection();
        $sql='SELECT a.nom_au,n.nom_niv,t.* FROM tarif_fs t 
        INNER JOIN au a ON t.AU_id=a.idAU 
        INNER JOIN niv n ON t.NIV_id=n.idNIV WHERE a.idAU=?';
        $stmt=$db->prepare($sql);
        $stmt->execute([$au]);
        $res=$stmt->fetchAll();
        if (count($res)>0) {
            $data['list']=$res;
            $data['mode']='u';
        }else{
            $sql='SELECT idNIV,nom_niv FROM niv ORDER BY nom_niv ASC;';
            $stmt=$db->prepare($sql);
            $stmt->execute();
            $data['list']=$stmt->fetchAll();
            $data['mode']='i';
        }
        return $data;
        
    }

    public static function updateFs($params){
        $db=Database::getConnection();
        $sql='UPDATE tarif_fs SET AU_id=:au,NIV_id=:niv,montant_tar=:montant WHERE id=:id';
        $stmt=$db->prepare($sql);
        return $stmt->execute($params);
    }

    public static function getTarifFs($params){
        $db=Database::getConnection();
        $sql='SELECT montant_tar FROM tarif_fs WHERE AU_id=:au AND NIV_id=:niv';
        $stmt=$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }


    

}
    