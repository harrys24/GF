<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Utils;
use App\Core\Database;
class DeleguesModel extends Model{
    protected $isPK='username',
    $isAI=false;
    var $username,$password,$INSCR_num_matr,$create_time;
    public function __construct(){
        parent::__construct();
    }


    public static function All(){
        $sql='select e.nie,e.nom,e.prenom,e.email,d.*,a.*,g.idGP,g.nom_gp,n.* from inscription i 
        inner join delegues d on i.num_matr=d.inscr_num_matr 
        inner join etudiant e on i.etudiant_nie=e.nie 
        inner join au a on i.au_id=a.idau 
        inner join niv n on i.niv_id=n.idniv 
        inner join gp g on i.gp_id=g.idgp order by n.nom_niv,g.nom_gp asc';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public static function check_cmp($value)
    {
        $sql='SELECT * FROM delegues WHERE INSCR_num_matr=?;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1,$value);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $ex) {
            return false;
        }
    }
    

    
    

}