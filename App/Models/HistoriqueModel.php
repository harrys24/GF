<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
use DateTimeInterface;
use DateTimeZone;

class HistoriqueModel extends Model{
    protected $isPK='id';
    protected $isAI=true;
    
    var $id,$data;
    public function __construct(){
        parent::__construct();
    }

    /**
     * add stories users
     *
     * @param String $type_action
     * @param String $txt
     * @return void
     */
    public static function insertData($type_action,$etudiant,$txt='')
    {
        $db=Database::getConnection();
        $username=self::getUser();
        $sql= 'INSERT INTO historique (username,type_action,etudiant,information,created_at) VALUES (?,?,?,?,?);';
        $stmt=$db->prepare($sql);
        return $stmt->execute([$username,$type_action,$etudiant,$txt,self::getDatetimeNow()]);
    }

    public static function getUser()
    {
        return $_SESSION['username'].' ('.$_SESSION['type'].') - '.$_SESSION['prenom'].' '.$_SESSION['nom'];
    }

    public static function getDatetimeNow()
    {
        return (new \DateTime('now',new DateTimeZone('Indian/Antananarivo')))->format('Y-m-d\TH:i:s');
    }

  

}
    