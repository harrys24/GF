<?php
use App\Core\Controller;
use App\Core\Database;
use App\Models\AuModel;
use App\Models\GpModel;
use App\Models\EtudiantModel;
class EmargementsController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    //get:: emargements
    public function index(){
        $db=Database::getConnection();
        $data['au']=AuModel::getList('nom_au','DESC');
        $header['title']='Émargements';
        $header['current_menu']='EMARGEMENTS';
        $header['js']=['/src/sgetLsEm'];
        $header['css']=['/src/emr'];
        $this->renderH($header);
        $this->render('index',$data);
        $this->renderF();
        
    }
    //post:: get list emargement
    public function getLsEm(){
        header('content-type:text/javascript');
        $data=EtudiantModel::getLsEByNivGP($_POST['au'],$_POST['niv'],$_POST['gp']);
        echo json_encode($data);
    }

    //post check emargement
    public function checkEm(){
        $list=$_POST['list'];
        foreach ($list as $item) {
            echo $item['nie'].' : '.$item['ck']."</br>";
        }
    }


  





    




}

