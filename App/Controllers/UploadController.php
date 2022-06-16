<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\AuModel;
use App\Models\NivModel;
use App\Models\GpModel;
use App\Models\NatModel;
use App\Models\AbModel;
use App\Models\MbModel;
use App\Models\SbModel;
use App\Models\DoModel;
use App\Models\DossierModel;
use App\Models\TrancheFsModel;
use App\Models\RecruteurModel;
use App\Models\EtudiantModel;
use App\Models\InscriptionModel;
class UploadController extends Controller{
    const UPLOAD_DIR='assets/upload_files/',
    EXTS=['csv'],
    //ABD	NIE	Nom	Prenom(s)	Sexe	Date de Naissance	Lieu de Naissance	Adresse	Contactes	Email	
    //Nom	Prenom	ProfessionP	Adresse	Contactes	
    //Nom	Prenom	Profession	Adresse	Contactes	
    //Nationalité	Année	Serie	Mention	Poste REC	Date REC

    EPPTS=['abandon','nie','nom','prenom','sexe','datenaiss','lieunaiss','adresse','contacte','email',
    'nom_p','prenom_p','profession_p','adresse_p','contacte_p',
    'nom_m','prenom_m','profession_m','adresse_m','contacte_m',
    'nat_id','ab_id','sb_id','mb_id','rec_id','daterec','photo'],
    IPPTS=['etudiant_nie','au_id','niv_id','gp_id','do_id','do_en','ep','list_dossier','di','reste_di','dateinscr','tranchefs_id'];

    var $ls_au,$ls_niv,$ls_gp,$ls_nat,$ls_ab,$ls_mb,$ls_sb,$ls_do,$ls_trfs,$ls_rec,$ls_dos;
    var $ls_abd=['OUI'=>1,'NON'=>0];
    var $ordre_dossier=['FI','LE','LM','Q4P','BN','CIN','NS','NP','NT','NB'];
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']="Upload Fichier";
        $header['current_menu']='AUTRES';
        $header['js']=['/src/cplugs','/upls/uploads'];
        $header['css']=['/src/inc'];
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('index');
        $this->renderF();
    }
    public function abandon(){
        $header['title']="Upload ABD";
        $header['current_menu']='AUTRES';
        $header['js']=['/src/cplugs','/upls/abd','/src/toastr.min'];
        $header['css']=['/src/inc','/src/toastr'];
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('abandon');
        $this->renderF();
    }

    public function check(){
        Utils::HeaderJs();
        Utils::PAuth();
        //file_data
        $this->importAction('file_data');

    }

    public function abd_check(){
        // Utils::HeaderJs();
        $name='file_data';
        $filename=$_FILES[$name]['name'];
        $error=$_FILES[$name]['error'];
        if (!empty($filename && $error==0)) {
            $fileType=pathinfo($filename,PATHINFO_EXTENSION);
            $fileType=strtolower($fileType);
            if(!in_array($fileType,self::EXTS)){
                echo 'Fichier non valide !';
            }else{
                $db=Database::getConnection();
                $sql='UPDATE inscription AS i INNER JOIN etudiant e ON e.nie=i.ETUDIANT_nie INNER JOIN au a ON a.idAU=i.AU_id
                INNER JOIN niv n ON n.idNIV=i.NIV_id INNER JOIN gp g ON g.idGP=i.GP_id
                SET i.abandon=:abd WHERE a.nom_au=:au AND n.nom_niv=:niv AND g.nom_gp=:gp AND e.nie=:nie';
                $db->beginTransaction();
                $stmt=$db->prepare($sql);
                $fichier=fopen($_FILES[$name]['tmp_name'],'r');
                fgetcsv($fichier,0,';');
                $nbok=0;
                $nbl=0;
                try {
                    while ($data=fgetcsv($fichier,0,';')) {
                        $nbl++;
                        $stmt->bindValue(':abd',$this->ls_abd[$data[4]]);
                        $stmt->bindValue(':au',$data[0]);
                        $stmt->bindValue(':niv',$data[1]);
                        $stmt->bindValue(':gp',$data[2]);
                        $stmt->bindValue(':nie',$data[3]);
                        $stmt->execute();
                        if ($stmt->execute()) {
                            $nbok++;
                        }
                    }
                    if ($nbl==$nbok) {
                        $db->commit();
                        echo 'ok';
                    } else {
                        $db->rollBack();
                        echo 'ko';
                    }
                    
                } catch (Exception $ex) {
                    $db->rollBack();
                    echo 'ko';
                }
            }

        }else{
            echo 'pas de fichier';
        }
    }
   
    private function getUtils(){
        $au=AuModel::getList();//idau,nom_au
        $niv=NivModel::getList();//idniv,nom_niv
        $gp=GpModel::getList();//idgp,nom_gp
        $this->ls_au=$this->setKey($au,'idAU','nom_au');
        $this->ls_niv=$this->setKey($niv,'idNIV','nom_niv');
        $this->ls_gp=$this->setKey($gp,'idGP','nom_gp');
    }

    private function getAllData(){
        $au=AuModel::getList();//idau,nom_au
        $niv=NivModel::getList();//idniv,nom_niv
        $gp=GpModel::getList();//idgp,nom_gp
        $nat=NatModel::getList();//idnat,nationalite
        $ab=AbModel::getList();//idab,annee
        $mb=MbModel::getList();//idmb,mention
        $sb=SbModel::getList();//idsb,serie
        $dos=DossierModel::getList();//idsb,serie
        $do=DoModel::getList();//iddo,diplome
        $trfs=TrancheFsModel::getList();//idt,nbt
        $rec=RecruteurModel::getList();//idrec,poste_rec
        $this->ls_au=$this->setKey($au,'idAU','nom_au');
        $this->ls_niv=$this->setKey($niv,'idNIV','nom_niv');
        $this->ls_gp=$this->setKey($gp,'idGP','nom_gp');
        $this->ls_nat=$this->setKey($nat,'idNAT','nationalite');
        $this->ls_ab=$this->setKey($ab,'idAB','annee');
        $this->ls_mb=$this->setKey($mb,'idMB','mention');
        $this->ls_sb=$this->setKey($sb,'idSB','serie');
        $this->ls_dos=$this->setKey($dos,'idDOS','notation');
        $this->ls_do=$this->setKey($do,'idDO','diplome');
        $this->ls_trfs=$this->setKey($trfs,'idT','nbT');
        $this->ls_rec=$this->setKey($rec,'idREC','poste_rec');
        
    }
   

    private function setKey($list,$key,$value){
        //idau,nom_au
        $ls=[];
        foreach ($list as  $item) {
            $n=$item[$value];
            $ls[$n]=intval($item[$key]);
        }
        return $ls;

    }
    public function a(){
        $this->getUtils();
        var_dump($this->ls_au['2020-2021']);

    }
    private function getSQL($table,$ppts){
        $a1=implode(',',$ppts);
        $s1='?';
        for ($i=1; $i < count($ppts); $i++) { 
            $s1.=',?';
        }
        return 'insert into '.$table.' ('.$a1.') values ('.$s1.');';

    }

    private function importAction($name){
        $filename=$_FILES[$name]['name'];
        $error=$_FILES[$name]['error'];
        if (!empty($filename && $error==0)) {
            $fileType=pathinfo($filename,PATHINFO_EXTENSION);
            $fileType=strtolower($fileType);
            if(!in_array($fileType,self::EXTS)){
                return 'Fichier non valide !';
            }else{
                $this->getAllData();
                $db=Database::getConnection();
                //$db->exec('DELETE FROM inscription;ALTER TABLE inscription AUTO_INCREMENT =1;DELETE FROM etudiant;');
                $sqlE=$this->getSQL('etudiant',self::EPPTS);
                $sqlI=$this->getSQL('inscription',self::IPPTS);
                $db->beginTransaction();
                $stmtE=$db->prepare($sqlE);
                $stmtI=$db->prepare($sqlI);
                $fichier=fopen($_FILES[$name]['tmp_name'],'r');
                $dataHeader=fgetcsv($fichier,0,';');
                $au=$this->ls_au[$dataHeader[0]];
                $niv=$this->ls_niv[$dataHeader[1]];
                $gp=$this->ls_gp[$dataHeader[2]];
                $Header=fgetcsv($fichier,0,';');
                $inat=20;$iab=21;$isb=22;$imb=23;$irec=24;
                $nbi=0;$nbligne=0;$nbError=0;$lsNotif=[];
                $lsEncode=[1,2,3,6,7,9,10,11,12,13,15,16,17,18,20,22,23,24,26,27,28];
                $lsToInt=[0,4,39,40,42];
                try {
                    while($data = fgetcsv($fichier,0,';')){
                        $this->parseInt($data,$lsToInt);
                        $this->encode($data,$lsEncode);
                        $existE=EtudiantModel::isExist($data[1],$data[2],$data[3],$data[5]);
                        if ($existE===false) {
                            $inscr =[
                                //'etudiant_nie','au_id','niv_id','gp_id'
                                $data[1],$au,$niv,$gp,
                                //'do_id','do_en','ep','list_dossier','di','reste_di','dateinscr','nbt'
                                $this->ls_do[$data[26]], $data[27], $data[28],
                                $this->parseDossier($data,29,38),
                                $data[39],$data[40],$data[41],
                                $this->ls_trfs[$data[42]]
                            ];
                            $data[$inat]=$this->ls_nat[$data[$inat]];
                            $data[$iab]=$this->ls_ab[$data[$iab]];
                            $data[$isb]=$this->ls_sb[$data[$isb]];
                            $data[$imb]=$this->ls_mb[$data[$imb]];
                            $data[$irec]=$this->ls_rec[$data[$irec]];
                            //unset 29-38
                            $data[43]=($data[43]=="1")?"{$data[1]}.jpg":null;
                            $this->unset_range($data,26,42);
                            $etudiant=array_values($data);
                            if ($stmtE->execute($etudiant) && $stmtI->execute($inscr)) {
                                $nbi++;
                                $this->addNotif($lsNotif,$data);
                            }
                            $nbligne++;
                            

                        } else {
                            $inscr_exist=InscriptionModel::isExist($data[1],$au,$niv,$gp);
                            
                            if ($inscr_exist===false) {
                                $inscr =[
                                    //etudiant_nie','au_id','niv_id','gp_id'
                                    $data[1],$au,$niv,$gp,
                                    //'do_id','do_en','ep','list_dossier','di','reste_di','dateinscr','nbt'
                                    $this->ls_do[$data[26]], $data[27], $data[28],
                                    $this->parseDossier($data,29,38),
                                    $data[39],$data[40],$data[41],
                                    $this->ls_trfs[$data[42]]
                                ];
                                if ($stmtI->execute($inscr)) {
                                    $nbi++;
                                    $this->addNotif($lsNotif,$data,$nbError);
                                }
                                $nbligne++;
                            }else{
                                $nbError++;
                                $this->addNotif($lsNotif,$data,$nbError);
                            }

                        }
                        
                    }
                    if ($nbi==$nbligne) {
                        $db->commit();
                        if ($nbError==0) {
                            $s='IMPORTATION DATA OK!';
                            Alert::get('info',$s,$lsNotif);
                        } else {
                            $s1='IMPORTATION DATA OK! (avec quelques erreurs echappées)';
                            Alert::get('warning',$s1,$lsNotif);
                            
                        }
                    } else {
                        $db->rollback();
                        Alert::get('danger','IMPORTATION DATA ERROR!');
                    }
                } catch (\PDOException $ex) {
                    $db->rollback();
                }
                fclose($fichier);
                
                
            }
        }else{
            return 'Pas de fichier !';
        } 
    }

    private function addNotif($lsNotif,$data,$nbError=null){
        if ($nbError==null) {
            $lsNotif[]=$data[1].' '.$data[2].' '.$data[3].' : ok '."<br>";
        } else {
            $lsNotif[]="doublant ($nbError) :".$data[1].' '.$data[2].' '.$data[3]."<br>";
        }
        
    }
    private function _importAction($name){
        $filename=$_FILES[$name]['name'];
        $error=$_FILES[$name]['error'];
        if (!empty($filename && $error==0)) {
            $fileType=pathinfo($filename,PATHINFO_EXTENSION);
            $fileType=strtolower($fileType);
            if(!in_array($fileType,self::EXTS)){
                return 'Fichier non valide !';
            }else{
                $this->getAllData();
                $db=Database::getConnection();
                $db->exec('DELETE FROM inscription;ALTER TABLE inscription AUTO_INCREMENT =1;DELETE FROM etudiant;');
                $sqlE=$this->getSQL('etudiant',self::EPPTS);
                $sqlI=$this->getSQL('inscription',self::IPPTS);
                $db->beginTransaction();
                $stmtE=$db->prepare($sqlE);
                $stmtI=$db->prepare($sqlI);
                $fichier=fopen($_FILES[$name]['tmp_name'],'r');
                $dataHeader=fgetcsv($fichier,0,';');
                $au=$this->ls_au[$dataHeader[0]];
                $niv=$this->ls_niv[$dataHeader[1]];
                $gp=$this->ls_gp[$dataHeader[2]];
                $Header=fgetcsv($fichier,0,';');
                $inat=20;$iab=21;$isb=22;$imb=23;$irec=24;
                $nbi=0;$nbligne=0;
                try {
                    while($data = fgetcsv($fichier,0,';')){
                        $this->parseInt($data,[0,4,39,40,42]);
                        $this->encode($data,[2,3,6,7,9,10,11,12,13,15,16,17,18,28]);
                        $inscr =[
                            //'etudiant_nie','au_id','niv_id','gp_id'
                            $data[1],$au,$niv,$gp,
                            //'do_id','do_en','ep','list_dossier','di','reste_di','dateinscr','nbt'
                            $this->ls_do[$data[26]], $data[27], $data[28],
                            $this->parseDossier($data,29,38),
                            $data[39],$data[40],$data[41],
                            $this->ls_trfs[$data[42]]
                        ];
                        $data[$inat]=$this->ls_nat[$data[$inat]];
                        $data[$iab]=$this->ls_ab[$data[$iab]];
                        $data[$isb]=$this->ls_sb[$data[$isb]];
                        $data[$imb]=$this->ls_mb[$data[$imb]];
                        $data[$irec]=$this->ls_rec[$data[$irec]];
                        //unset 29-38
                        $this->unset_range($data,26,42);
                        $etudiant=array_values($data);
                        // $ls=array_combine(self::EPPTS,$etudiant);
                        // $lsi=array_combine(self::IPPTS,$inscr);
                        if ($stmtE->execute($etudiant) && $stmtI->execute($inscr)) {
                            $nbi++;
                        }
                        $nbligne++;
                    }
                    if ($nbi==$nbligne) {
                        $db->commit();
                        echo 'IMPORTATION DATA OK!';
                    } else {
                        $db->rollback();
                        echo 'IMPORTATION DATA ERROR!';
                    }
                } catch (\PDOException $ex) {
                    $db->rollback();
                }
                fclose($fichier);
                
                
            }
        }else{
            return 'Pas de fichier !';
        } 
    }

    private function unset_range(&$ls,$s,$e){
        for ($i=$s; $i <= $e; $i++) { 
            unset($ls[$i]);
        }
    }

    public function _check(){
        Utils::HeaderJS();
        Utils::PAuth();
        $res=$this->uploadAction('file_data');
        if($res=='ok'){
            $location=$_POST['dir_files'];
            $filename=$_POST['filename'];
            Alert::info('Bien uploadé');
        }else{
            Alert::error('Erreur !');
        }

    }

    

    private function uploadAction($name){
        $filename=$_FILES[$name]['name'];
        $error=$_FILES[$name]['error'];
        if (!empty($filename && $error==0)) {
            $fileType=pathinfo($filename,PATHINFO_EXTENSION);
            $fileType=strtolower($fileType);
            $new_filename=Utils::str_random(5).'.'.$fileType;
            $location=self::UPLOAD_DIR.$new_filename;
            if(!in_array($fileType,self::EXTS)){
                return 'Fichier non valide !';
            }else{
                if (move_uploaded_file($_FILES[$name]['tmp_name'],$location)) {
                    $_POST['filename']=$new_filename;
                    $_POST['dir_files']=$location;
                    return 'ok';
                } else {
                    return 'Fichier non déplacé au serveur !';
                }
                
            }
        }else{
            return 'Pas de fichier !';
        } 
    }

    

    //1,2
    private function parseInt(&$ls,$value){
        if (is_array($value)) {
            foreach ($value as $item) {
                $ls[$item]=intval($ls[$item]);
            }
        } else {
            $ls[$value]=intval($ls[$value]);
        }
    }

    private function encode(&$ls,$value){
        if (is_array($value)) {
            foreach ($value as $item) {
                $ls[$item]=utf8_encode($ls[$item]);
            }
        } else {
            $ls[$value]=utf8_encode($ls[$value]);
        }
    }

    private function parseDossier(&$ls,$start,$end){
        for ($i=$start,$j=0; $i <= $end; $i++,$j++) { 
            if ($ls[$i]=='1') {
                $odos=$this->ordre_dossier[$j];//LM
                $res[]=$this->ls_dos[$odos];
            }
        }
        return isset($res)?implode(',',$res):'';
        
    }

    

    

    

    
}