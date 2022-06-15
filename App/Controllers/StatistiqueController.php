<?php
use App\Core\Conf;
use App\Core\Alert;
use App\Core\Utils;
use App\Core\Database;
use App\Models\AuModel;
use App\Core\Controller;
use App\Models\StatistiqueModel;

class StatistiqueController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']='STATISTIQUE';
        $header['current_menu']='STATISTIQUE';
        $header['css']=['/src/dd'];
        $header['js']=['chart','/src/cplugs','/src/stat'];
        // $data=StatistiqueModel::getData();
        $data['au']=AuModel::getList('nom_au','DESC');
        $this->renderH($header);
        $this->render('index',$data);
        $this->renderF();
    }

    
    public function getCheckData(){
        Utils::HeaderJS();
        $res=StatistiqueModel::getData();
        echo json_encode($res);
    }

    public function a()
    {
        $a=['2','4','6'];
        $b=['1','2','6','3','7'];
        $c=['1','9','10','5'];
        // var_dump(array_merge($a,$b));
        $array = $this->concatArrays([$a, $b, $c]);
        echo '<pre>';
        var_dump($array);
        echo '</pre>';
    }
   
    

   



    




}

