<?php
use App\Core\Utils;
use App\Models\AuModel;
use App\Core\Controller;
use App\Models\NivModel;
use App\Models\TarifFsModel;

class TarifFsController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']='Détail Par Tranche';
        $header['current_menu']='FINANCE';
        $header['js']=['toastr','moment-with-locales','/src/tarif_fs'];
        $header['css']=['toastr'];
        // $d=Utils::datetime_now();
        // $data['dn']=$d->format('d/m/Y');
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=NivModel::getList('nom_niv','ASC');
        $this->renderH($header);
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
        header('Location: /TarifFs');
    }
    
    public function update(){
        TarifFsModel::updateFs($_POST);
    }

}