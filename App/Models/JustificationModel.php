<?php
namespace App\Models;
use App\Core\Model;
class JustificationModel extends Model{
    protected $isPK='idMOTIF';
    protected $isAI=true;
    
    var $idMOTIF,$motif;
    public function __construct(){
        parent::__construct();
    }
    

}
    