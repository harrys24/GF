<?php

use App\Core\Controller;
use App\Core\Utils;
use App\Models\FsModel;
use App\Models\RecusModel;

class FinanceController extends Controller
{
    public function __construct(){
        parent::__construct();
        
    }

    public function index()
    {
        $header['title']='Finance';
        $header['current_menu']='FINANCE';
        $header['css']=['/src/finance'];
        $header['js']=['/src/cplugs','/src/finance'];
        $this->renderH($header);
        $this->render('Finance.index');
        $this->renderF();
    }

    public function recus(){
        $header['title']='Reçus';
        $header['current_menu']='FINANCE';
        $header['css']=['/src/recus', '/src/toastr'];
        $header['js']=['/src/cplugs','/src/recus','/src/jquery-ui.min', '/src/toastr.min'];
        $this->renderH($header);
        $this->render('Finance.recus', [
            "recus" => RecusModel::getCurrentRecus(),
        ]);
        $this->renderF();
    }

    //filtre de recu
    public function filtreRecu(){
        Utils::HeaderJS();
        $filtre = $_POST['filtre'];
        $date = (new DateTime('now', new DateTimeZone('Indian/Antananarivo')))->format('Y-m-d');
        if($filtre == 'tous'){
            $data['recu'] = RecusModel::getCurrentRecus();
        }else if($filtre == 'now'){
            $data['recu'] = RecusModel::getRecuByDate($date);
            $data['total'] = RecusModel::getTotlaDay($date);
        }else if($filtre == 'annule'){
            $data['recu'] = RecusModel::getRecuByStatus(1);
        }else if($filtre == 'recus'){
            $data['recu'] = RecusModel::getRecuByStatus(0);
        }else{
            $data['recu'] = RecusModel::getCurrentRecus();
        }
        $data['type'] = $_SESSION['type'];
        echo json_encode($data);
    }


    public function CheckDate()
    {
        Utils::HeaderJS();
        $params=$_POST['d'];
        $ls=FsModel::getFromDate($params);
        echo json_encode($ls);
    }

    public function CheckDetail()
    {
        Utils::HeaderJS();
        $nm=$_POST['nm'];
        $fs=$_POST['fs'];
        $nv=$_POST['nv'];
        $gp=$_POST['gp'];
        $ls=FsModel::getDetail($nm,$fs,$nv,$gp);
        echo json_encode($ls);
    }

    public function UpdateFs()
    {
        Utils::HeaderJS();
        $res=FsModel::updateFs();
        echo json_encode($res);
    }
    public function ResetFs()
    {
        Utils::HeaderJS();
        $res=FsModel::resetFs();
        echo json_encode($res);
    }
    public function Imprimer()
    {
        $header['title']='Imprimer';
        $this->_renderH($header);
        $header['title']='Print';
        $this->render('Finance.print');
        $this->renderF();
    }

     //GET AUTO INCREMENT NIE
     public function CheckNum(){
        $num = FsModel::getNewNum($_POST['s']);
        echo $num;
    }

    public function getStudent(){
        Utils::HeaderJS();
        $NIE = $_POST['nie'];
        $data['etudiant'] = RecusModel::getStudent($NIE);
        echo json_encode($data);
    }

    //insert Recu
    public function addRecus(){
        Utils::HeaderJS();
        $nie = $_POST['nie'];
        $num_matr = $_POST['num_matr'];
        $designation = $_POST['designation'];
        $montant = str_replace(' ','',$_POST['montant']);
        $reste = str_replace(' ','',$_POST['reste']);
        $mode = $_POST['mode'];
        $num = $_POST['num'];
        $signataire = $_POST['signataire'];
        $modif = $_POST['modif'] ? $_POST['modif'] : NULL;
        $date_p = $_POST['date_p'];
        $date_bv = $_POST['date_bv'] ? $_POST['date_bv'] : NULL;
        $student = RecusModel::getStudentByMatr($num_matr);
        $AU_id = $student[0]['AU_id'];
        $NIV_id = $student[0]['idNIV'];
        $GP_id = $student[0]['idGP'];
        $date = (new DateTime('now', new DateTimeZone('Indian/Antananarivo')))->format('Y-m-d H:i:s');
        try {
            if($modif){
                RecusModel::insertRecus($AU_id, $NIV_id, $GP_id, $num_matr, $nie, $montant, $reste, $designation, $mode, $date, $num,$signataire, $modif, $date_p, $date_bv);
                $id = RecusModel::getLastId();
                RecusModel::annulerRecu($modif, $id);
			}else{
				RecusModel::insertRecus($AU_id, $NIV_id, $GP_id, $num_matr, $nie, $montant, $reste, $designation, $mode, $date, $num,$signataire, $modif, $date_p, $date_bv);
			}
            echo json_encode(['status'=>'ok']);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    // recherche
    public function findByNie(){
        Utils::HeaderJS();
        $txt = $_POST['txt'];
        $data = RecusModel::getRecusByNie($txt);
        echo json_encode($data);
    }

    //imprimer le reçus
    public function print($idR){
        $data = RecusModel::getRecus($idR);
        $this->render("print", ["recus" => $data]);
    }

    //number Converter to letter
    function convertToLetter($number){
        $convert = explode('.', $number);    
        $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
            'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');
                
        $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
                60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');
                    
        if (isset($convert[1]) && $convert[1] != '') {
            
            if($convert[1][0] == 0 || strlen($convert[1]) > 1){
            $convert[1] = (int) $convert[1];    
            }else{
            $convert[1] = (int) ($convert[1].'0');   
            }
        
            return self::convertToLetter($convert[0]).'$$$'.self::convertToLetter( $convert[1]);
        }
        if ($number < 0) return 'moins '.self::convertToLetter(-$number);
        if ($number < 17) {
            return $num[17][$number];
        }
        elseif ($number < 20) {
            return 'dix-'.self::convertToLetter($number-10);
        }
        elseif ($number < 100) {
            if ($number%10 == 0) {
            return $num[100][$number];
            }
            elseif (substr($number, -1) == 1) {
            if( ((int)($number/10)*10)<70 ){
            return self::convertToLetter((int)($number/10)*10).'-et-un';
            }
            elseif ($number == 71) {
            return 'soixante-et-onze';
            }
            elseif ($number == 81) {
            return 'quatre-vingt-un';
            }
            elseif ($number == 91) {
            return 'quatre-vingt-onze';
            }
            }
            elseif ($number < 70) {
            return self::convertToLetter($number-$number%10).'-'.self::convertToLetter($number%10);
            }
            elseif ($number < 80) {
            return self::convertToLetter(60).'-'.self::convertToLetter($number%20);
            }
            else {
            return self::convertToLetter(80).'-'.self::convertToLetter($number%20);
            }
        }
        elseif ($number == 100) {
            return 'cent';
        }
        elseif ($number < 200) {
            return self::convertToLetter(100).' '.self::convertToLetter($number%100);
        }
        elseif ($number < 1000) {
            return self::convertToLetter((int)($number/100)).' '.self::convertToLetter(100).($number%100 > 0 ? ' '.self::convertToLetter($number%100): '');
        }
        elseif ($number == 1000){
            return 'mille';
        }
        elseif ($number < 2000) {
            return self::convertToLetter(1000).' '.self::convertToLetter($number%1000).' ';
        }
        elseif ($number < 1000000) {
            return self::convertToLetter((int)($number/1000)).' '.self::convertToLetter(1000).($number%1000 > 0 ? ' '.self::convertToLetter($number%1000): '');
        }
        elseif ($number == 1000000) {
            return 'millions';
        }
        elseif ($number < 2000000) {
            return self::convertToLetter(1000000).' '.self::convertToLetter($number%1000000);
        }
        elseif ($number < 1000000000) {
            return self::convertToLetter((int)($number/1000000)).' '.self::convertToLetter(1000000).($number%1000000 > 0 ? ' '.self::convertToLetter($number%1000000): '');
        }
    }

    public function deleteRecu(){
        Utils::HeaderJS();
        $idR = $_POST['idr'];
        RecusModel::deleteById($idR);
        echo json_encode(['status' => "ok"]);
    }

    public function getRecu(){
        Utils::HeaderJS();
        $idR = $_POST['idR'];
        $data['recu'] = RecusModel::getRecus($idR);
        echo json_encode($data);
    }

}