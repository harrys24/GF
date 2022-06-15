<?php

use App\Core\Controller;
use App\Models\GradeModel;
use App\Models\ProfesseurModel;

class ProfesseurController extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']='enseignant';
        $header['js']=['src/jsProfesseur'];
        $header['css']=['src/cssProfesseur'];
        $this->renderH($header);
        $this->render('index');
        $this->renderF();
    }

    function showOPT($ls,$key,$value){
        foreach ($ls as $item) {
            echo '<option value="'.$item[$key].'">'.$item[$value].'</option>';
        }
    }
    function getGrade(){
        return GradeModel::showGrade();
    }
    
    

    function getProf(){
        $enseignants = ProfesseurModel::getProf();
        foreach($enseignants as $enseignant){
            $id = $enseignant['idPR'];
            $nom = $enseignant['nom_pr'];
            $prenom = $enseignant['prenom_pr'];
            $sexe = $enseignant['sexe_pr'];
            $contact = $enseignant['contacte_pr'];
            $email = $enseignant['email_pr'];
            $grade = $enseignant['nom_gr'];
            if($sexe==1){
                echo '<tr id="tr"><td>'.$nom.'</td><td>'.$prenom.'</td><td>Masculin</td><td>'.$contact.'</td><td>'.$email.'</td><td>'.$grade.'</td><td><button class="btn btn-warning" id="modifier" data-toggle="modal" data-target="#modalModif" data-id="'.$id.'">Modifier</button></td><td><button class="btn btn-danger" data-toggle="modal" data-target="#modalConfirm" id="supprimer" data-id="'.$id.'">Supprimer</button></td></tr>';
            }else{
                echo '<tr id="tr"><td>'.$nom.'</td><td>'.$prenom.'</td><td>Féminin</td><td>'.$contact.'</td><td>'.$email.'</td><td>'.$grade.'</td><td><button class="btn btn-warning" id="modifier" data-toggle="modal" data-target="#modalModif" data-id="'.$id.'">Modifier</button></td><td><button class="btn btn-danger" data-toggle="modal" data-target="#modalConfirm" id="supprimer" data-id="'.$id.'">Supprimer</button></td></tr>';
            }
        }
    }

    public function insertProf(){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $contact = $_POST['contact'];
        $sexe = $_POST['sexe'];
        $email = $_POST['email'];
        $grade = $_POST['grade'];
        $gr = $_POST['gr'];
        if($grade == ''){
            ProfesseurModel::insertProf($nom, $prenom, $sexe, $contact, $email, $gr);
        }else{
            $oldGr = GradeModel::getGrade($grade);
            if($oldGr){
                $idGrOld = intval($oldGr['idgr']);
                ProfesseurModel::insertProf($nom, $prenom, $sexe, $contact, $email, $idGrOld);
            }else{
                GradeModel::insertGrade($grade);
                $newGr = GradeModel::getGrade($grade);
                $idGr = intval($newGr['idgr']);
                ProfesseurModel::insertProf($nom, $prenom, $sexe, $contact, $email, $idGr);
            }
        }
        
    }

    public function supprProf(){
        $idPR = $_POST['idPR'];
        ProfesseurModel::delProf($idPR);
    }

    public function findPr(){
        header('content-type:text/javascript');
        $nom_pr = $_POST['nom'];
        $prenom_pr = $_POST['prenom'];
        $sexe = $_POST['sexe'];
        $data['pr'] = ProfesseurModel::findPr($nom_pr, $prenom_pr, $sexe);
        echo json_encode($data);
    }

    public function getPrById(){
        header('content-type:text/javascript');
        $idPR = $_POST['idPR'];
        $data = ProfesseurModel::getPrById($idPR);
        echo json_encode($data);
    }
    public function updatePr(){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $contact = $_POST['contact'];
        $sexe = $_POST['sexe'];
        $email = $_POST['email'];
        $gr = $_POST['gr'];
        $idPR = $_POST['idPR'];
        ProfesseurModel::updatePR($idPR, $nom, $prenom, $sexe, $contact, $email, $gr);
        
    }

}