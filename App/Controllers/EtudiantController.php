<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Alert;
use App\Core\Utils;
use App\Models\DataModel;
use App\Models\AuModel;
use App\Models\NivModel;
use App\Models\GpModel;
use App\Models\NatModel;
use App\Models\RecruteurModel;
use App\Models\AbModel;
use App\Models\DetailTrancheModel;
use App\Models\SbModel;
use App\Models\MbModel;
use App\Models\DoModel;
use App\Models\TrancheFsModel;
use App\Models\EtudiantModel;
use App\Models\InscriptionModel;
use App\Models\FsModel;
use App\Models\OptModel;
class EtudiantController extends Controller
{
    const PHOTO_DIR='assets/images/students/',
    EXTS=['jpg','jpeg','png'];
    
    public function __construct(){
        parent::__construct();
        
    }


    private function getRIData(){
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=NivModel::getList('nom_niv','ASC');
        $data['tranchefs']=TrancheFsModel::getList('nbT','ASC');
        return $data;
    }


    //post get gp
    public function check_niv(){
        // Utils::HeaderJS();
        // $res=GpModel::getAllNivGP($_POST['id']);
        // echo json_encode($res);
        GpModel::get4AU($_POST['id']);
    }

    //post
    public function getfs(){
        Utils::HeaderJS();
        $id=intval($_POST['id']);
        echo json_encode(FsModel::getListBy($id));        
    }

    //get
    public function view($num_matr){
        $db=Database::getConnection();
        $sql="SELECT i.*,e.* FROM inscription i
        INNER JOIN etudiant e ON i.etudiant_nie=e.nie
        WHERE i.num_matr=?;";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(1,$num_matr);
        $stmt->execute();
        $data=DataModel::getData();
        $data['etudiant']=$stmt->fetch();
        $fk_au=intval($data['etudiant']['AU_id']);
        $fk_niv=intval($data['etudiant']['NIV_id']);
        $fk_tranche=intval($data['etudiant']['TrancheFS_id']);
        $nstmt=$db->prepare('select nom_niv from niv where idNIV=?;');
        $nstmt->execute([$fk_niv]);
        $response=$nstmt->fetch();
        $data['dossier']=InscriptionModel::getDossier($fk_niv);
        $data['gp']=GpModel::getListBy($fk_au,$fk_niv);
        $data['fs']=DetailTrancheModel::getDetail(['au'=>$fk_au,'niv'=>$fk_niv,'tranche'=>$fk_tranche]);
        $header['title']='Détail '.$data['etudiant']['nie'];
        $header['current_menu']='LISTE DES ÉTUDIANTS';
        $header['css']=['jquery-datetime','toggle-btn','/src/form'];
        $header['js']=['jquery-datetime','toggle-btn','moment-with-locales','/src/cplugs','/src/inscr_form'];
        $this->renderH($header);
        $this->render('Inscription.index',$data);
        $this->renderF();

        
    }


    //post:: get list student by au,niv,gp,abd
    public function getLsE(){
        header('content-type:text/javascript');
        $data['list']=EtudiantModel::getLsByNivGP($_POST['au'],$_POST['niv'],$_POST['gp'],$_POST['abd']);
        // $edit = ($_SESSION['type']=='job_etudiant' || $_SESSION['type']=='guest') ? 'false' : 'true' ;
        $edit = ($_SESSION['type']=='guest') ? 'false' : 'true' ;
        $data['edit']=$edit;
        $data['type']=$_SESSION['type'];
        echo json_encode($data);
    }


    //post:: get list student by search
    public function getLs4E(){
        header('content-type:text/javascript');
        $data['list']=EtudiantModel::getLsBySearch($_POST['au'],$_POST['txt'],$_POST['abd'],$_POST['by']);
        // $edit = ($_SESSION['type']=='job_etudiant' || $_SESSION['type']=='guest') ? 'false' : 'true' ;
        $edit = ($_SESSION['type']=='guest') ? 'false' : 'true' ;
        $data['edit']=$edit;
        $data['type']=$_SESSION['type'];
        echo json_encode($data);
    }


    //get:: listes etudiants
    public function listes(){
        $db=Database::getConnection();
        $data['au']=AuModel::getList('nom_au','DESC');
        $header['title']='Liste des étudiants';
        $header['current_menu']='LISTE DES ÉTUDIANTS';
        $header['js']=['/src/cplugs','toggle-btn','/context','/src/sgetLs'];
        $header['css']=['toggle-btn','/src/ei','/context.standalone'];
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('listes',$data);
        $this->renderF();

        
    }

    public function setABD(){
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist('ne');
        $res=EtudiantModel::setABD($_POST['ne']);
        if ($res) {
            Alert::get('success','Opération éfféctuée avec succès !');
        } else {
            Alert::get('danger','Erreur du réseau !');
        }
        
    }

    public function Delete(){
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist(['ni','ne']);
        $res=EtudiantModel::deleteInscr($_POST['ni'],$_POST['ne']);
        if ($res) {
            Alert::get('success','Opération éfféctuée avec succès !');
        } else {
            Alert::get('danger','Cet étudiant possède encore des présences !');
        }
    }

    public function migrate(){
        InscriptionModel::migrate($_POST['au'],$_POST['niv'],$_POST['gp'],$_POST['list']);
    }

    public function compte(){
        $header['title']="Compte des étudiants";
        $header['current_menu']='AUTRES';
        $header['js']=['/src/cplugs','/src/cmps'];
        $header['css']=['/src/cmps'];
        $data['au']=AuModel::getList('nom_au','DESC');
       
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('cmps',$data);
        $this->renderF();
    }

    public function getLsCmps(){
        header('content-type:text/javascript');
        $data=EtudiantModel::getLsCmps($_POST['au'],$_POST['niv'],$_POST['gp']);
        echo json_encode($data);
    }

    //update student pwd
    public function uptcmp(){
        header('content-type:text/javascript');
        EtudiantModel::uptcmp();
    }
    public function gererateCmps(){
        header('content-type:text/javascript');
        EtudiantModel::gererateCmps();
    }

    public function printCmps(){
        $filename=$_POST['nom_au'].'_'.$_POST['nom_niv'];
        header('content-type:text/csv');
        header('Content-Disposition: attachement; filename="'.$filename.'.csv"');
        $data=EtudiantModel::getLsCmps($_POST['au'],$_POST['niv'],$_POST['gp']);
        echo utf8_decode('Num;NIE;Nom;prénom(s);sexe;Mot de passe');
        foreach ($data as $key => $item) {
            $sexe=($item['sexe'])?'M':'F';
            echo "\n".($key+1).';'.$item['nie'].';'.utf8_decode($item['nom']).';'.utf8_decode($item['prenom']).';'.$sexe.';'.$item['pwd'];
        }
    }
   
}

