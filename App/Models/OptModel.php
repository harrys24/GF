<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;
use App\Core\Alert;
class OptModel extends Model{
    
    var $modname,$champs,$key1,$key2;
    public function __construct($key1,$key2,$modname,$table,$champs){
        // parent::__construct();
        $this->key1=$key1;
        $this->key2=$key2;
        $this->modname=$modname;
        $this->table=$table;
        $this->champs=$champs;
        $this->db=Database::getConnection();
    }
    
    public function store(){
        $sql='INSERT INTO '.$this->table.' ('.$this->champs.') VALUES (?);';
        try {
            $value=trim($_POST[$this->key2]);
            if(empty($value)){
                Alert::error('Veuillez remplir les champs <strong>"Autre"</strong> par des valeurs non vides !');
            }
            $stmt=$this->db->prepare($sql);
            $stmt->execute([strtoupper($value)]);
            return intval(($this->db)->lastInsertId());
        } catch (\PDOException $ex) {
            return -1;
        }

    }

}
    