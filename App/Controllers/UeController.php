<?php

use App\Core\Controller;
use App\Models\UeModel;

class UeController extends Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $header['title']='Unité d\'enseignement ';
        $header['current_menu']='AUTRES';
        $this->renderH($header);
        $this->render('index');
        $this->renderF();
    }

    

    public function insertUe(){
        $titre = $_POST['titre'];
        $nom = $_POST['nom_ue'];
        UeModel::insertUE($nom, $titre);
    }
    
    public function supprUe(){
        $idUE = $_POST['idUe'];
        UeModel::delUE($idUE);
    }
    
    public function findUe(){
        $titre = $_POST['titre'];
        $nom = $_POST['nom_ue'];
        $data = UeModel::getOldUE($nom, $titre);
        echo json_encode($data);
    }

    public function modifUe(){
        header('content-type:text/javascript');
        $UE_id = $_POST['idUe'];
        $data['ue'] = UeModel::getUeByID($UE_id);
        echo json_encode($data);
    }
    public function updateUe(){
        $id = $_POST['idUE'];
        $nom = $_POST['nom'];
        $titre = $_POST['titre'];
        var_dump($id, $titre, $nom);
        UeModel::updateUe($id, $titre, $nom);
    }
    
    public function getUe(){
        header('content-type:text/javascript');
        $nom_ue = "%{$_POST['ue']}%";
        $data['ue'] = UeModel::getUeVal($nom_ue);
        echo json_encode($data);
    }

}