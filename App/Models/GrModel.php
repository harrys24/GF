<?php
namespace App\Models;
use App\Core\Model;
class GrModel extends Model{
    protected $isPK='idGR';
    protected $isAI=true;
    
    var $idGR,$nom_gr;
    public function __construct(){
        parent::__construct();
    }

    

}
    