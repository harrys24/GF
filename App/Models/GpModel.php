<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Model;
use App\Core\Utils;
use App\Core\Alert;
class GpModel extends Model{
    protected $isPK='idGP';
    protected $isAI=true;
    
    var $idGP,$nom_gp,$NIV_id;
    public function __construct(){
        parent::__construct();
    }
    public static function getListBy($idAU,$idNiv){
        $sql='SELECT g.idgp as igp ,g.nom_gp as gp from gp_has_au ga
        inner join niv n on n.idniv=ga.niv_id 
        inner join gp g on g.idgp =ga.gp_id 
        where au_id=? and niv_id=? order by g.nom_gp asc;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1,$idAU);
            $stmt->bindParam(2,$idNiv);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }
    public static function getListByAU($idNiv){
        $sql='select g.idgp as GP_id ,g.nom_gp as nom_gp from gp_has_au ga
        inner join niv n on n.idniv=ga.niv_id 
        inner join gp g on g.idgp =ga.gp_id 
        where au_id=(SELECT * FROM au_courante) and niv_id=? order by g.nom_gp asc;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1,$idNiv);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }

    public static function getAllNivGP($idAU){
        $sql='select n.idniv as ni ,n.nom_niv as niv,g.idgp as pi,g.nom_gp as gp  from gp_has_au ga
        inner join niv n on n.idniv=ga.niv_id 
        inner join gp g on g.idgp =ga.gp_id 
        where au_id=? order by n.nom_niv,g.nom_gp asc;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute([intval($idAU)]);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }

    public static function get4AU($idau){
        Utils::HeaderJS();
        $niv=['L1'=>1,'L2'=>2,'L3'=>3,'M1'=>4,'M2'=>5];
        $sql='select n.idniv as ni ,n.nom_niv as niv,g.idgp as pi,g.nom_gp as gp  from gp_has_au ga
        inner join niv n on n.idniv=ga.niv_id 
        inner join gp g on g.idgp =ga.gp_id 
        where au_id=? and niv_id=? order by n.nom_niv,g.nom_gp asc;';
        try {
            $db=Database::getConnection();
            $ls=[];
            $stmt = $db->prepare($sql);
            foreach ($niv as $key => $value) {
                $stmt->execute([$idau,$value]);
                $ls[$key]=$stmt->fetchAll();
                
            }
            echo json_encode($ls);
        } catch (\PDOException $ex) {
            // return $ex->getMessage()."</br>";
            return false;
        }
    }
    

    //getGP(['TC','IRD'])
    public static function _getGP($like){
        if (is_array($like)) {
           
            $sql="select idNIV,nom_niv,idGP,nom_gp from gp_has_au,gp,niv,au where GP_id=idGP and NIV_id=idNIV and AU_id=idAU and nom_au='2019-2020' and nom_niv='L1' order by nom_niv,nom_gp asc;";
            $db=Database::getConnection();
            $stmt=$db->prepare($sql);
            $stmt->execute($like);
            return $stmt->fetchAll();
        }
        

    }
    public static function getGP($like){
        if (is_array($like)) {
            $s=' nom_gp like ?';
            for ($i=0; $i < count($like)-1; $i++) { 
                $s.=" or nom_gp like ? ";
            }
            for ($i=0; $i < count($like); $i++) { 
                $like[$i].='%';
            }
            $sql="select * from gp where $s;";
            $db=Database::getConnection();
            $stmt=$db->prepare($sql);
            $stmt->execute($like);
            return $stmt->fetchAll();
        }
        

    }

    public static function checkInsert($au,$data){
        $au=intval($au);
        $db=Database::getConnection();
        $db->beginTransaction();
        $nbi=0;$nb=0;
        $sqle='select * from gp_has_au where au_id=? and niv_id=? and gp_id=?;';
        $sqli='insert into gp_has_au (au_id,niv_id,gp_id) values (?,?,?);';
        try {
            $stmt=$db->prepare($sqle);
            $stmti=$db->prepare($sqli);
            foreach ($data as $item) {
                $ni=intval($item['ni']);
                $gi=intval($item['gi']);
                $stmt->execute([$au,$ni,$gi]);
                $res=$stmt->fetch();
                if (empty($res)) {
                    if ($stmti->execute([$au,$ni,$gi])) {$nbi++;}
                    $nb++;
                }
            }
            if ($nb==$nbi) {
                $db->commit();
                Alert::info('a');
            } else {
                $db->rollback();
                Alert::error('a');
            }
            
        } catch (\PDOException $ex) {
            $db->rollback();
            Alert::debug($ex->getMessage);
        }

    }
    //------------------------------------------------------------------------------
    public static function insertGp($nom_gp, $NIV_id){
        $db = Database::getConnection();
        try {
            $sql = 'INSERT INTO `gp`(`nom_gp`, `NIV_id`) VALUES (?,?)';
            $stm = $db->prepare($sql);
            $stm->bindParam('1', $nom_gp);
            $stm->bindParam('2', $NIV_id);
            $stm->execute();
        } catch (\PDOException $th) {
            $th->getMessage().'</br>';
        }
    }

    public function getListGp(){
        $db = Database::getConnection();
        try {
            $sql = 'SELECT * FROM gp';
            $stm = $db->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            $th->getMessage().'</br>';
        }
    }

    public static function getListByNA($NIV_id, $AU_id){
        $db=Database::getConnection();
        try {
            $sql='SELECT `GP_id`, nom_gp FROM `gp_has_au`,gp WHERE gp.idGP=gp_has_au.GP_id AND AU_id=? AND NIV_id=?';
            $stmt = $db->prepare($sql);
            $stmt->bindParam('1',$AU_id);
            $stmt->bindParam('2',$NIV_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }

    public static function getAllNGP(){
        $sql="SELECT n.idNIV,n.nom_niv,g.idGP,g.nom_gp FROM gp g INNER JOIN niv n ON g.niv_id =n.idniv ORDER BY n.nom_niv,g.nom_gp ASC";
        try {
            $db=Database::getConnection();
            $stmt=$db->query($sql);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }

    public static function getGpFromNiv($NIV_id){
        $db = Database::getConnection();
        try {
            $sql="SELECT * FROM gp WHERE NIV_id=?";
            $stm = $db->prepare($sql);
            $stm->bindParam('1', $NIV_id);
            return $stm->fetchAll();
        } catch (\PDOException $th) {
            $th->getMessage();
        }
    }
    

}
    