<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Model;
use App\Core\Utils;
use App\Core\Alert;
class MatiereModel extends Model{
    protected $isPK='idMAT';
    protected $isAI=true;
    
    var $idMAT,$nom_mat,$code_mat;
    public function __construct(){
        parent::__construct();
    }

   public static function store(){
        Utils::HeaderJS();
        Utils::PAuth();
        $m=new MatiereModel();
        $m->parse($_POST);
        if ($_POST['type']=='a') {
            $res=$m->insert();
            $lastId=intval($res);
            if (isset($lastId)) {
                echo json_encode(['color'=>'info','message'=>'Bien ajouté !','lastId'=>$lastId]);  
            } else {
                echo json_encode(['color'=>'danger','message'=>'Erreur \'ajout !']);     
            }
        } else {
            Utils::int_post('idMAT');
            $res=$m->update();
            if ($res=='ok') {
                echo json_encode(['color'=>'info','message'=>'Mise à jour efféctuée !','status'=>'u']);  
            } else {
                echo json_encode(['color'=>'danger','message'=>'Erreur de mise à jour!']);     
            }
            
        }
   }

   public static function getLs(){
        $db=Database::getConnection();
        $sql='select idMAT as id,nom_mat as value from matiere';
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."</br>";
        }
    }



   

}
    