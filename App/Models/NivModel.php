<?php
namespace App\Models;
use App\Core\Model;
class NivModel extends Model{
    protected $isPK='idNIV';
    protected $isAI=true;
    
    var $idNIV,$nom_au,$description;
    public function __construct(){
        parent::__construct();
    }

    

}
    