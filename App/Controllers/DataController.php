<?php
use App\Core\Conf;
use App\Core\Alert;
use App\Core\Utils;
use App\Core\Database;
use App\Models\AbModel;
use App\Models\AuModel;
use App\Models\DoModel;
use App\Models\FsModel;
use App\Models\GpModel;
use App\Models\MbModel;
use App\Models\SbModel;
use App\Core\Controller;
use App\Models\NatModel;
use App\Models\NivModel;
use App\Models\DossierModel;
use App\Models\RecruteurModel;
use App\Models\TrancheFsModel;
use App\Models\InscriptionModel;

class DataController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    private static $pdo;
    var $marge_au=[2013,2025],$au,
        $niv=['L1','L2','L3','M1','M2'],
        $gp=['TC','IRD','BANCASS','MEGP','IMP','MIAGE','QUADD'],
        $nat=['MALAGASY','GABONAISE','CHINOISE'],
        $marge_bacc=[2000,2025],
        $ab,$mb=['Sans Mention','Assez-Bien','Bien','Très Bien','Excellent'],
        $sb=['A1','A2','C','D','G1','G2','G3'],
        $do=['BACC','DTS','BTS','DUT','LICENCE','MAITRISE'],
        $attr_salle=['numSALLE','etage'],
        $salle=[
            ['A003','HALL'],
            ['A101-102','ETAGE 1'],
            ['A103-104','ETAGE 1'],
            ['A107','ETAGE 1'],
            ['A201','ETAGE 2'],
            ['INFO','ETAGE 2'],
            ['AMPHI',''],
            ['LABO','']
        ],
        $justification=['Embouteillage','Reveil tartif','RDV chez le docteur','Malade','Problème personnel'],
        $credit_mat=[],
        $tranchefs=[1,3,5,10],
        $attr_dossier=['notation','nom_dos'],
        $dossier=[
            ['FI','Fiche d\'inscription'],
            ['LM','Lettre de motivation'],
            ['LE','Lettre d\'engagement'],
            ['BN','Bulletin de naissance'],
            ['CIN','CIN'],
            ['Q4P','4 Photos'],
            ['CR','Certificat de résidence'],
            ['NS','Note Seconde'],
            ['NP','Note Première'],
            ['NT','Note Terminal'],
            ['NB','Note Bacc'],
            ['NL1','Note L1'],
            ['NL2','Note L2'],
            ['NL3','Note L3'],
            ['NM1','Note M1'],
            ['DB','Diplôme Bacc'],
            ['DL','Diplôme Licence']
        ],
        $attr_recruteur=['nom_rec','prenom_rec','sexe_rec','email_rec','poste_rec'],
        $recruteur=[
            ['RAMANANARIVO','Romaine',0,'r.ramananarivo@esmia-mada.com','DG'],
            ['RAMANANARIVO','Sylvain',1,'s.ramananarivo@esmia-mada.com','DGA'],
            ['RAKOTONDRAHANTA','Ndriambolanirina',1,'rqual@esmia-mada.com','DAQCOM'],
            ['RAMANANARIVO','Aina Rosy',0,'directiondesetudes@esmia-mada.com','DE'],
            ['RAMPANANA','Jess',1,'scolarite2@esmia-mada.com','SPDE']
        ],
        $grade_prof=['LICENCE','DEA','MASTER','DOCTORAT'],
        $attr_user=['username','password','nom','prenom','sexe','email','tu_id'],
        $user=[
            ['dm','123','RAKOTOARIVO','Lova Harison',1,'informatique@esmia-mada.com',1],
            ['Rosy','123','RAMANANARIVO','Aina Rosy',0,'directiondesetudes@esmia-mada.com',2],
            ['Mbola','123','RAKOTONDRAHANTA','Mbola',1,'rqual@esmia-mada.com',2],
            ['Jess','123','RAMPANANA','Jess',1,'scolarite2@esmia-mada.com',3],
            ['Felana','123','RAFIDIMANANA','Felana',0,'scolarite1@esmia-mada.com',3],
            ['Myrja','123','RAMIARAMANANA','Mirja',0,'contacte@esmia-mada.com',3],
        ],
        $tuser=['devmaster','admin','standard'];
    public function index(){
        $header['title']='Réinitialisation des données';
        $header['current_menu']='AUTRES';
        $header['js']='/src/adm_data';
        $this->renderH($header);
        $this->render('index');
        $this->renderF();
    }
    private function initCredit(){
        $ls=[];
        for ($i=1; $i <=30; $i++) { 
            array_push($ls,$i);
        }
        $this->credit_mat=$ls;
    }
    private function initAU(){
        $sa=$this->marge_au[0];
        $ea=$this->marge_au[1];
        $ls=[];
        for ($i=$sa; $i <= $ea; $i++) { 
            $ls[]=$i.'-'.($i+1);
        }
        $this->au=$ls;
    }
    private function initBacc(){
        $sa=$this->marge_bacc[0];
        $ea=$this->marge_bacc[1];
        $ls=[];
        for ($i=$sa; $i <= $ea; $i++) { 
            $ls[]=$sa++;
        }
        $this->ab=$ls;
    }

    public function generateGP(){
        //$gp=['TC','IRD','BANCASS','MEGP','IMP','MIAGE','QUADD'],
        $nbp=14;$nbl=8;$nbm=4;
        $gpp=array_slice($this->gp,0,2);
        $gpl=array_slice($this->gp,2,2);
        $gpm=array_slice($this->gp,4);
        $ls=[];
        foreach ($gpp as $item) {
            for ($i=1; $i <= $nbp; $i++) { 
                array_push($ls,"$item$i");
            }
        }
        foreach ($gpl as $item) {
            for ($i=1; $i <= $nbl; $i++) { 
                array_push($ls,"$item$i");
            }
        }
        foreach ($gpm as $item) {
            for ($i=1; $i <= $nbm; $i++) { 
                array_push($ls,"$item$i");
            }
        }
        $this->gp=array_merge($this->gp,$ls);
    }
    
    private function add($table,$data,$ppts,$reset=true){
        $db=Database::getConnection();
        $db->exec("DELETE FROM $table;");
        if($reset){
            $db->exec("ALTER TABLE $table AUTO_INCREMENT =1;");
        }
        $db->beginTransaction();
        $nbi=0;

        if (is_array($ppts)) {
             //[nom,prenom] -> insert into $table values(nom,prenom) :nom,:prenom
            $alias=implode(',:',$ppts);
            $alias=':'.$alias;
            $attr=implode(',',$ppts);
            
            $sql='insert into '.$table.'('.$attr.')'.' values('.$alias.');';
            foreach ($data as $value) {
                $list=array_combine($ppts,$value);
                $stmt=$db->prepare($sql);
                if ($stmt->execute($list)) {
                    $nbi++;
                }
            }
        } else {
            $sql='insert into '.$table.'('.$ppts.')'.' values(?);';
            foreach ($data as $value) {
                $stmt=$db->prepare($sql);
                $stmt->bindParam(1,$value);
                if ($stmt->execute()) {
                    $nbi++;
                }
            }
        }
        if($nbi==count($data)){
            $db->commit();
            echo ' => <i class="text-primary">'.$table."</i> OK !<br>";
            return true;
        }else{
            $db->rollback();
            echo ' => <i class="text-danger">'.$table."</i> KO !<br>";
            return false;
        }
        
    }

    private function getAllSql($lsTable){
        $s='';
        foreach ($lsTable as  $item) {
            $s.="DELETE FROM $item;";
        }
        return $s;
    }

    private function getResetAISql($lsTable){
        $s='';
        foreach ($lsTable as  $item) {
            $s.="ALTER TABLE $item AUTO_INCREMENT =1;";
        }
        return $s;
    }

   //SEMESTRE[NIV] ,GP[NIV,AU],DOSSIER[NIV]

    public function init(){
        $this->generateGP();
        $this->initCredit();
        $this->initAU();
        $this->initBacc();
        $db=Database::getConnection();
        $sql1=$this->getAllSql(['presence','tcours','delegues','fs','inscription','etudiant','matiere','ue','professeur','gp_has_au','niv_has_dos','semestre','user']);
        $sql2=$this->getResetAISql(['semestre','inscription','professeur','matiere','ue','presence','tcours']);
        $db->exec($sql1.$sql2);
        $this->add('au',$this->au,'nom_au');
        $this->add('niv',$this->niv,'nom_niv');
        $this->add('gp',$this->gp,'nom_gp');
        $this->add('nat',$this->nat,'nationalite');
        $this->add('ab',$this->ab,'annee');
        $this->add('sb',$this->sb,'serie');
        $this->add('mb',$this->mb,'mention');
        $this->add('do',$this->do,'diplome');
        $this->add('gr',$this->grade_prof,'nom_gr');
        $this->add('justification',$this->justification,'motif');
        $this->add('credit_mat',$this->credit_mat,'credit');
        $this->add('tranchefs',$this->tranchefs,'nbT');
        $this->add('dossier',$this->dossier,$this->attr_dossier);
        $this->add('salle',$this->salle,$this->attr_salle,false);
        $this->add('recruteur',$this->recruteur,$this->attr_recruteur);
        $this->add('type_user',$this->tuser,'type_tu');
        $this->add('user',$this->user,$this->attr_user);
        $this->addSEMESTRE();
        $this->addAU_GP();
        $this->addDOSSIER_NIV();

        // if ($rau && $rniv && $rgp && $rnat && $rab && $rsb && $rmb && $rdo && $rtf && $rdos && $rsal && $rrec) {
            
        //     echo 'Data init : OK !';
        // } else {
        //     echo 'Data init : ERROR !';
        // }

    }

    public static function getPDO() : PDO
    {
        if(self::$pdo == null){
            self::$pdo = new PDO('mysql:host='.Conf::$db['hostname'], Conf::$db['username'],Conf::$db['password'],
                [ PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC ]
            );           
        }
        return self::$pdo;
    }
    
    public function createDB(){
        $user = 'newuser';
        $pass = 'newpass';
        $db = "db_teste";

        try {
            $dbh = self::getPDO();
            $dbh->exec("CREATE DATABASE `$db`;
                    CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                    GRANT ALL ON `$db`.* TO '$user'@'localhost';
                    FLUSH PRIVILEGES;")
            or die(print_r($dbh->errorInfo(), true));
            echo 'create DB OK!';

        }
        catch (PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }
    }

    public function dropDB(){
        $db = "db_teste";
        try {
            $dbh = self::getPDO();
            $dbh->exec("DROP DATABASE `$db` ;")
            or die(print_r($dbh->errorInfo(), true));
            echo 'Drop DB OK!';

        }
        catch (PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }
    }
    public function showDB(){
        try {
            $dbh = self::getPDO();
            $stmt = $dbh->query('SHOW DATABASES');
            $res = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach($res as $item){
                echo '<p>'.$item.'</p>';
            }

        }
        catch (PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }
    }

    //Purge data
    public function purgeTable(){
       
        $con= Database::getConnection();
        $sql="DROP TABLE IF EXISTS teste,presence,tcours,justification,salle,
        attribuer,attribuer_autre_n,cloturation,note,autre_note,moyenneue,moyenne,
        gp_has_au,niv_has_dos,dossier;
        DROP TABLE IF EXISTS user_prof,professeur,gr,matiere,ue;
        DROP TABLE IF EXISTS fs,delegues,semestre,session;
        DROP TABLE IF EXISTS inscription,tranchefs,au,niv,gp,do;
        DROP TABLE IF EXISTS etudiant,nat,ab,sb,mb,recruteur;
        DROP TABLE IF EXISTS user_note,type_user_note,candidat,rdv,user,type_user;";
        $res=$con->exec($sql);
        if ($res=='0'){
            echo '</br>=><i class="text-info">Purge All Table OK</i>';
        } else {
            echo '</br>=><i class="text-danger">Purge All Table KO</i>';
        }
        
    }

   
    public function addAU_GP(){
       
        $gp_1819_l1=['TC','TC1','TC2','TC3','TC4','TC5','IRD','IRD1','IRD2','IRD3'];
        $gp_1819_l2=['BANCASS','IRD','IRD1','IRD2','MEGP1','MEGP2'];
        $gp_1819_l3=['BANCASS','IRD','MEGP','MEGP1','MEGP2'];
        $gp_1819_m1=['IMP','MIAGE'];
        $gp_1819_m2=['TC'];

        $gp_1920_l1=['TC','TC1','TC2','TC3','TC4','TC5','IRD1','IRD2','IRD3'];
        $gp_1920_l2=['BANCASS','IRD1','IRD2','MEGP1','MEGP2'];
        $gp_1920_l3=['BANCASS','IRD','IRD1','IRD2','MEGP1','MEGP2'];
        $gp_1920_m1=['IMP','MIAGE'];
        $gp_1920_m2=['TC'];
        
        $ls=[
            $gp_1819_l1,$gp_1819_l2,$gp_1819_l3,$gp_1819_m1,$gp_1819_m2,
            $gp_1920_l1,$gp_1920_l2,$gp_1920_l3,$gp_1920_m1,$gp_1920_m2
        ];
        //1
        //1314:1 1415:2 1516:3 1617:4 1718:5 1819:6 1920:7 20
        //L1-M2 : 1-5
        
        
        $db=Database::getConnection();
        $sql='insert into gp_has_au (AU_id,NIV_id,GP_id) values(?,?,?) ;';
        $stmt=$db->prepare($sql);
        $k=0;
        //AU 1819: 6 , 1920:7
        $aus_id=$this->getId('au',['idAU','nom_au'],['2018-2019','2019-2020']);
        $s=$aus_id['2018-2019'];$e=$aus_id['2019-2020'];
        for ($i=$s; $i <= $e; $i++) { 
            for ($j=1; $j <= 5; $j++) { 
                $nivs_id=$this->getId('gp',['idGP','nom_gp'],$ls[$k]);
                foreach ($nivs_id as $key => $value) {
                    $stmt->execute([$i,$j,$value]);
                }
                $k++;
                continue;
            }
        }
        echo ' => <i class="text-primary">GP par Année Universitaire</i> OK !<br>';
        
       
        

    }

    public function addDOSSIER_NIV(){
        $dos_commun=['FI','LM','LE','Q4P','CR','BN'];
        $dos_l1=['NS','NP','NT','NB','DB'];
        $dos_l2=['DB','NB','NL1'];
        $dos_l3=['DB','NB','NL1','NL2'];
        $dos_m1=['DB','NL1','NL2','NL3','DL'];
        $dos_m2=['DB','NL1','NL2','NL3','DL','NM1'];
        $dos_l1=array_merge($dos_commun,$dos_l1);
        $dos_l2=array_merge($dos_commun,$dos_l2);
        $dos_l3=array_merge($dos_commun,$dos_l3);
        $dos_m1=array_merge($dos_commun,$dos_m1);
        $dos_m2=array_merge($dos_commun,$dos_m2);
        $ls=[$dos_l1,$dos_l2,$dos_l3,$dos_m1,$dos_m2];
        $db=Database::getConnection();
        $sql='insert into niv_has_dos (NIV_id,DOS_id) values(?,?) ;';
        $stmt=$db->prepare($sql);
        $k=0;
        for ($i=1; $i <= 5; $i++) { 
            $doss_id=$this->getId('dossier',['idDOS','notation'],$ls[$k]);
            foreach ($doss_id as $key => $value) {
                $stmt->execute([$i,$value]);
            }
            $k++;
            continue;
            
        }
        echo ' => <i class="text-primary">Dossier par Niveau</i> OK !<br>';

    }

    public function addSEMESTRE(){
        $l1=[1,2];
        $l2=[3,4];
        $l3=[5,6];
        $m1=[7,8];
        $m2=[9,10];
        $ls=[ $l1,$l2,$l3,$m1,$m2];
        $db=Database::getConnection();
        $sql='insert semestre (NIV_id,notation,nom_sem) values(?,?,?) ;';
        $stmt=$db->prepare($sql);
        $k=0;
        for ($i=1; $i <= 5; $i++) { 
            $sem=$ls[$i-1];
            foreach ($sem as $value) {
                $nom_sem='SEMESTRE '.$value;
                $notation='S'.$value;
                $stmt->execute([$i,$notation,$nom_sem]);
                
            }
            continue;
            
        }
        echo ' => <i class="text-primary">Semestre par Niveau</i> OK !<br>';

    }

    private function getId($table,$attr,$data,$AI=true){
        $db=Database::getConnection();
        $id=$attr[0];
        $nom_attr=$attr[1];
        $sql='select '.$id.' from '.$table.' where '.$nom_attr.'=?;';
        $stmt=$db->prepare($sql);
        if (is_array($data)) {
            $ls=[];
            foreach ($data as $value) {
                $stmt->bindParam(1,$value);
                $stmt->execute();
                $res=$stmt->fetch();
                $ls[$value]=($AI)?intval($res[$id]):$res[$id];
            }
            return $ls;
        } else {
            $stmt->bindParam(1,$data);
            $stmt->execute();
            $res=$stmt->fetch();
            $ls[$data]=($AI)?intval($res[$id]):$res[$id];
            return $ls;
        }
       
        
    }


    



    




}

