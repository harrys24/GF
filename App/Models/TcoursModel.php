<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
use \DateTime;
class TcoursModel extends Model{
    protected $isPK='idTC',
    $isAI=true;
    var $idTC,$date_cours,$hdebut,$hfin,$commentaire,$MAT_id,$PR_id,$SALLE_id;
    public function __construct(){
        parent::__construct();
    }

    public static function getLsCoursBy($date_cours,$idSALLE){
        $sql='select m.nom_mat,t.idTC,t.date_cours,t.hdebut,t.hfin from tcours t 
        inner join matiere m on m.idmat=t.mat_id 
        where date_cours=? and salle_id=?;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute([$date_cours,$idSALLE]);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public static function getLsCoursByNIE($date_cours,$idSALLE,$num_matr,$nie){
        
        $sql='select p.*,m.nom_mat,t.* from tcours t 
        inner join matiere m on m.idmat=t.mat_id 
        inner join presence p on p.tc_id=t.idtc 
        where date_cours=? and salle_id=? and p.inscr_num_matr and p.etudiant_nie=?;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute([$date_cours,$idSALLE,$nie]);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return null;
        }
    }


    public static function _isBetween($d,$f,$lsh){
        foreach ($lsh as $item) {
            $hd=new DateTime($item['date_cours'].' '.$item['hdebut']);
            $hf=new DateTime($item['date_cours'].' '.$item['hfin']);
            if (!(($d<$hd && $f<=$hd) || ($d>=$hf && $f>$hf))) {
                return $item;
            } 
        }
        return false;
    }

    public static function isBetween($d,$f,$lsh){
        foreach ($lsh as $item) {
            $hd=new DateTime($item['date_cours'].' '.$item['hdebut']);
            $hf=new DateTime($item['date_cours'].' '.$item['hfin']);
            if($hd==$d && $hf==$f){
                $item['info']='ok';
                return $item;
            }
            if (!(($d<$hd && $f<=$hd) || ($d>=$hf && $f>$hf))) {
                $item['info']='ko';
                $item['sdt']=$hd;
                $item['edt']=$hf;
                return $item;
            } 
            
        }
        return false;
    }
   
   
    

}