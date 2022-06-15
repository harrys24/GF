<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\AuModel;
use App\Models\NivModel;
use App\Models\GpModel;
use App\Models\MatiereModel;
use App\Models\SemestreModel;
use App\Models\Type_matiereModel;
use App\Models\UeModel;
use App\Models\ProfesseurModel;
use App\Models\GrModel;
use App\Models\AttribuerModel;
class MatieresController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']='Gestion Notations';
        $header['current_menu']='MATIÈRES';
        $header['css']=['toggle-btn','typeahead','/src/scrud'];
        $header['js']=['/src/cplugs','toggle-btn','typeahead','/src/mats'];
        $data=[
            'mats'=>MatiereModel::getList('nom_mat','asc'),
            'ue'=>UeModel::getList('idUE','asc'),
            'prof'=>ProfesseurModel::getList('nom_pr,prenom_pr','asc'),
            'grade'=>GrModel::getList('nom_gr','asc'),
            'au'=>AuModel::getList('nom_au','asc'),
            'niv'=>NivModel::getList('nom_niv','asc'),
            'tm'=>Type_matiereModel::getList('nom_type','asc')
        ];
        $this->renderH($header);
        $this->render('index',$data);
        $this->renderF();
    }
//Attribution pour NOTATION------------------------------------------------
    public function getListBy(){
        Utils::HeaderJS();
        Utils::int_post(['iau','iniv']);
        $data=[
            'gp'=>GpModel::getListBy($_POST['iau'],$_POST['iniv']),
            'sem'=>SemestreModel::getListByNiv($_POST['iniv'])
        ];
        echo json_encode($data);        
    }

    public function getCheckFilter(){
        Utils::HeaderJS();
        echo json_encode([
            'gp'=>GpModel::getListBy($_POST['iau'],$_POST['iniv']),
            'sem'=>SemestreModel::getListByNiv($_POST['iniv'])
        ]);
    }

    public function findByFilter(){
        AttribuerModel::findByFilter();
    }

    public function getListUE(){
        Utils::HeaderJS();
        echo json_encode(UeModel::getLs());
    }

    public function getListMat(){
        Utils::HeaderJS();
        echo json_encode(MatiereModel::getLs());
    }

    public function getListProf(){
        Utils::HeaderJS();
        echo json_encode(ProfesseurModel::getFullName());
    }

    public function attrMatsCheck(){
        AttribuerModel::storeAttr();
    }

    public function attrAutrMatsCheck(){
        AttribuerModel::storeAutrAttr();
    }

    public function getListAttr(){
        AttribuerModel::findByFilter();
    }

    public function attrMatsDelete(){
        AttribuerModel::deleteAttr();
    }


//---------------------------------------------------------------------


   
// MATIERES ----------------------------------------------------------------------
    public function matsCheck(){
        MatiereModel::store();
    }
    public function matsDelete(){
        Utils::HeaderJS();
        $id=intval($_POST['id']);
        Alert::check(MatiereModel::deleteBy($id),'d');
    }

// UE ----------------------------------------------------------------------
    
    public function generateTitre(){
        UeModel::generateTitre();
    }

    public function ueCheck(){
        UeModel::store();
    }

    public function ueDelete(){
        Utils::HeaderJS();
        $id=intval($_POST['id']);
        Alert::check(UeModel::deleteBy($id),'d');
    }

//PROF  ---------------------------------------------------------------------  
    public function profCheck(){
        ProfesseurModel::store();
    }

    public function profDelete(){
        Utils::HeaderJS();
        $id=intval($_POST['id']);
        Alert::check(ProfesseurModel::deleteBy($id),'d');
    }







    




}

