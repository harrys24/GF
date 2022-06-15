<?php
use App\Core\Database;
use App\Models\AuModel;
use App\Core\Controller;
use App\Models\NivModel;
use App\Models\EtudiantModel;

class ExportController extends Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $db=Database::getConnection();
        $data['au']=AuModel::getList('nom_au','DESC');
        $header['title']='Exportation des étudiants';
        $header['current_menu']='AUTRES';
        $header['js']=['/src/cplugs','select2','toggle-btn','/src/exp'];
        $header['css']=['select2','toggle-btn','/src/dd'];
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('index',$data);
        $this->renderF();
        
        
    }

    public function all(){
        $db=Database::getConnection();
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=NivModel::getList('nom_niv','ASC');
        $header['title']='Exportation des étudiants';
        $header['current_menu']='AUTRES';
        $header['js']=['/src/cplugs','select2','toggle-btn','/src/exp_all'];
        $header['css']=['select2','toggle-btn','/src/dd'];
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('all',$data);
        $this->renderF();
        
        
    }

    public function etudiant(){
        EtudiantModel::exportBy($_POST['anp'],$_POST['a'],$_POST['n'],$_POST['p'],$_POST['abd']);
    }
    
    public function all_student(){
        EtudiantModel::exportAll($_POST['anp'],$_POST['a'],$_POST['n'],$_POST['abd']);
    }

    
    

}