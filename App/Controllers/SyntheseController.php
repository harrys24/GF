<?php

use App\Core\Controller;
use App\Core\Utils;
use App\Models\EtudiantModel;
use App\Models\GpModel;
use App\Models\NivModel;
use App\Models\SyntheseModel;

class SyntheseController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $header['title']='SYNTHESE';
        $header['current_menu']='SYNTHESE';
        $header['css']=['/src/synthese', '/src/toastr'];
        $header['js']=['/src/toastr.min', '/src/synthese'];
        $this->renderH($header);
        $this->render('index', [
            'data' => SyntheseModel::getTotalPercu()
        ]);
        $this->renderF();
    }
    public function student()
    {
        $header['title']='SYNTHESE';
        $header['current_menu']='SYNTHESE';
        $header['css']=['/src/synthese', '/src/toastr' , '/select2.min'];
        $header['js']=['/src/toastr.min', '/select2.min', '/src/synthese'];
        $this->renderH($header);
        $this->render('students', [
            "students" => SyntheseModel::getAllStudent()
        ]);
        $this->renderF();
    }
    public function classe()
    {
        $header['title']='SYNTHESE';
        $header['current_menu']='SYNTHESE';
        $header['css']=['/src/synthese', '/src/toastr' , '/select2.min'];
        $header['js']=['/src/toastr.min', '/select2.min', '/src/classe'];
        $niv = NivModel::getList();
        $array = [];
        foreach($niv as $n){
            $gp = GpModel::getListByAU($n['idNIV']);
            foreach($gp as $g){
                array_push($array, ['id' => $n['idNIV'].'_'.$g['GP_id'], 'nom' => $n['nom_niv'].$g['nom_gp']]);
            }

        }
        $this->renderH($header);
        $this->render('classe', [
            "classe" => $array
        ]);
        $this->renderF();
    }

    public function getPercu(){
        Utils::HeaderJS();
        $matr = $_POST['matr'];
        $debut = $_POST['debut'];
        $fin = $_POST['fin'];
        $filtre = $_POST['filtre'];
        if($filtre == "Tous"){
            $data['percu'] = SyntheseModel::getPercusByStudents($matr, $debut, $fin);
        }else{
            $data['percu'] = SyntheseModel::getPercusByStudentsFiltre($matr, $debut, $fin, $filtre);
        }
        $data['reste'] = SyntheseModel::getReste($matr);
        $data['student'] = SyntheseModel::getStudent($matr);
        echo json_encode($data);
    }

    public function getPercuClasse(){
        Utils::HeaderJS();
        $NIV_id = explode("_", $_POST['id'])[0];
        $GP_id = explode("_", $_POST['id'])[1];
        $debut = $_POST['debut'];
        $fin = $_POST['fin'];
        $filtre = $_POST['filtre'];
        if($filtre == "Tous"){
            $data['percu'] = SyntheseModel::getPercusByStudents($NIV_id, $GP_id, $debut, $fin);
        }else{
            $data['percu'] = SyntheseModel::getPercusByStudentsFiltre($NIV_id, $GP_id, $debut, $fin, $filtre);
        }
    }
}