<?php
use App\Core\Alert;
use App\Core\Utils;
use App\Core\Database;
use App\Models\AuModel;
use App\Core\Controller;
use App\Models\NivModel;
use App\Models\TarifFsModel;
use App\Models\TrancheFsModel;
use App\Models\DetailTrancheModel;

class Tarif_FsController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function _index(){
        $header['title']='TOUS LES FS';
        $data['list']=TarifFsModel::getAll();
        $this->_renderH($header);
        $this->render('index',$data);
        $this->renderF();
    }

    public function index(){
        $header['title']='Détail Par Tranche';
        // $header['current_menu']='ABSENCE ET RETARD';
        $header['js']=['moment-with-locales','/src/cplugs','/src/tarif_fs'];
        // $header['css']=['jquery-datetime','toggle-btn'];
        // $d=Utils::datetime_now();
        // $data['dn']=$d->format('d/m/Y');
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=NivModel::getList('nom_niv','ASC');
        $this->_renderH($header);
        // $this->template('confirm_modal');
        $this->render('index',$data);
        $this->renderF();
    }

    public function checkView(){
        // $res= TarifFsModel::insertList($_POST);
        // 
        Utils::HeaderJS();
        $res=TarifFsModel::checkAU($_POST['au']);
        
        echo json_encode($res);
        
    }
    public function checkData(){
        $res= TarifFsModel::insertList($_POST);
        header('Location: /tarif_fs');
    }
    
    public function update(){
        TarifFsModel::updateFs($_POST);
    }
}