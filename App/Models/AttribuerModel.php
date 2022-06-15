<?php
namespace App\Models;
use App\Core\AModel;
use App\Core\Utils;
use App\Core\Alert;
use App\Core\Database;
class AttribuerModel {
    

    public static function storeAttr(){

        try {
            Utils::HeaderJS();
            $con=Database::getConnection();
            $con->beginTransaction();
            $nb=intval($_POST['nb']);
            $au_id=intval($_POST['AU_id']);
            $niv_id=intval($_POST['NIV_id']);
            $ue_id=intval($_POST['UE_id']);
            $mat_id=intval($_POST['MAT_id']);
            $tm_id=intval($_POST['TM_id']);
            $sql='INSERT INTO attribuer (AU_id,NIV_id,UE_id,MAT_id,TM_id,GP_id,SEM_id,credit,PR_id) VALUES (?,?,?,?,?,?,?,?,?)';
            $stmt=$con->prepare($sql);
            $isok=true;
            for ($i=0; $i < $nb ; $i++) { 
                $item=$_POST['list'][$i];
                $res=$stmt->execute([
                    $au_id,$niv_id,$ue_id,$mat_id,$tm_id,
                    intval($item['GP_id']),
                    intval($item['SEM_id']),
                    intval($item['credit']),
                    intval($item['PR_id'])
                ]);
                $res=($res)?true:false;
                $isok &= $res;
            }
            if ($isok) {
                $con->commit();
                echo \json_encode([
                    'color'=>'info',
                    'message'=>'Bien ajouté',
                    'response'=>'ok'
                ]);
            } else {
                $con->rollBack();
                echo \json_encode([
                    'color'=>'danger',
                    'message'=>'Erreur d\'ajout',
                    'response'=>'ko'
                ]);
            }
        } catch (\PDOException $ex) {
            $con->rollBack();
            echo \json_encode([
                'color'=>'danger',
                'message'=>'Ces données existent déjà.',
                'response'=>'ko'
            ]);
        }
    }

    public static function storeAutrAttr(){

        try {
            Utils::HeaderJS();
            $con=Database::getConnection();
            $con->beginTransaction();
            $nb=intval($_POST['nb']);
            $au_id=intval($_POST['AU_id']);
            $niv_id=intval($_POST['NIV_id']);
            $mat_id=intval($_POST['MAT_id']);
            $sql='INSERT INTO attribuer_autre_n (AU_id,NIV_id,MAT_id,GP_id,SEM_id,PR_id) VALUES (?,?,?,?,?,?)';
            $stmt=$con->prepare($sql);
            $isok=true;
            for ($i=0; $i < $nb ; $i++) { 
                $item=$_POST['list'][$i];
                $res=$stmt->execute([
                    $au_id,$niv_id,$mat_id,
                    intval($item['GP_id']),
                    intval($item['SEM_id']),
                    intval($item['PR_id'])
                ]);
                $res=($res)?true:false;
                $isok &= $res;
            }
            if ($isok) {
                $con->commit();
                echo \json_encode([
                    'color'=>'info',
                    'message'=>'Bien ajouté',
                    'response'=>'ok'
                ]);
            } else {
                $con->rollBack();
                echo \json_encode([
                    'color'=>'danger',
                    'message'=>'Erreur d\'ajout',
                    'response'=>'ko'
                ]);
            }
        } catch (\PDOException $ex) {
            $con->rollBack();
            echo \json_encode([
                'color'=>'danger',
                'message'=>'Ces données existent déjà.',
                'response'=>'ko'
            ]);
        }
    }

    public static function findByFilter(){
        Utils::HeaderJS();
        $con=Database::getConnection();
        $sql="SELECT a.PR_id as ipr,a.MAT_id as imat,a.UE_id as iue,a.credit,m.nom_mat,t.nom_type,concat(p.nom_pr,' ',p.prenom_pr) as np_pr,concat(u.titre_ue,' - ',u.nom_ue) as due from attribuer a 
        INNER JOIN matiere m ON m.idMAT=a.MAT_id 
        INNER JOIN type_matiere t ON t.idTM=a.TM_id 
        INNER JOIN professeur p ON p.idPR=a.PR_id 
        INNER JOIN ue u ON u.idUE=a.UE_id 
        WHERE a.AU_id=? AND a.NIV_id=? AND a.GP_id=? AND a.SEM_id=? ORDER BY due,m.nom_mat ASC;";
        $stmt=$con->prepare($sql);
        $params=[
            intval($_POST['iau']),
            intval($_POST['iniv']),
            intval($_POST['igp']),
            intval($_POST['isem'])
        ];
        $stmt->execute($params);
        $mats=$stmt->fetchAll();
        $sql="SELECT a.PR_id as ipr,a.MAT_id as imat,m.nom_mat,concat(p.nom_pr,' ',p.prenom_pr) as np_pr from attribuer_autre_n a 
        INNER JOIN matiere m ON m.idMAT=a.MAT_id 
        INNER JOIN professeur p ON p.idPR=a.PR_id 
        WHERE a.AU_id=? AND a.NIV_id=? AND a.GP_id=? AND a.SEM_id=? ;";
        $stmt=$con->prepare($sql);
        $stmt->execute($params);
        $aut_mats=$stmt->fetchAll();
        
        echo \json_encode([
            'mats'=>$mats,
            'aut_mats'=>$aut_mats
        ]);
    }

    public static function deleteAttr(){
        try {
            Utils::HeaderJS();
            $con=Database::getConnection();
            $p=$_POST['p'];
            $cp=$_POST['cp'];
            if ($cp['type']=='a') {
                $sql='DELETE FROM attribuer WHERE AU_id=? AND NIV_id=? AND GP_id=? AND SEM_id=? AND MAT_id=? AND PR_id=? AND UE_id=?;';
                $stmt=$con->prepare($sql);
                $stmt->execute([
                    \intval($p['iau']),\intval($p['iniv']),\intval($p['igp']),\intval($p['isem']),
                    \intval($cp['imat']),\intval($cp['ipr']),\intval($cp['iue'])
                ]);
                echo \json_encode([
                    'color'=>'info',
                    'message'=>'Bien supprimé',
                    'response'=>'a'
                    ]);

            } else {
                $sql='DELETE FROM attribuer_autre_n WHERE AU_id=? AND NIV_id=? AND GP_id=? AND SEM_id=? AND MAT_id=? AND PR_id=?;';
                $stmt=$con->prepare($sql);
                $stmt->execute([
                    \intval($p['iau']),\intval($p['iniv']),\intval($p['igp']),\intval($p['isem']),
                    \intval($cp['imat']),\intval($cp['ipr'])
                ]);
                echo \json_encode([
                    'color'=>'info',
                    'message'=>'Bien supprimé',
                    'response'=>'b'
                    ]);

            }
            
            

        } catch (\PDOException $ex) {
            echo \json_encode([
                'color'=>'danger',
                'message'=>$ex,
                'response'=>'e'
            ]);
        }
    }

    public static function _store(){

        try {
            Utils::HeaderJS();
            $con=Database::getConnection();
            $pa=$_POST['p'];
            $pb=$_POST['cp'];
            $sql='DELETE FROM attribuer WHERE AU_id=? AND NIV_id=? AND GP_id=? AND SEM_id=? AND MAT_id=? AND PR_id=? AND UE_id=?; ';
            $stmt=$con->prepare($sql);
            if ($isok) {
                $stmt->execute([
                    \intval($_POST['iau']),
                ]);
                echo \json_encode([
                    'color'=>'info',
                    'message'=>'Bien ajouté'
                ]);
            } else {
                echo \json_encode([
                    'color'=>'danger',
                    'message'=>'Erreur d\'ajout'
                ]);
            }
        } catch (\PDOException $ex) {
            echo \json_encode([
                'color'=>'danger',
                'message'=>$ex
            ]);
        }
    }
    
}
    