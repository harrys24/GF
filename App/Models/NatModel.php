<?php
namespace App\Models;
use App\Core\Model;
class NatModel extends Model{
    protected $isPK='idNAT';
    protected $isAI=true;
    
    var $idNAT,$nationalite;
    public function __construct(){
        parent::__construct();
    }
    

}
    