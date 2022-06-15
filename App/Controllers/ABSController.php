<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\AuModel;
use App\Models\PresenceModel;
class ABSController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']='Justification des ABS/RT';
        $header['current_menu']='ABSENCE ET RETARD';
        $header['js']=['/src/cplugs','jquery-datetime','toggle-btn','moment','/src/abs'];
        $header['css']=['jquery-datetime','toggle-btn'];
        $d=Utils::datetime_now();
        $data['dn']=$d->format('d/m/Y');
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('index',$data);
        $this->renderF();
    }



    function isBetween($d,$f,$lsh){
        foreach ($lsh as $item) {
            $hd=new DateTime($item['hdebut']);
            $hf=new DateTime($item['hfin']);
            if (!(($d<$hd && $f<=$hd) || ($d>=$hf && $f>$hf))) {
                return true;
            } 
        }
        return false;
    }

    public function check_ne(){
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist(['ne','type','dc']);
        Utils::parseDate('dc');
        $data=PresenceModel::getListBy($_POST['ne'],$_POST['type'],$_POST['dc']);
        if (count($data)>0) {
            echo json_encode(['color'=>'info','message'=>'Vérification éffectué !','data'=>$data]);
        } else {
            echo json_encode(['color'=>'danger','message'=>'aucune présence  trouvée !']);
        }
        
    }

    public function updateList(){
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist(['nm','ne','type','list']);
        $lsType=['a','r'];
        $type=$_POST['type'];
        if (!in_array($type,$lsType)) {
            Alert::get('danger','Type inconnue !');
        }
        PresenceModel::updateListABS($type,$_POST['nm'],$_POST['list']);
    }

    public function statistique(){
        $header['title']='Statistique des ABS/RT';
        $header['current_menu']='ABSENCE ET RETARD';
        $header['js']=['/src/cplugs','jquery-datetime','toggle-btn','moment','/src/abs_stat'];
        $header['css']=['jquery-datetime','toggle-btn'];
        $this->renderH($header);
        $this->render('stat');
        $this->renderF();
    }


    public function getStat(){
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist(['sd','ed']);
        Utils::parseDate(['sd','ed']);
        $data=PresenceModel::getStat($_POST['sd'],$_POST['ed']);
        Alert::get('info','statistique chargé !',$data);
    }

    public function a(){
        $header['title']='ABS GRAPHIQUE';
        $header['js']=['Chart.min'];
        $this->renderH($header);
        $this->render('graph');
        $this->renderF();
    }
   




    




}

