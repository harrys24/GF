<?php
namespace App\Models;
use App\Core\Alert;
use App\Core\Model;
use App\Models\AuModel;

class DataModel {
    const PHOTO_DIR='assets/images/students/',
    EXTS=['jpg','jpeg','png'];
    
    //ETUDIANT UTILS --------------------------------------------
    public static function getData(){
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=NivModel::getList('nom_niv','ASC');
        $data['nat']=NatModel::getList('nationalite','ASC');
        $data['rec']=RecruteurModel::getList('poste_rec','ASC');
        $data['ab']=AbModel::getList('annee','DESC');
        $data['sb']=SbModel::getList('serie','ASC');
        $data['mb']=MbModel::getList('mention','DESC');
        $data['do']=DoModel::getList('diplome','ASC');
        $data['tranchefs']=TrancheFsModel::getList('nbT','ASC');
        return $data;
    }

    public static function parseDate($date){
        if (is_array($date)) {
            foreach ($date as $value) {
                $t=str_replace('/','-',$_POST[$value]);
                $_POST[$value]=date('Y-m-d',strtotime($t));
            }
        } else {
            $t=str_replace('/','-',$_POST[$date]);
            $_POST[$date]=date('Y-m-d',strtotime($t));
        }
        
    }
    
    public static function addAutre(){
        //AUTRE VALUES
        $lsO=[
            new OptModel('NAT_id','inat','NatModel','nat','nationalite'),
            new OptModel('DO_id','ido','DoModel','do','diplome'),
            new OptModel('SB_id','isb','SbModel','sb','serie')
        ];
        foreach ($lsO as $om) {
            if(isset($_POST[$om->key1])){
                $_POST[$om->key1]=intval($_POST[$om->key1]);
            }else{
                $lastId=$om->store();
                if($lastId!=-1){
                    $_POST[$om->key1]=$lastId;
                    unset($_POST[$om->key2]);
                }else{
                    $response=[
                        'message'=>"Erreur d'enregistrement des Autres valeurs !",
                        'color'=>'danger','status'=>'ko'
                    ];
                    echo json_encode($response);
                    exit();
                }
            }
            
        }
    }

    public static function parseContacte($suffixe=''){
        $c1='tel1'.$suffixe;
        $c2='tel2'.$suffixe;
        $c3='tel3'.$suffixe;
        $_POST['contacte'.$suffixe]= $_POST[$c1].','.$_POST[$c2].','.$_POST[$c3];
        unset($_POST[$c1],$_POST[$c2],$_POST[$c3]);
    }

    public static function uploadPhoto_Etudiant(){
        $photo='photo';
        $nie=$_POST['nie'];
        
        if(isset($_POST['checkPhoto'])){
            $_POST[$photo]=$_POST['checkPhoto'];
        }
        $filename=$_FILES[$photo]['name'];
        $error=$_FILES[$photo]['error'];
        if (!empty($filename && $error==0)) {
            $imgType=pathinfo($filename,PATHINFO_EXTENSION);
            $imgType=strtolower($imgType);
            $new_filename=$nie.'.'.$imgType;
            $location=self::PHOTO_DIR.$new_filename;
            if(!in_array($imgType,self::EXTS)){
                Alert::error('Fichier non valide !');
            }else{
                $df=self::PHOTO_DIR."$nie.{png,jpg,jpeg}";
                array_map( "unlink", glob( $df,GLOB_BRACE ) );

                if (move_uploaded_file($_FILES[$photo]['tmp_name'],$location)) {
                    $_POST[$photo]=$new_filename;
                } else {
                    Alert::error('Fichier non déplacé au serveur !');
                }
                
            }
        } 
    }
    // ----------------------------------------------------------


}
    