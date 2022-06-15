<?php
namespace App\Models;
use App\Core\Model;
class RecruteurModel extends Model{
    protected $isPK='idREC';
    protected $isAI=true;
    
    var $idREC,$nom_rec,$prenom_rec,$sexe_rec,$email_rec,$poste_rec;
    public function __construct(){
        parent::__construct();
    }
    

}
    