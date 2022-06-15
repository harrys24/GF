<?php
use App\Core\Controller;
use App\Core\Conf;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\AuModel;
use App\Models\GpModel;
use App\Models\DeleguesModel;
use App\Core\Database;
class DeleguesController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']="Gestion des délégués";
        $header['current_menu']='AUTRES';
        $header['js']=['/src/cplugs','/src/delegues'];
        $header['css']=['/src/inc'];
        // $data['gp']=GpModel::getAllNivGP();
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['list']=DeleguesModel::All();
       
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('index',$data);
        $this->renderF();
    }

    public function _check(){
        var_dump($_POST);
    }

    public function check(){
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist(['username','password','cpassword','opk']);
        Utils::PEqual('password','cpassword');
        $dlg=new DeleguesModel();
        $dlg->parse($_POST);

        $res=$dlg->update($_POST['opk'],$excludedPPTS=['INSCR_num_matr','create_time']);
        switch ($res) {
            case 'ok':
                $data=DeleguesModel::All();
                Alert::info('u',$data);
                break;
            case 'ko':
                Alert::warning('u');
                break;
            default:
                Alert::debug($res);
                break;
        }
        

    }
    
    public function delete(){
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist('id');
        $res=DeleguesModel::deleteBy($_POST['id']);
        switch ($res) {
            case 'ok':
                $data=DeleguesModel::All();
                Alert::info('d',$data);
                break;
            case 'ko':
                Alert::warning('d');
                break;
            default:
                Alert::debug($res);
                break;
        }
        // UserModel::deleteBy($_POST['username']);
        
    }

    public function generateCmp(){
        Utils::HeaderJS();
        Utils::Exist('ni');
        Utils::int_post('ni');
        $exist=DeleguesModel::check_cmp($_POST['ni']);
        if(!empty($exist)){
            Alert::error('Cet étudiant possède déjà un compte délégué !');
        }
        
        $p=[
            'username'=>Utils::str_random(6),
            'password'=>Utils::str_random(7),
            'INSCR_num_matr'=>$_POST['ni']
        ];
        $o=new DeleguesModel();
        $o->parse($p);
        $res=$o->insert();
        $cok=$this->copyPhoto($_POST['ep']);
    //    copy('/asset')
       Alert::check($res);
    }
    
    private function copyPhoto($nom_photo){
        //E:/SRC/ESMIA/dev/GEO/App
        if ($nom_photo!='boys.png' || $nom_photo!='girls.png') {
            $app=WEB."assets/images/";
            $src=$app.'students/'.$nom_photo;
            if (App\Core\Conf::online==0) {
                $ngeo='GEO';$ngpar='GPAR';
            } else {
                $ngeo='esgeo';$ngpar='esemr';
            }
            $dest=str_replace($ngeo,$ngpar,$app);
            $dest.='users/'.$nom_photo;
            if (copy($src,$dest)) {
                return true;
            } else {
                return false;
            }
        }
        
            
        
    }


}

