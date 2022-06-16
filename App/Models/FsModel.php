<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
class FsModel extends Model{
    protected $isPK='idFS',
        $isAI=true;
        
    var $idFS,$num_tranche,
        $num_reçu,
        $date_prevu,$date_payement,
        $montant,
        $INSCR_num_matr;
    public function __construct(){
        parent::__construct();
    }


    public static function getListBy($num_matr){
        $sql="SELECT idFS,num_tranche,DATE_FORMAT(date_prevu,'%d/%m/%Y') as date_prevu FROM fs WHERE INSCR_num_matr=?  ORDER BY num_tranche ASC";
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1,$num_matr);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }

    public static function getFromDate($date)
    {
        $db=Database::getConnection();
        $sql="SELECT e.nie,e.nom,e.prenom,CONCAT(e.contacte_p,',',e.contacte_m,',',e.contacte_t) as contact,n.idNIV,n.nom_niv,g.idGP,g.nom_gp,t.nbT,f.* FROM inscription i 
        INNER JOIN fs f ON i.num_matr=f.INSCR_num_matr 
        INNER JOIN tranchefs t ON i.TrancheFS_id=t.idT 
        INNER JOIN etudiant e ON i.ETUDIANT_nie=e.nie 
        INNER JOIN niv n ON i.NIV_id=n.idNIV 
        INNER JOIN gp g ON i.GP_id=g.idGP 
        WHERE i.abandon=0 AND f.date_prevu=? ORDER BY n.idNIV ASC, g.idGP ASC;";
        $stmt=$db->prepare($sql);
        $stmt->execute([$date]);
        return $stmt->fetchAll();

    }
    public static function getDetail($nm,$fs,$nv,$gp)
    {
        $db=Database::getConnection();
        $sql="SELECT montant_tar FROM tarif_fs t WHERE t.AU_id=(SELECT * FROM au_courante) AND t.GP_id=? ;";
        $stmt=$db->prepare($sql);
        $stmt->execute([$gp]);
        $montant=$stmt->fetchColumn();

        $sql="SELECT * FROM fs f WHERE f.INSCR_num_matr=? AND f.idFS <= ? ORDER BY f.num_tranche ASC";
        $stmt=$db->prepare($sql);
        $stmt->execute([$nm,$fs]);
        $details=$stmt->fetchAll();
        return [$montant,$details];

    }
    public static function updateFs()
    {
        $db=Database::getConnection();
        $sql="UPDATE fs f SET f.num_reçu=:nr,f.montant=:mt,f.date_paiement=:dp,f.status=1 WHERE f.idFS=:fs AND f.INSCR_num_matr=:nm";
        $stmt=$db->prepare($sql);
        try {
            return $stmt->execute($_POST);
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }

    }

    public static function resetFs()
    {
        $db=Database::getConnection();
        $sql="UPDATE fs f SET f.num_reçu=:nr,f.montant=:mt,f.date_paiement=:dp,f.status=0 WHERE f.idFS=:fs AND f.INSCR_num_matr=:nm";
        $stmt=$db->prepare($sql);
        $fs=$_POST['fs'];
        $nm=$_POST['nm'];
        try {
            return $stmt->execute(['nr'=>null,'mt'=>null,'dp'=>null,'fs'=>$fs,'nm'=>$nm]);
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }

    }

    public static function getNewNum($str)
    {
        $db=Database::getConnection();
        $sql="SELECT num_reçu FROM fs WHERE num_reçu LIKE '".$str."%' ORDER BY num_reçu DESC LIMIT 1;";
        $stmt=$db->query($sql);
        $res=$stmt->fetch();
        if($res){
            $s=substr($res['num_reçu'],-5);
            // $ls=mb_split('_',$res['num_reçu']);
            // $s=intval($ls[1])+1;
            // return $ls[0].'_'.sprintf('%05d',$s);
            $s=intval($s)+1;
            $s=sprintf('%s%05d',$str,$s);
            return $s;
        }else return $str.'00001';

    }

    
    
}