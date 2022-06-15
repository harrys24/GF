<?php
namespace App\Models;
use App\Core\Model;
class TrancheFsModel extends Model{
    protected $isPK='idT';
    protected $isAI=true;
    
    var $idT,$nbT;
    public function __construct(){
        parent::__construct();
    }
    

}
    