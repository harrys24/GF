<?php
use App\Core\Alert;
use App\Core\Utils;
use App\Core\Database;
use App\Models\AuModel;
use App\Models\FsModel;
use App\Models\GpModel;
use App\Core\Controller;
use App\Models\NivModel;
use App\Models\DataModel;
use App\Models\EtudiantModel;
use App\Models\TrancheFsModel;
use App\Models\InscriptionModel;
use App\Models\DetailTrancheModel;

class ListeController extends Controller
{
    const PHOTO_DIR='assets/images/students/',
    EXTS=['jpg','jpeg','png'];
    
    public function __construct(){
        parent::__construct();
        
    }
    function getDate($value){
        $d=new DateTime($value);
        return $d->format('d/m/Y');
    }
    public function a(){
        $db=Database::getConnection();
        $sql="select i.*,e.*
        from inscription i
        inner join etudiant e on i.etudiant_nie=e.nie
        where i.num_matr=?;";
        $stmt=$db->prepare($sql);
        $stmt->execute([125]);
        $res=$stmt->fetch();
        // $dn=date('d/M/Y',strtotime($res['datenaiss']));
        var_dump($this->getDate($res['datenaiss']));
    }

    
    //get:: listes etudiants
    public function index(){
        $db=Database::getConnection();
        $data['au']=AuModel::getList('nom_au','DESC');
        $header['title']='Liste des étudiants';
        $header['current_menu']='LISTE DES ÉTUDIANTS';
        $header['js']=['/src/cplugs','toggle-btn','/context','/src/ls'];
        $header['css']=['toggle-btn','/src/ei','/context.standalone'];
        $this->renderH($header);
        $this->render('listes',$data);
        $this->renderF();

        
    }
    
    

    //get
    public function view($num_matr){
        $db=Database::getConnection();
        $sql1="SELECT e.*,i.AU_id,i.NIV_id,t.idT,i.dateInscr,i.DI,i.Reste_DI,i.EP,i.do_en,i.comment,i.list_dossier,
        a.nom_au,n.nom_niv,g.nom_gp,d.diplome,t.nbT,nt.nationalite,r.poste_rec,b.annee,m.mention,s.serie 
        FROM inscription i 
        LEFT JOIN etudiant e ON i.ETUDIANT_nie=e.nie 
        LEFT JOIN au a ON i.AU_id=a.idAU 
        LEFT JOIN niv n ON i.NIV_id=n.idNIV 
        LEFT JOIN gp g ON i.GP_id=g.idGP 
        LEFT JOIN do d ON i.DO_id=d.idDO 
        LEFT JOIN tranchefs t ON i.TrancheFS_id=t.idT 
        LEFT JOIN nat nt ON e.NAT_id=nt.idNAT 
        LEFT JOIN recruteur r ON e.REC_id=r.idREC 
        LEFT JOIN ab b ON e.AB_id=b.idAB 
        LEFT JOIN sb s ON e.SB_id=s.idSB 
        LEFT JOIN mb m ON e.MB_id=m.idMB 
        WHERE i.num_matr=?;";
        $stmt=$db->prepare($sql1);
        $stmt->execute([$num_matr]);
        $res=$stmt->fetch();
        $fk_au=$res['AU_id'];
        $fk_niv=$res['NIV_id'];
        $fk_tranche=$res['idT'];
        $res['dossier']=InscriptionModel::getDossier($fk_niv);
        $res['fs']=DetailTrancheModel::getDetail(['au'=>$fk_au,'niv'=>$fk_niv,'tranche'=>$fk_tranche]);
        $header['title']='Détail '.$res['nie'];
        $header['current_menu']='LISTE DES ÉTUDIANTS';
        $header['css']=['toggle-btn','/src/form'];
        $header['js']=['toggle-btn'];
        $this->renderH($header);
        $this->render('view',$res);
        $this->renderF();

        
    }

    private function getRIData(){
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=NivModel::getList('nom_niv','ASC');
        $data['tranchefs']=TrancheFsModel::getList('nbT','ASC');
        return $data;
    }


    //post get gp
    public function check_niv(){
        GpModel::get4AU($_POST['id']);
    }

    //post
    public function getfs(){
        Utils::HeaderJS();
        $id=intval($_POST['id']);
        echo json_encode(FsModel::getListBy($id));        
    }

    


    //post:: get list student by au,niv,gp,abd
    public function getLsE(){
        header('content-type:text/javascript');
        $data=EtudiantModel::getLsByNivGP($_POST['au'],$_POST['niv'],$_POST['gp'],$_POST['abd']);
        echo json_encode($data);
    }


    //post:: get list student by search
    public function getLs4E(){
        header('content-type:text/javascript');
        $txt=EtudiantModel::getLsBySearch($_POST['au'],$_POST['txt'],$_POST['abd'],'e');
        echo json_encode($txt);
    }


  


   
}

