<?php
namespace App\Models;
use App\Core\Model;
class SbModel extends Model{
    protected $isPK='idSB';
    protected $isAI=true;
    
    var $idSB,$serie;
    public function __construct(){
        parent::__construct();
    }
    

}
    