<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\DataModel;
use App\Models\GPModel;
use App\Models\EtudiantModel;
use App\Models\InscriptionModel;
use App\Models\FsModel;
class ReinscriptionController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function etudiant($nie){
        $db=Database::getConnection();
        $sql="select *,DATE_FORMAT(datenaiss,'%d/%m/%Y') as datenaiss,DATE_FORMAT(dateRec,'%d/%m/%Y') as dateRec 
        from etudiant where nie=?";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(1,$nie);
        $stmt->execute();
        $data=DataModel::getData();
        $data['etudiant']=$stmt->fetch();

        $header['title']='FICHE DE REINSCRIPTION';
        $header['current_menu']='LISTE DES ÉTUDIANTS';
        $header['css']=['jquery-datetime','toggle-btn','/src/form'];
        $header['js']=['jquery-datetime','toggle-btn','moment-with-locales','/src/cplugs','/src/reinscr'];
        $this->renderH($header);
        $this->render('index',$data);
        $this->renderF();
    }

     //post Reinscription Etudiant
     public function check(){
        Utils::HeaderJS();  
        //Touc
        Utils::UCP(['nom','nom_p','nom_m','nom_t']);
        Utils::UCWP(['prenom','prenom_p','prenom_m','prenom_t']);
        //CONTACTES
        DataModel::parseContacte();
        DataModel::parseContacte('_p');
        DataModel::parseContacte('_m');
        DataModel::parseContacte('_t');
        // DataModel::addAutre();
        //PHOTO
        DataModel::uploadPhoto_Etudiant();

        //TO INT
        Utils::int_post(['AU_id','NIV_id','GP_id','AB_id','SB_id','MB_id','REC_id','TrancheFS_id']);
        //TO BOOLEAN
        $_POST['sexe']=($_POST['sexe']=='H')?1:0;
        Utils::check_post(['abandon','ckN2nd','ckN1ere','ckNTal','ckNBacc','ckDBacc','ckNL1','ckNL2','ckNL3','ckDL3','ckNM1', 'ckFI','ckLE','ckLM','ckCR','ckPhoto','ckCIN','ckBNaiss']);
        //TO DATE P
        unset($_POST['sd']);
        DataModel::parseDate(['dateNaiss','dateRec','dateInscr']);
        Utils::int_post('DI','Reste_DI');
       //INSCRIPTION
       $_POST['ETUDIANT_nie']=$_POST['nie'];
       $this->reinscrAction();
    }

    private function reinscrAction(){
        try {
            $db=Database::getConnection();
            $etudiant=EtudiantModel::get($_POST['nie']);
            if(empty($etudiant)){
                Alert::warning('Cet etudiant n\'existe pas !');
            }
            $inscr_exist=InscriptionModel::isExist($_POST['nie'],$_POST['AU_id'],$_POST['NIV_id'],$_POST['GP_id']);
            if($inscr_exist){
                Alert::warning('Cet enregistrement existe déjà avec "le même NIE, année universitaire, niveau et parcours ou groupe !');
            }
            $db->beginTransaction();
            $etudiant=new EtudiantModel();
            $etudiant->parse($_POST);
            $ue= $etudiant->update($_POST['nie']);
            
            $inscr=new InscriptionModel();
            $inscr->parse($_POST);
            $ai= $inscr->insert();
            $lastId=intval($ai);

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
            }

            if($ue=='ok' && isset($lastId) && $nbat==$nbT){
                $db->commit();
                Alert::success('Bien ajouté !');
            }else{
                $db->rollback();
                Alert::error('Erreur d\'ajout !');
            }

        } catch (\PDOException  $ex) {
            $db->rollback();
            // echo $ex->getMessage();
            Alert::error('Une erreur s\'est produite !');
        }
    }







    




}

