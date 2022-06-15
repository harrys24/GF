<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Utils;
use App\Core\Alert;
use App\Core\Database;
class InscriptionModel extends Model{
    protected $isPK='num_matr',
        $isAI=true;
    var $num_matr, $ETUDIANT_nie, $GP_id,$NIV_id, $AU_id, $TrancheFS_id, $dateInscr,
    $DI,$Reste_DI,$EP,$DO_id,$do_en,$comment,$list_dossier,$pwd;
    public function __construct(){
        parent::__construct();
    }

    public static function getDossier($idNiv){
        $sql='select d.iddos as idos,d.nom_dos as vdos from niv_has_dos nd 
        inner join dossier d on d.iddos=nd.dos_id where nd.niv_id=?;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute([$idNiv]);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }

    }

    public static function getEtudiant($nie,$au_id,$niv_id,$gp_id)
    {
        $db=Database::getConnection();
        $sql="select i.num_matr as nm,e.nie,e.nom,e.prenom,if(e.sexe=1,'M','F') as sexe from inscription i 
        inner join etudiant e on i.etudiant_nie=e.nie 
        where etudiant_nie=? and au_id=? and niv_id=? and gp_id=?;";
        $stmt=$db->prepare($sql);
        $stmt->execute([$nie,intval($au_id),intval($niv_id),intval($gp_id)]);
        return $stmt->fetch();

    }

    public static function getCheckEtudiant($num_matr)
    {
        $db=Database::getConnection();
        $sql="select a.idAU,a.nom_au as AU,n.idNIV,g.idGP,CONCAT(n.nom_niv,g.nom_gp) as NIV_GP,t.*,e.nie,e.abandon,e.nom,e.prenom,if(e.sexe=1,'M','F') as sexe,datenaiss from inscription i 
        inner join etudiant e on i.etudiant_nie=e.nie 
        inner join au a on i.AU_id=a.idAU 
        inner join niv n on i.NIV_id=n.idNIV 
        inner join gp g on i.GP_id=g.idGP 
        inner join tranchefs t on i.TrancheFS_id=t.idT 
        where num_matr=? ;";
        $stmt=$db->prepare($sql);
        $stmt->execute([intval($num_matr)]);
        return $stmt->fetch();

    }
    
    
    public static function isExist($nie,$au_id,$niv_id,$gp_id)
    {
        $db=Database::getConnection();
        $sql="select etudiant_nie,au_id,niv_id,gp_id from inscription where ETUDIANT_nie=? and au_id=? and niv_id=? and gp_id=?;";
        $stmt=$db->prepare($sql);
        $stmt->execute([$nie,intval($au_id),intval($niv_id),intval($gp_id)]);
        return $stmt->fetch();

    }

    public static function migrate($au_id,$niv_id,$gp_id,$list){
        Utils::HeaderJS();
        $au_id=intval($au_id);
        $niv_id=intval($niv_id);
        $gp_id=intval($gp_id);
        $sql='update inscription set niv_id=?,gp_id=? where num_matr=? and etudiant_nie=? and au_id=?;';
        $db=Database::getConnection();
        $db->beginTransaction();
        $nb=0;$nbu=0;
        try {
            $stmt=$db->prepare($sql);
            foreach ($list as $item) {
                $nm=intval($item['nm']);
                $ne=$item['ne'];
                $res=$stmt->execute([$niv_id,$gp_id,$nm,$ne,$au_id]);
                if ($res) {
                   $nbu++;
                }
                $nb++;
            }
            if ($nb==$nbu) {
                $db->commit();
                Alert::success('u');
            } else {
                $db->rollback();
                Alert::error('u');
            }
            
        } catch (\PDOException $ex) {
            $db->rollback();
            Alert::debug($ex->getMessage());
        }
    }
    

    
    
}