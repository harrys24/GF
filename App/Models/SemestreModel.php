<?php
/**
 * Created by PhpStorm.
 * User: geek
 * Date: 21/10/2019
 * Time: 22:43
 */

namespace App\Models;
use App\Core\Model;
use App\Core\Database;


class SemestreModel extends Model
{

    protected $isPK='idSEM';
    protected $isAI=true;

    var $idSEM, $nom_sem, $NIV_id;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getListByNiv($NIV_id){
        $sql = 'SELECT idSEM, nom_sem FROM `semestre` WHERE NIV_id =?';
        try{
            $bd=Database::getConnection();
            $stm = $bd->prepare($sql);
            $stm->execute([$NIV_id]);
            return $stm->fetchAll();
        }catch (\PDOException $er){
            return $er->getMessage()."</br>";
        }
    }

}