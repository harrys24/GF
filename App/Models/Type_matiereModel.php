<?php
namespace App\Models;
use App\Core\Model;
class Type_matiereModel extends Model{
    protected $isPK='idTM';
    protected $isAI=true;
    
    var $idTM,$nom_type;
    public function __construct(){
        parent::__construct();
    }

    

}
    