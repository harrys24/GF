<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\AuModel;
use App\Models\SalleModel;
use App\Models\MatiereModel;
use App\Models\ProfesseurModel;
use App\Models\TcoursModel;
use App\Models\PresenceModel;
use App\Models\JustificationModel;
use App\Models\InscriptionModel;
class RetardController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']='Gestion des ABS/RT';
        $header['current_menu']='ABSENCE ET RETARD';
        $header['js']=['/src/cplugs','typeahead','jquery-datetime','moment','/src/gAbsRt'];
        $header['css']=['typeahead','jquery-datetime','/src/dd'];
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['motif']=JustificationModel::getList();
        $data['salles']=SalleModel::getList('numSALLE');
        $d=Utils::datetime_now();
        $data['dn']=$d->format('d/m/Y');
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('index',$data);
        $this->renderF();
    }

    public function check_e(){
        Utils::HeaderJS();
        $res=InscriptionModel::getEtudiant($_POST['ne'],$_POST['a'],$_POST['n'],$_POST['p']);
        if (!empty($res)) {
            echo json_encode(['color'=>'success','message'=>'Vérification ok !','data'=>$res]);
        } else {
            echo json_encode(['color'=>'danger','message'=>'Aucun résultat trouvé !','data'=>$res]);
        }
        
    }

    public function getListMats(){
        Utils::HeaderJS();
        echo json_encode(MatiereModel::getLs());
    }

    public function getListProfs(){
        Utils::HeaderJS();
        echo json_encode(ProfesseurModel::getFullName());
    }

    
    public function store(){
        PresenceModel::store();
    }
    
    public function getList(){
        Utils::HeaderJS();
        $res=MatiereModel::getListBy($_POST['a'],$_POST['n'],$_POST['p']);
        echo json_encode($res);
    }

    





}

