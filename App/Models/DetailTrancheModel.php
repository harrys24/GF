<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
class DetailTrancheModel extends Model{
    protected $isPK='id';
    protected $isAI=true;
    protected $table_name='detail_par_tranche';
    
    var $id,$num_tranche,$date_prevu,$montant_prevu,$au_id,$niv_id,$tranche_id;
    public function __construct(){
        parent::__construct();
    }

    public static function insertList($ls){
        $db=Database::getConnection();
        $sql='INSERT INTO detail_par_tranche (num_tranche,date_prevu,montant_prevu,tranche_id,au_id,niv_id) VALUES (:num_tranche,:date_prevu,:montant_prevu,:tranche_id,:au_id,:niv_id)';
        $db->beginTransaction();
        $count=0;
        foreach ($ls['detail'] as $item) {
            $stmt=$db->prepare($sql);
            $stmt->bindParam(':num_tranche',$item['num_tranche']);
            $stmt->bindParam(':date_prevu',$item['date_prevu']);
            $stmt->bindParam(':montant_prevu',$item['montant']);
            $stmt->bindParam(':tranche_id',$ls['tranche']);
            $stmt->bindParam(':au_id',$ls['au']);
            $stmt->bindParam(':niv_id',$ls['niv']);
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

    public static function updateList($ls){
        $db=Database::getConnection();
        $sql='UPDATE detail_par_tranche SET num_tranche=:num_tranche,date_prevu=:date_prevu,montant_prevu=:montant_prevu
         WHERE id=:id;';
        $db->beginTransaction();
        $count=0;
        foreach ($ls['detail'] as $item) {
            $stmt=$db->prepare($sql);
            $stmt->bindParam(':num_tranche',$item['num_tranche']);
            $stmt->bindParam(':date_prevu',$item['date_prevu']);
            $stmt->bindParam(':montant_prevu',$item['montant']);
            $stmt->bindParam(':id',$item['id']);
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

    public static function getDetail($params){
        $db=Database::getConnection();
        $sql='SELECT * FROM detail_par_tranche WHERE au_id=:au AND niv_id=:niv AND tranche_id=:tranche ORDER BY num_tranche ASC;';
        $stmt=$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    
    }

    public static function getDetailFormat($params){
        $db=Database::getConnection();
        $sql='SELECT date_prevu,montant_prevu FROM detail_par_tranche  WHERE au_id=:au AND niv_id=:niv AND tranche_id=:tranche ORDER BY num_tranche ASC;';
        $stmt=$db->prepare($sql);
        $stmt->execute($params);
        $data= $stmt->fetchAll();
        if (count($data)>0) {
            foreach ($data as $k => $item) {
                $data[$k]['montant_prevu']=number_format($item['montant_prevu'], 2, ',', ' ');
            }
            return $data;
        }else return [];
    
    }

    public static function check($params){
        $data=self::getDetail($params);
        if (count($data)>0) {
            $res['mode']='u';
            $res['list']=$data;
        }else{
            $res['mode']='i';
        }
        return $res;
    
    }

    

}
    