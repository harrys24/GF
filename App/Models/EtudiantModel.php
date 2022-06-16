<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Utils;
use App\Core\Alert;
use App\Core\Database;
class EtudiantModel extends Model{
    // protected $isAI='nie';
    protected $isPK='nie',
        $isAI=false;
    //Etudiant
    var $nie,$abandon,$photo,$nom,$prenom,$sexe,$dateNaiss,$lieuNaiss,$email,$fb,$contacte,$adresse,
        $nom_p,$prenom_p,$adresse_p,$profession_p,$email_p,$contacte_p,
        $nom_m,$prenom_m,$adresse_m,$profession_m,$email_m,$contacte_m,
        $nom_t,$prenom_t,$adresse_t,$profession_t,$email_t,$contacte_t,
        $NAT_id,$AB_id,$SB_id,$MB_id,$REC_id,$dateRec;
    public function __construct(){
        parent::__construct();
    }

    public function getDescription()
    {
        $sexe=($this->sexe)?'H':'F';
        return $this->nie.'('.$sexe.') - '.$this->prenom.' '.$this->nom;
    }

    public static function getNewNie($str)
    {
        $db=Database::getConnection();
        $sql="select nie from etudiant where nie like '".$str."%' order by nie desc limit 1;";
        $stmt=$db->query($sql);
        $res=$stmt->fetch();
        if($res){
            $s=substr($res['nie'],-4);
            $s=intval($s)+1;
            return sprintf('%04d',$s);
        }else return '0001';

    }

    public static function setABD($nie)
    {
        $db=Database::getConnection();
        $sql="update etudiant set abandon=1 where nie=?";
        $stmt=$db->prepare($sql);
        return $stmt->execute([$nie]);
    }

    public static function deleteInscr($num_matr,$nie)
    {
        $db=Database::getConnection();
        $sql = "SELECT count(*) FROM inscription WHERE etudiant_nie=?"; 
        $stmt = $db->prepare($sql); 
        $stmt->execute([$nie]); 
        $nb = $stmt->fetchColumn(); 
        $sql = "SELECT count(*) FROM presence WHERE inscr_num_matr=? and etudiant_nie=?"; 
        $stmt = $db->prepare($sql); 
        $stmt->execute([$num_matr,$nie]); 
        if ($stmt->fetchColumn()>0) {
            return false;
        }
        try {
            if ($nb==1) {
                $sql="delete from fs where inscr_num_matr=?;delete from inscription where num_matr=?;delete from etudiant where nie=?;";
                $stmt=$db->prepare($sql);
                return $stmt->execute([$num_matr,$num_matr,$nie]);
            }else{
                $sql="delete from fs where inscr_num_matr=?;delete from inscription where num_matr=?;";
                $stmt=$db->prepare($sql);
                return $stmt->execute([$num_matr,$num_matr]);
    
            }
        } catch (\PDOException $ex) {
            return false;
        }
    }

    

    
    public static function isExist($nie,$nom,$prenom,$datenaiss)
    {
        $db=Database::getConnection();
        $sql="select nie,nom,prenom,datenaiss from etudiant where nie=? or (nom=? and prenom=? and datenaiss=?);";
        $stmt=$db->prepare($sql);
        $stmt->execute([$nie,$nom,$prenom,$datenaiss]);
        return $stmt->fetch();

    }

    public static function getNum_matr($nie,$nom,$prenom,$datenaiss,$au_id,$niv_id,$gp_id)
    {
        $db=Database::getConnection();
        $sql="select i.num_matr from inscription i 
        inner join etudiant e on i.etudiant_nie=e.nie 
        where (e.nie=? or (e.nom=? and e.prenom=? and e.datenaiss=?)) and i.au_id=? and i.niv_id=? and i.gp_id=?;";
        $stmt=$db->prepare($sql);
        $stmt->execute([$nie,$nom,$prenom,$datenaiss,intval($au_id),intval($niv_id),intval($gp_id)]);
        return $stmt->fetch();

    }

    public static function getLsByNivGP($au,$niv,$gp,$is_abd)
    {
        $abd=($is_abd==='false')?0:1;
        $db=Database::getConnection();
        $sql="SELECT i.num_matr,e.nie,e.photo,e.nom,e.prenom,e.sexe,IF(e.sexe=1,'boys','girls') as color,e.fb,e.email,
        YEAR(CURDATE())-YEAR(e.datenaiss) as age,DATE_FORMAT(i.dateInscr,'%d.%m.%Y') as dateInscr,DATE_FORMAT(e.dateRec,'%d.%m.%Y') as dateRec,
        (select r.poste_rec from recruteur r where r.idREC=e.REC_id) as posteRec, n.nom_niv, g.nom_gp 
        from inscription i
        inner join etudiant e on i.etudiant_nie=e.nie
        inner join niv n on i.NIV_id=n.idNIV 
        inner join gp g on i.GP_id=g.idGP 
        where i.AU_id= ? and i.NIV_id=? and i.GP_id=? and i.abandon=? order by e.nie asc";
        $stmt=$db->prepare($sql);
        $stmt->execute([intval($au),intval($niv),intval($gp),$abd]);
        return $stmt->fetchAll();
    }

    public static function getLsCmps($au,$niv,$gp)
    {
        $db=Database::getConnection();
        $sql="SELECT i.num_matr,i.pwd,e.nie,e.nom,e.prenom,e.sexe 
        from inscription i
        inner join etudiant e on i.etudiant_nie=e.nie
        where i.AU_id= ? and i.NIV_id=? and i.GP_id=? and i.abandon=0 order by e.nom,e.prenom asc";
        $stmt=$db->prepare($sql);
        $stmt->execute([intval($au),intval($niv),intval($gp)]);
        return $stmt->fetchAll();
    }

    public static function uptcmp()
    {
        $db=Database::getConnection();
        try {
            Utils::PEqual('pwd','cpwd');
            $sql="UPDATE inscription SET pwd=? WHERE num_matr=? AND ETUDIANT_nie=?;";
            $stmt=$db->prepare($sql);
            $stmt->execute([$_POST['pwd'],$_POST['nm'],$_POST['ne']]);
            echo json_encode(['color'=>'success','message'=>'Mise à jour OK!']);
        } catch (\PDOException $ex) {
            echo json_encode(['color'=>'danger','message'=>'Erreur: '.$ex->getMessage()]);
        }
        
    }

    public static function gererateCmps()
    {
        $db=Database::getConnection();
        try {
            $sql="UPDATE inscription SET pwd=? WHERE num_matr=? AND ETUDIANT_nie=?;";
            $stmt=$db->prepare($sql);
            foreach ($_POST['list'] as $item) {
                $pwd=Utils::str_random(6);
                $stmt->execute([$pwd,$item['nm'],$item['ne']]);
            }
            $au=intval($_POST['au']);
            $niv=intval($_POST['niv']);
            $gp=intval($_POST['gp']);
            $res=self::getLsCmps($au,$niv,$gp);
            echo json_encode($res);
        } catch (\PDOException $ex) {
            echo json_encode(['color'=>'danger','message'=>'Erreur: '.$ex->getMessage()]);
        }
        
    }

   
    public static function getLsEByNivGP($au,$niv,$gp)
    {
        $db=Database::getConnection();
        $sql="select i.num_matr,e.nie,e.photo,e.nom,e.prenom,IF(e.sexe=1,'M','F') as sexe 
        from inscription i 
        inner join etudiant e on i.etudiant_nie=e.nie 
        where i.AU_id= ? and i.NIV_id=? and i.GP_id=? and i.abandon=0 order by e.nom,e.prenom asc";
        $stmt=$db->prepare($sql);
        $stmt->execute([intval($au),intval($niv),intval($gp)]);
        return $stmt->fetchAll();
    }

    public static function getLsBySearch($au,$value,$is_abd,$by)
    {
        $abd=($is_abd==='false')?0:1;
        $db=Database::getConnection();
        $adv=($_SESSION['type']=='devmaster')?' || e.adresse like :adresse || YEAR(e.datenaiss) like :adn ':'';
        $cond='';
        switch ($by) {
            case 'e':
                $cond='e.nie like :nie || e.nom like :nom || e.prenom like :prenom';
                break;
            case 'p':
                $cond='e.nom_p like :nom_p || e.prenom_p like :prenom_p';
                break;
            case 'm':
                $cond='e.nom_m like :nom_m || e.prenom_m like :prenom_m';
                break;
            case 't':
                $cond='e.nom_t like :nom_t || e.prenom_t like :prenom_t';
                break;
            
            default:
                $cond='e.nie like :nie || e.nom like :nom || e.prenom like :prenom';
                break;
        }
        $sql="select i.num_matr,e.nie,e.photo,e.nom,e.prenom,e.sexe,IF(e.sexe=1,'boys','girls') as color,e.fb,e.email,
        YEAR(CURDATE())-YEAR(e.datenaiss) as age,DATE_FORMAT(i.dateInscr,'%d.%m.%Y') as dateInscr,DATE_FORMAT(e.dateRec,'%d.%m.%Y') as dateRec,
        (select r.poste_rec from recruteur r where r.idREC=e.REC_id) as posteRec, n.nom_niv, g.nom_gp 
        from inscription i
        inner join etudiant e on i.etudiant_nie=e.nie
        inner join niv n on i.NIV_id=n.idNIV 
        inner join gp g on i.GP_id=g.idGP 
        where i.AU_id= :au and i.abandon=:abd and (".$cond.$adv.") 
        order by e.nie asc";
        $au=intval($au);
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':au',$au);
        $stmt->bindParam(':abd',$abd);
        $txt='%'.$value.'%';
        switch ($by) {
            case 'e':
                $stmt->bindParam(':nie',$txt);
                $stmt->bindParam(':nom',$txt);
                $stmt->bindParam(':prenom',$txt);
                break;
            case 'p':
                $stmt->bindParam(':nom_p',$txt);
                $stmt->bindParam(':prenom_p',$txt);
                break;
            case 'm':
                $stmt->bindParam(':nom_m',$txt);
                $stmt->bindParam(':prenom_m',$txt);
                break;
            case 't':
                $stmt->bindParam(':nom_t',$txt);
                $stmt->bindParam(':prenom_t',$txt);
                break;
            
            default:
                $stmt->bindParam(':nie',$txt);
                $stmt->bindParam(':nom',$txt);
                $stmt->bindParam(':prenom',$txt);
                break;
        }
        
        if ($_SESSION['type']=='devmaster') {
            $stmt->bindParam(':adresse',$txt);
            $stmt->bindParam(':adn',$txt);
        }
        $stmt->execute();
        return $stmt->fetchAll();
        // var_dump($data);
    }
  
  
    public static function exportBy($txt,$au,$niv,$gp,$is_abd='false')
    {
        header('Content-Type: text/csv;');
        header("Content-Disposition: attachement; filename=$txt.csv;");
        $ls_filter=[
            'dn'=>'datenaiss','ln'=>'lieunaiss','ce'=>'contact','cp'=>'contact_p',
            'npp'=>'pere','npm'=>'mere','npt'=>'tuteur'
        ];
        $lsTitle=[
            'dn'=>'Date de naissance','ln'=>'Lieu de naissance',
            'ce'=>'Contacts étudiants','cp'=>'Contacts parents',
            'npp'=>'PÈRE','npm'=>'MÈRE','npt'=>'TUTEUR'];
        $cp=($_SESSION['type']=='devmaster')?'CONCAT(e.contacte_p,"|",e.contacte_m,"|",e.contacte_t)':'CONCAT(e.contacte_p,",",e.contacte_m)';
        $abd=($is_abd==='false')?0:1;
        
        $lsSql=[
            'dn'=>"DATE_FORMAT(e.datenaiss,'%d/%m/%Y') as datenaiss",
            'ln'=>'e.lieunaiss',
            'ce'=>'e.contacte as contact',
            'cp'=>$cp.' as contact_p',
            'npp'=>'CONCAT(e.nom_p," ",e.prenom_p) as pere',
            'npm'=>'CONCAT(e.nom_m," ",e.prenom_m) as mere',
            'npt'=>'CONCAT(e.nom_t," ",e.prenom_t) as tuteur'
        ];
        $s='';$stitle='';
        $ls_alias=[];
        if (isset($_POST['fm'])) {
            $filter=$_POST['fm'];
            foreach ($filter as $value) {
                $ls_alias[]=$ls_filter[$value];
                $s.=','.$lsSql[$value];
                $stitle.=';'.$lsTitle[$value];
            }
        }
        $db=Database::getConnection();
        $sql="SELECT e.nie,e.nom,e.prenom,IF(e.sexe=1,'H','F') AS sexe".$s.
        " FROM inscription i 
        INNER JOIN etudiant e on i.etudiant_nie=e.nie 
        WHERE i.AU_id= ? AND i.NIV_id=? AND i.GP_id=? AND i.abandon=? ORDER BY e.nom,e.prenom ASC";
        $stmt=$db->prepare($sql);
        $stmt->execute([intval($au),intval($niv),intval($gp),$abd]);
        $res= $stmt->fetchAll();
        echo utf8_decode('NIE;Nom;Prenoms;Sexe'.$stitle);
        foreach ($res as $item) {
            $s='';
            foreach ($ls_alias as $value) { $s.=';'.$item[$value]; }
            echo "\n".$item['nie'].';'.utf8_decode($item['nom']).';'.utf8_decode($item['prenom']).';'.$item['sexe'].utf8_decode($s);
        }
        
    }
  
    public static function exportAll($txt,$au,$niv=-1,$is_abd='false')
    {
        header('Content-Type: text/csv;');
        header("Content-Disposition: attachement; filename=$txt.csv;");
        $ls_filter=[
            'em'=>'email','dn'=>'datenaiss','ln'=>'lieunaiss','ce'=>'contact','cp'=>'contact_p',
            'npp'=>'pere','npm'=>'mere','npt'=>'tuteur'
        ];
        $lsTitle=[
            'em'=>'Email',
            'dn'=>'Date de naissance','ln'=>'Lieu de naissance',
            'ce'=>'Contacts étudiants','cp'=>'Contacts parents',
            'npp'=>'PÈRE','npm'=>'MÈRE','npt'=>'TUTEUR'];
        $cp=($_SESSION['type']=='devmaster')?'CONCAT(e.contacte_p,"|",e.contacte_m,"|",e.contacte_t)':'CONCAT(e.contacte_p,",",e.contacte_m)';
        $abd=($is_abd==='false')?0:1;
        
        $lsSql=[
            'em'=>'e.email',
            'dn'=>"DATE_FORMAT(e.datenaiss,'%d/%m/%Y') as datenaiss",
            'ln'=>'e.lieunaiss',
            'ce'=>'e.contacte as contact',
            'cp'=>$cp.' as contact_p',
            'npp'=>'CONCAT(e.nom_p," ",e.prenom_p) as pere',
            'npm'=>'CONCAT(e.nom_m," ",e.prenom_m) as mere',
            'npt'=>'CONCAT(e.nom_t," ",e.prenom_t) as tuteur'
        ];
        $s='';$stitle='';
        $ls_alias=[];
        if (isset($_POST['fm'])) {
            $filter=$_POST['fm'];
            foreach ($filter as $value) {
                $ls_alias[]=$ls_filter[$value];
                $s.=','.$lsSql[$value];
                $stitle.=';'.$lsTitle[$value];
            }
        }
        $db=Database::getConnection();
        $niv=intval($niv);
        $cniv=($niv!=-1)?' AND i.NIV_id=?':'';
        $sql="SELECT n.nom_niv,p.nom_gp,e.nie,e.nom,e.prenom,IF(e.sexe=1,'H','F') AS sexe".$s.
        " FROM inscription i 
        INNER JOIN etudiant e on i.etudiant_nie=e.nie 
        INNER JOIN niv n on i.niv_id=n.idniv 
        INNER JOIN gp p on i.gp_id=p.idgp 
        WHERE i.AU_id= ?".$cniv." AND i.abandon=? ORDER BY n.nom_niv,p.nom_gp,e.nom,e.prenom ASC";
        $stmt=$db->prepare($sql);
        $params=($niv!=-1)?[intval($au),intval($niv),$abd]:[intval($au),$abd];
        $stmt->execute($params);
        $res= $stmt->fetchAll();
        echo utf8_decode('Niveau;Groupes|Parcours;NIE;Nom;Prenoms;Sexe'.$stitle);
        foreach ($res as $item) {
            $s='';
            foreach ($ls_alias as $value) { $s.=';'.$item[$value]; }
            echo "\n".$item['nom_niv'].';'.$item['nom_gp'].';'.$item['nie'].';'.utf8_decode($item['nom']).';'.utf8_decode($item['prenom']).';'.$item['sexe'].utf8_decode($s);
        }
        
    }
  
    
   

    

    
    
}