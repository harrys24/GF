<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
class Type_userModel extends Model{
    protected $isPK='idTU',
        $isAI=true;
        
    var $idTU,$type_tu;
    public function __construct(){
        parent::__construct();
    }

    public static function All(){
        $db=Database::getConnection();
        $s=" where type_tu!='devmaster'";
        if ($_SESSION['type']=='devmaster') { $s='';}
        $stmt = $db->query("select * from  type_user $s order by type_tu asc");
        return $stmt->fetchAll();
    }

    

    
    
}