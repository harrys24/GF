<?php
use App\Core\Alert;
use App\Core\Utils;
use App\Core\Database;
use App\Models\FsModel;
use App\Models\GpModel;
use App\Core\Controller;
use App\Models\DataModel;
use App\Models\EtudiantModel;
use App\Models\HistoriqueModel;
use App\Models\InscriptionModel;
use App\Models\DetailTrancheModel;

class InscriptionController extends Controller
{
    public function __construct(){
        parent::__construct();
    }


    public function index(){
        $data=DataModel::getData();
        $header['title']='FICHE D\'INSCRIPTION';
        $header['current_menu']='FICHE D\'INSCRIPTION';
        $header['css']=['jquery-datetime','toggle-btn','/src/form'];
        $header['js']=['jquery-datetime','toggle-btn','moment-with-locales','/src/cplugs','/src/inscr','/src/inscr_form'];
        $this->renderH($header);
        $this->render('index',$data);
        $this->renderF();
    }

    //GET AUTO INCREMENT NIE
    public function checknie(){
        $data= EtudiantModel::getNewNie($_POST['s']);
        echo $data;
    }

    //post
    public function niv_check(){
        Utils::HeaderJS();
        Utils::int_post(['iau','iniv']);
        $data['gp']=GpModel::getListBy($_POST['iau'],$_POST['iniv']);
        $data['dossier']=InscriptionModel::getDossier($_POST['iniv']);
        echo json_encode($data);        
    }

    public function getDetailTranche(){
        Utils::HeaderJS();
        $res= DetailTrancheModel::getDetail($_POST);
        echo json_encode($res);
    }


    public function checkEtudiant(){
        var_dump($_POST);
    }

    //post Inscription Etudiant
    public function _checkEtudiant(){
        header('content-type:text/javascript');        
        //NIE
        $nie=$_POST['nie_saison'].$_POST['nie_annee'].$_POST['nie_num'];
        $_POST['nie']=$nie;
        //Touc
        Utils::UCP(['nom','nom_p','nom_m','nom_t']);
        Utils::UCWP(['prenom','prenom_p','prenom_m','prenom_t']);
        
        //CONTACTES
        DataModel::parseContacte();
        DataModel::parseContacte('_p');
        DataModel::parseContacte('_m');
        DataModel::parseContacte('_t');
        unset($_POST['nie_saison'],$_POST['nie_annee'],$_POST['nie_num']);
        // DataModel::addAutre();
        $etudiant_detail=$nie.' ('.$_POST['sexe'].') '.$_POST['AU'].' : '.$_POST['NIV_GP'].' - '.$_POST['nom'].' '.$_POST['prenom'];
        //PHOTO
        DataModel::uploadPhoto_Etudiant();
        //TO INT
        Utils::int_post(['AU_id','NIV_id','GP_id','AB_id','SB_id','MB_id','REC_id','TrancheFS_id','nbTranche','DI','Reste_DI']);
        //TO BOOLEAN
        $_POST['sexe']=($_POST['sexe']=='H')?1:0;
        Utils::check_post(['abandon']);
        DataModel::parseDate(['dateNaiss','dateRec','dateInscr']);
        //INSCRIPTION
        $_POST['ETUDIANT_nie']=$nie;
        if(empty($_POST['num_matr']) ){
            $this->addE($etudiant_detail);
        }else {
            $this->updateE($etudiant_detail);
        }
        
        
    }

    public function checkOV()
    {
        header('Content-Type:text/javascript');
        Utils::Exist(['tb','txt']);
        Utils::UCP('txt');
        $ls=[
            'nat'=>['nationalite','idNAT'],
            'sb'=>['serie','idSB'],
            'do'=>['diplome','idDO']
        ];
        $tb=$_POST['tb'];$id=$ls[$tb][1];$value=$ls[$tb][0];
        $sql='SELECT '.$id.' FROM '.$tb.' WHERE '.$value.'=?';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST['txt']]);
            $res=$stmt->fetch();
            if ($res) {
                echo json_encode(['color'=>'success','message'=>'Bien Vérifié','id'=>$res[$id]]);
            } else {
                $sql='INSERT INTO '.$tb.'('.$value.') VALUES (?);';
                $stmt = $db->prepare($sql);
                $stmt->execute([$_POST['txt']]);
                $lastId=$db->lastInsertId();
                $sql='SELECT '.$id.' AS id, '.$value.' AS txt FROM '.$tb.' ORDER BY '.$value.' ASC';
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $data=$stmt->fetchAll();
                echo json_encode(['color'=>'success','message'=>'Bien Vérifié','id'=>$lastId,'data'=>$data]);
            }
            
        } catch (\PDOException $ex) {
            echo json_encode(['color'=>'danger','message'=>$ex->getMessage()]);
        }
    }

    public function generatePwd(){
        // 'password'=>Utils::str_random(7),
        // 'INSCR_num_matr'=>$_POST['ni']
    }

    
    //update student
    private function updateE($detail){
        try {
            Utils::int_post('num_matr');
            $num_matr=$_POST['num_matr'];
            $nbT=$_POST['nbTranche'];
            $db=Database::getConnection();
            if($_POST['_nie']!=$_POST['nie']){
                $etudiant=EtudiantModel::get($_POST['nie']);
                if($etudiant){
                    echo json_encode(['color'=>'danger','message'=>'ce NIE appartient à '.$etudiant['nom'].' '.$etudiant['prenom'],'status'=>'ko']);
                    die();
                }
            }
            $etudiant=InscriptionModel::getCheckEtudiant($_POST['num_matr']);
            
            $info='';
            // $etudiant['idAU']=intval($etudiant['idAU']);
            // $etudiant['idNIV']=intval($etudiant['idNIV']);
            // $etudiant['idGP']=intval($etudiant['idGP']);
            // $etudiant['idT']=intval($etudiant['idT']);
            // $etudiant['abandon']=intval($etudiant['abandon']);

            // var_dump($etudiant,$_POST['AU_id'],$_POST['NIV_id'],$_POST['GP_id'],$_POST['TrancheFS_id'],$_POST['nie'],$_POST['abandon']
            // ,$_POST['nom'],$_POST['prenom'],$_POST['sexe'],$_POST['datenaiss']);

            if ($etudiant['idAU']!=$_POST['AU_id']) {
                $info='AU : '.$etudiant['AU'].' > '.$_POST['AU'].'\n';
            }
            if ($etudiant['idNIV']!=$_POST['NIV_id'] || $etudiant['idGP']!=$_POST['GP_id']) {
                $info.='NIV : '.$etudiant['NIV_GP'].' > '.$_POST['NIV_GP'].'\n';
            }
            if ($etudiant['idT']!=$_POST['TrancheFS_id']) {
                $info.='Nb Tranche : '.$etudiant['nbT'].'x > '.$_POST['nbTranche'].'x\n';
            }
            if ($etudiant['nie']!=$_POST['nie']) {
                $info.='NIE : '.$etudiant['nie'].' > '.$_POST['nie'].'\n';
            }
            if ($etudiant['abandon']!=$_POST['abandon']) {
                $_POST['abandon']=($_POST['abandon'])?'OUI':'NON';
                $etudiant['abandon']=($etudiant['abandon'])?'OUI':'NON';
                $info.='ABANDON : '.$etudiant['abandon'].' > '.$_POST['abandon'].'\n';
            }
            if ($etudiant['nom']!=$_POST['nom']) {
                $info.='NOM : '.$etudiant['nom'].' > '.$_POST['nom'].'\n';
            }
            if ($etudiant['prenom']!=$_POST['prenom']) {
                $info.='PRENOM : '.$etudiant['prenom'].' > '.$_POST['prenom'].'\n';
            }
            if (mb_strlen($info)==0) {
                $info='Simple édition';
            }
            $db->beginTransaction();
            $etudiant=new EtudiantModel();
            $etudiant->parse($_POST);
            $ue= $etudiant->update($_POST['nie']);
    
            $inscr=new InscriptionModel();
            $inscr->parse($_POST);
            $ui= $inscr->update();
            HistoriqueModel::insertData('EDITION',$detail,$info);
            if (isset($_POST['sd'])) {
                //MODE MISE A JOUR AVEC DATE PREVU DEJA PREREMPLIS
                if ($_POST['mode']=='u') {
                    $ls=FsModel::getListBy($num_matr);
                    $_nbT=count($ls);
                    $nbu=0;
                    if ($_nbT==$nbT) {
                    // classic
                        for ($i=1; $i <= $nbT; $i++) { 
                            $key=$i.'T';
                            $t=str_replace('/','-',$_POST[$key]);
                            $date_prevu=date('Y-m-d',strtotime($t));
                            
                            $fs=new FsModel();
                            $pptsFS['idFS']=intval($ls[$i-1]['idFS']);
                            $pptsFS['num_tranche']=$i;
                            $pptsFS['date_prevu']=$date_prevu;
                            $pptsFS['INSCR_num_matr']=$num_matr;
                            $fs->parse($pptsFS);
        
                            $uf= $fs->update(null,['num_reçu','date_payement','montant']);
                            if($uf=='ok'){ $nbu++; }
                        }
                    }elseif ($_nbT<$nbT) {
                    // update add
                        for ($i=1; $i <= $nbT; $i++) { 
                            $key=$i.'T';
                            $t=str_replace('/','-',$_POST[$key]);
                            $date_prevu=date('Y-m-d',strtotime($t));
                            $fs=new FsModel();
                            $pptsFS['num_tranche']=$i;
                            $pptsFS['date_prevu']=$date_prevu;
                            $pptsFS['INSCR_num_matr']=$num_matr;
                            if($i<=$_nbT){
                                $pptsFS['idFS']=intval($ls[$i-1]['idFS']);
                                $fs->parse($pptsFS);
                                $uf= $fs->update(null,['num_reçu','date_payement','montant']);
                                if($uf=='ok'){ $nbu++; }
                            }else{
                                $fs->parse($pptsFS);
                                $af= $fs->insert(['num_reçu','date_payement','montant']);
                                $lastId=intval($af);
                                if(isset($lastId)){ $nbu++; }
                            }
                        }
                    }else {
                        # update del $_nbT>$nbT
                        // 1 2 3 _nbT 
                        //1 nbT
                        $nbdf=0;
                        for ($i=1; $i <= $_nbT; $i++) { 
                            $fs=new FsModel();
                            $pptsFS['idFS']=intval($ls[$i-1]['idFS']);
                            $pptsFS['num_tranche']=$i;
                            $pptsFS['INSCR_num_matr']=$num_matr;
                            // var_dump($fs);
                            if($i<=$nbT){
                                $key=$i.'T';
                                $t=str_replace('/','-',$_POST[$key]);
                                $date_prevu=date('Y-m-d',strtotime($t));
                                $pptsFS['date_prevu']=$date_prevu;
                                $fs->parse($pptsFS);
                                $uf= $fs->update(null,['num_reçu','date_payement','montant']);
                                if($uf=='ok'){ $nbu++; }
                            }else{
                                $fs->parse($pptsFS);
                                $df= $fs->delete();
                                if($df=='ok'){ $nbdf++; }
                            }
                        }
                        $nb=$nbu+$nbdf;
                        $nbu=($nb==$_nbT)?$_nbT-$nbdf:0;
                        // nbu : 1
                        // nbdf :2
                        // nbT: 1
                        // _nbT: 3 
                    }
    
                    if($ue=='ok' && $ui=='ok' && $nbu==$nbT){
                        $db->commit();
                        // echo 'Mise à jour effectuée !';
                        echo json_encode(['color'=>'success','message'=>'Mise à jour effectuée "en mode full insertion" !','status'=>'ok']);
                    }else{
                        $db->rollback();
                        // echo 'Erreur de mise à jour !';
                        echo json_encode(['color'=>'danger','message'=>'Erreur de mise à jour !','status'=>'ko']);
                        die();
                    }
                    
                } else {
                //MODE MISE A JOUR AVEC DATE PREVU (A AJOUTER SUR DB)
                    $nbat=0;
                    for ($i=1; $i <= $nbT; $i++) { 
                        $key=$i.'T';
                        $t=str_replace('/','-',$_POST[$key]);
                        $date_prevu=date('Y-m-d',strtotime($t));
                        
                        $fs=new FSModel();
                        $pptsFS['num_tranche']=$i;
                        $pptsFS['date_prevu']=$date_prevu;
                        $pptsFS['INSCR_num_matr']=$num_matr;
                        $fs->parse($pptsFS);
                        $cf= $fs->insert(['num_reçu','date_payement','montant']);
                        $cf=intval($cf);
                        if(is_int($cf)){ $nbat++; }
                    }

                    if($ue=='ok' && $ui='ok' && $nbat==$nbT){
                        $db->commit();
                        echo json_encode(['color'=>'success','message'=>'Mise à jour "en ajoutant de date de prevu payement" efféctuée !','status'=>'ok']);
                    }else{
                        $db->rollback();
                        echo json_encode(['color'=>'danger','message'=>'Erreur de mise à jour "en ajoutant de date prevu payement" !','status'=>'ko']);
                        die();
                    }
                }
                
                

            } else {
                //MODE MISE A JOUR SANS DATE PREVU DEJA 
                if($ue=='ok' && $ui=='ok'){
                    $db->commit();
                    // echo 'Mise à jour effectuée !';
                    echo json_encode(['color'=>'success','message'=>'Mise à jour effectuée "en mode sans date de prevu de paiement" !','status'=>'ok']);
                }else{
                    $db->rollback();
                    // echo 'Erreur de mise à jour !';
                    echo json_encode(['color'=>'danger','message'=>'Erreur de mise à jour !','status'=>'ko']);
                    die();
                }
            }
            
        } catch (\PDOException  $ex) {
            $db->rollback();
            // echo $ex->getMessage();
            echo json_encode(['color'=>'danger','message'=>'Une erreur s\'est produite !','status'=>'ko']);
        }
    }

    //Add student
    private function addE($detail){
        try {
            $db=Database::getConnection();
            $etudiant=new EtudiantModel();
            $etudiant->parse($_POST);
            $inscr=new InscriptionModel();
            $inscr->parse($_POST);
            // $inscr->pwd=Utils::str_random(6);
            $chkE=EtudiantModel::isExist($_POST['nie'],$_POST['nom'],$_POST['prenom'],$_POST['dateNaiss']);
            if($chkE){
                $msg='Cet enregistrement existe déjà <strong>'.$chkE['nie'].' '.$chkE['nom'].' '.$chkE['prenom'].'</strong>';
                echo json_encode(['color'=>'danger','message'=>$msg,'status'=>'ko']);
                die();
            }

            $db->beginTransaction();
            $ae= $etudiant->insert();
            $ai= $inscr->insert();
            HistoriqueModel::insertData('INSERTION',$detail,'');
            $lastId=intval($ai);
            if (isset($_POST['sd'])) {
                $nbat=0;
                $nbT=$_POST['nbTranche'];
                if(isset($lastId)){
                    for ($i=1; $i <= $nbT; $i++) { 
                        $key=$i.'T';
                        $t=str_replace('/','-',$_POST[$key]);
                        $date_prevu=date('Y-m-d',strtotime($t));
                        
                        $fs=new FSModel();
                        $pptsFS['num_tranche']=$i;
                        $pptsFS['date_prevu']=$date_prevu;
                        $pptsFS['INSCR_num_matr']=$lastId;
                        $fs->parse($pptsFS);
                        $cf= $fs->insert(['num_reçu','date_payement','montant']);
                        $cf=intval($cf);
                        if(is_int($cf)){ $nbat++; } 
                    }

                    if($ae=='ok' && isset($lastId) && $nbat==$nbT){
                        $db->commit();
                        echo json_encode(['color'=>'success','message'=>'Bien ajouté "en mode full insertion" !','status'=>'ok']);
                    }else{
                        $db->rollback();
                        echo json_encode(['color'=>'danger','message'=>'Erreur d\'ajout !','status'=>'ko']);
                        die();
                    }
                }
            }else{

                if($ae=='ok' && isset($lastId)){
                    $db->commit();
                    echo json_encode(['color'=>'success','message'=>'Bien ajouté "en mode sans date de prevu de paiement" !','status'=>'ok']);
                }else{
                    $db->rollback();
                    echo json_encode(['color'=>'danger','message'=>'Erreur d\'ajout !','status'=>'ko']);
                    die();
                }
            }


        } catch (\PDOException  $ex) {
            var_dump($ex->getMessage());
            // echo json_encode(['color'=>'danger','message'=>'Une erreur s\'est produite !','status'=>'ko']);
        }
    }

    private function _addE($detail){
        try {
            $db=Database::getConnection();
            $etudiant=new EtudiantModel();
            $etudiant->parse($_POST);
            $inscr=new InscriptionModel();
            $inscr->parse($_POST);
            // $inscr->pwd=Utils::str_random(6);
            $chkE=EtudiantModel::isExist($_POST['nie'],$_POST['nom'],$_POST['prenom'],$_POST['dateNaiss']);
            if($chkE){
                $msg='Cet enregistrement existe déjà <strong>'.$chkE['nie'].' '.$chkE['nom'].' '.$chkE['prenom'].'</strong>';
                echo json_encode(['color'=>'danger','message'=>$msg,'status'=>'ko']);
                die();
            }

            $db->beginTransaction();
            $ae= $etudiant->insert();
            $ai= $inscr->insert();
            HistoriqueModel::insertData('INSERTION',$detail,'');
            $lastId=intval($ai);
            if (isset($_POST['sd'])) {
                $nbat=0;
                $nbT=$_POST['nbTranche'];
                if(isset($lastId)){
                    for ($i=1; $i <= $nbT; $i++) { 
                        $key=$i.'T';
                        $t=str_replace('/','-',$_POST[$key]);
                        $date_prevu=date('Y-m-d',strtotime($t));
                        
                        $fs=new FSModel();
                        $pptsFS['num_tranche']=$i;
                        $pptsFS['date_prevu']=$date_prevu;
                        $pptsFS['INSCR_num_matr']=$lastId;
                        $fs->parse($pptsFS);
                        $cf= $fs->insert(['num_reçu','date_payement','montant']);
                        $cf=intval($cf);
                        if(is_int($cf)){ $nbat++; } 
                    }

                    if($ae=='ok' && isset($lastId) && $nbat==$nbT){
                        $db->commit();
                        echo json_encode(['color'=>'success','message'=>'Bien ajouté "en mode full insertion" !','status'=>'ok']);
                    }else{
                        $db->rollback();
                        echo json_encode(['color'=>'danger','message'=>'Erreur d\'ajout !','status'=>'ko']);
                        die();
                    }
                }
            }else{

                if($ae=='ok' && isset($lastId)){
                    $db->commit();
                    echo json_encode(['color'=>'success','message'=>'Bien ajouté "en mode sans date de prevu de paiement" !','status'=>'ok']);
                }else{
                    $db->rollback();
                    echo json_encode(['color'=>'danger','message'=>'Erreur d\'ajout !','status'=>'ko']);
                    die();
                }
            }


        } catch (\PDOException  $ex) {
            var_dump($ex->getMessage());
            // echo json_encode(['color'=>'danger','message'=>'Une erreur s\'est produite !','status'=>'ko']);
        }
    }


    

}

