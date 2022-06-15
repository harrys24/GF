<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database;

class StatistiqueModel {

    public static function getAU_GP($nom_au,$nom_niv)
    {
        $sql="SELECT n.idNIV,n.nom_niv,g.idGP,g.nom_gp from gp_has_au gp 
        inner join au a on gp.AU_id=a.idAU 
        inner join niv n on gp.NIV_id=n.idNIV 
        inner join gp g on gp.GP_id=g.idGP 
        where a.nom_au=? and n.nom_niv=? and g.nom_gp not regexp '[0-9]'";
        $db=Database::getConnection();
        $stmt=$db->prepare($sql);
        $stmt->execute([$nom_au,$nom_niv]);
        return $stmt->fetchAll();
        
    }

    function concatArrays($arrays){
        $buf = [];
        foreach($arrays as $arr){
            foreach($arr as $v){
                $buf[$v] = true;
            }
        }
        return array_keys($buf);
    }
    
    public static function getCheckData()
    {
        // $nom_au=$_POST['au'];$nom_niv=$_POST['niv'];
        $nom_au='2020-2021';$nom_niv='L1';
        $ls_niv=self::getAU_GP($nom_au,$nom_niv);
        $labels=[];$data=[];
        foreach ($ls_niv as $item) {
            $nom_gp=$item['nom_gp'];
            $res=self::getData($nom_au,$item['nom_niv'],$nom_gp);
            $labels=array_merge($labels,$res['lb']);
            $data[]=['label'=>"$nom_niv $nom_gp",'data'=>$res['data']];
        }
       return $labels;

       
    
        // return [
        //     'labels'=>array_column($res, 'dti'),
        //     'data'=>array_column($res, 'nb')
        // ];
    }



    public static function getData()
    {
        $au=$_POST['au'];$niv=$_POST['niv'];$gp=$_POST['gp'];
        // $nom_au='2020-2021';$nom_niv='L1';$nom_gp='TC';
        $db=Database::getConnection();
        $sql="SELECT DATE_FORMAT(i.dateInscr,'%d/%m/%y') as dti,COUNT(e.nie) as nb FROM inscription i 
        INNER JOIN etudiant e ON e.nie=i.ETUDIANT_nie 
        INNER JOIN au a ON a.idAU=i.AU_id 
        INNER JOIN niv n ON n.idNIV=i.NIV_id 
        INNER JOIN gp g ON g.idGP=i.GP_id 
        WHERE a.idAU=? AND n.idNIV=? AND g.idGP=? GROUP BY i.dateInscr ORDER BY i.dateInscr ASC;";
        $stmt=$db->prepare($sql);
        $stmt->execute([$au,$niv,$gp]);
        $res=$stmt->fetchAll();
        return [
            'label'=>array_column($res, 'dti'),
            'borderColor'=> 'rgb(255, 99, 132)',
            'data'=>array_column($res, 'nb')
        ];
    }

}
    