<?php
namespace App\Models;
use App\Core\Model;
class AuModel extends Model{
    protected $isPK='idAU';
    protected $isAI=true;
    
    var $idAU,$nom_au;
    public function __construct(){
        parent::__construct();
    }

    

}
    