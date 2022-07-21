<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\AuModel;
use App\Models\NivModel;
use App\Models\TrancheFsModel;
use App\Models\DetailTrancheModel;
use App\Models\TarifFsModel;

class DetailTrancheController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']='Détail Par Tranche';
        // $header['current_menu']='ABSENCE ET RETARD';
        $header['js']=['moment-with-locales','/src/cplugs','/src/detail_tranche'];
        // $header['css']=['jquery-datetime','toggle-btn'];
        // $d=Utils::datetime_now();
        // $data['dn']=$d->format('d/m/Y');
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=NivModel::getList('nom_niv','ASC');
        $data['tranche']=TrancheFsModel::getList('nbT','ASC');
        $this->_renderH($header);
        // $this->template('confirm_modal');
        $this->render('index',$data);
        $this->renderF();
    }

    public function checkView(){
        Utils::HeaderJS();
        $res= DetailTrancheModel::check($_POST);
        echo json_encode($res);
    }


    public function checkData(){
        if ($_POST['mode']=='u') {
            $res= DetailTrancheModel::updateList($_POST);
        }elseif ($_POST['mode']=='i') {
            $res= DetailTrancheModel::insertList($_POST);
        }
        header('Location: /DetailTranche');
        
    }

    public function getFS(){
        Utils::HeaderJS();
        $fs=TarifFsModel::getTarifFs($_POST);
        echo json_encode(['fs'=>$fs]);
    }
}