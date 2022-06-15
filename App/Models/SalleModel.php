<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Model;
class SalleModel extends Model{
    protected $isPK='numSALLE';
    protected $isAI=false;
    
    var $numSALLE,$etage,$description;
    public function __construct(){
        parent::__construct();
    }


}
    