<?php
use App\Core\Controller;
use App\Core\Database;
use App\Models\AuModel;
use App\Models\NivModel;

class EntretienController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $db=Database::getConnection();
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=NivModel::getList('nom_niv','ASC');
        $header['title']='ENTRETIEN';
        // $header['current_menu']='RDV';
        $header['js']=['/src/rdv_entretien'];
        $header['css']=['/src/rdv_entretien'];
        // $header['css']=['toggle-btn','/src/ei','/context.standalone'];
        $this->_renderH($header);
        $this->render('rdv',$data);
        $this->renderF();

        
    }

    public function a(){
        $header['title']='ENTRETIEN1';
        $db=Database::getConnection();
        $sql="select * from au order by nom_au desc;";
        $stmt=$db->prepare($sql);
        $stmt->execute();
        $res=$stmt->fetchAll();
        $data['au']=$res;
        // $dn=date('d/M/Y',strtotime($res['datenaiss']));
        $this->_renderH($header);
        $this->render('rdv',$data);
        $this->renderF();
    }

    function saveRdv(){
        var_dump($_POST);
    }

}