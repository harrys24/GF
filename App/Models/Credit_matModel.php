<?php
namespace App\Models;
use App\Core\Model;
class Credit_matModel extends Model{
    protected $isPK='idcredit';
    protected $isAI=true;
    
    var $idcredit,$credit;
    public function __construct(){
        parent::__construct();
    }

    

}
    