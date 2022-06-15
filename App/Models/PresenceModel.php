<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Utils;
use App\Core\Database;
use App\Core\Alert;
use \DateTime;
class PresenceModel extends Model{
    protected $isPK='idPSC',
    $isAI=true;
    var $idPSC,$status,$TC_id,
    $INSCR_num_matr,$ETUDIANT_nie,
    $MOTIF_id;
    public function __construct(){
        parent::__construct();
    }

    
   public static function getListBy($nie,$type,$date_cours){
        $sql="select p.idpsc as ip,p.inscr_num_matr as nm,e.nie,e.nom,e.prenom,IF(e.sexe=1,'H','F') as sexe, concat(t.salle_id,' ( ',time_format(t.hdebut,'%H:%i'),' - ',time_format(t.hfin,'%H:%i'),' )') as salle,
        (select nom_mat from matiere where idMAT=t.MAT_id) as matiere 
        from presence p 
        inner join etudiant e on e.nie=p.etudiant_nie 
        inner join tcours t on p.tc_id=t.idtc 
        where e.nie=? and p.status=?  and t.date_cours=?;";
        $db=Database::getConnection();
        $stmt=$db->prepare($sql);
        $stmt->execute([$nie,$type,$date_cours]);
        return $stmt->fetchAll();
   }

   public static function getStatus($a){
       $lsa=['a'=>'ABSENCE NON JUSTIFIÉE','r'=>'RETARD NON JUSTIFIÉ','rj'=>'RETARD JUSTIFIÉ','aj'=>'ABSENCE JUSTIFIÉE'];
       if (array_key_exists($a,$lsa)) {
           return $lsa[$a];
       }
       return false;
   }

   public static function updateListABS($status,$num_matr,$lsid){
        $db=Database::getConnection();
        $db->beginTransaction();
        $nbU=0;$nbL=0;
        $status.='j';
        $absTitre=($status=='aj')?'"Absence justifiée" éfféctuée':'"Retard justifié" éfféctué';
        $sql='update presence set status=? where idpsc=? and inscr_num_matr=?;';
        try {
            $stmt= $db->prepare($sql);
            foreach ($lsid as $id) {
                $id=intval($id['ip']);
                if ($stmt->execute([$status,$id,$num_matr])) {
                    $nbU++;
                }
                $nbL++;
            }
            if ($nbL==$nbU) {
               $db->commit();
               Alert::get('success',"Mise à jour $absTitre avec succès !");
            } else {
                $db->rollback();
                Alert::get('info','Mise à jour annulée !');
            }
            
        } catch (\PDOException $ex) {
            Alert::get('info','Erreur du réseau !');
        }
   }

   public static function getStat($sd,$ed){
       $sql='select p.status,count(p.status) as somme,round(count(p.status)*100/a.total,2) as pourcentage from 
       (select count(*) as total from presence pr inner join tcours tc on pr.tc_id=tc.idtc where tc.date_cours between ? and  ?) a,presence p 
       inner join tcours t on p.tc_id=t.idtc 
       where t.date_cours between ? and  ? group by p.status order by somme desc;';
       $db=Database::getConnection();
       $stmt=$db->prepare($sql);
       $stmt->execute([$sd,$ed,$sd,$ed]);
       return $stmt->fetchAll();
   }

    public static function findE($dc,$st,$et,$numSalle,$mat_id,$num_matr,$nie){
        $sql='select p.* from presence p 
        inner join tcours t on p.tc_id=t.idtc 
        where t.date_cours=? and t.hdebut=? and t.hfin=? and t.salle_id=? and t.mat_id=? and p.inscr_num_matr=? and p.etudiant_nie=?;';
        $db=Database::getConnection();
        $stmt=$db->prepare($sql);
        try {
            $stmt->execute([ $dc,$st,$et,$numSalle,intval($mat_id),intval($num_matr),$nie]);
            return $stmt->fetch();
        } catch (\PDOException $ex) {
            return false;
        }
    }

    //Gestion ABS/RT
    public static function store(){
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::int_post(['nm','mat','prof','moti']);
        Utils::parseDate('dc');
        $date_cours=$_POST['dc'];
        $salle_id=$_POST['sal'];
        $mat_id=$_POST['mat'];
        $prof_id=$_POST['prof'];
        $num_matr=$_POST['nm'];
        $nie=$_POST['ne'];
        $st=$_POST['st'];$et=$_POST['et'];
        $motif_id=$_POST['moti'];
        $lstype=['r','a'];
        $type=$_POST['tpi'];
        if (!in_array($type,$lstype)) {
            Alert::get('danger','Vous n\'avez pas le droit de modifier quoi que ce sois. Merci !');
        }
        
        $lsDate_cours=TcoursModel::getLsCoursByNIE($date_cours,$salle_id,$num_matr,$nie);
        if (!empty($lsDate_cours)) {
            $d=new DateTime("$date_cours $st");
            $f=new DateTime("$date_cours $et");
            $res=TcoursModel::isBetween($d,$f,$lsDate_cours);
           
            if (!empty($res)) {
                if ($res['info']=='ko') {
                    Alert::error("Vérifier votre plage horaire car cette dernière appartient déjà une matière : <br>
                    <b>MATIÈRE :</b>  {$res['nom_mat']}<br>
                    <b>SALLE :</b> $salle_id<br>
                    <b>PLAGE HORAIRE:</b> {$res['sdt']->format('H:i')} à {$res['edt']->format('H:i')} ");
                }
                if ($res['info']=='ok') {
                    if ($res['MAT_id']!=$mat_id) {
                        Alert::get('danger','Votre matière ne correspond pas au matière qui est dèjà inséré :'.$res['nom_mat']);
                    }
                    //update
                    if ($motif_id!=-1) {
                        $res['MOTIF_id']=$motif_id;
                    } else {
                        $motif=new JustificationModel();
                        $motif->parse(['motif'=>$_POST['smot']]);
                        $i2=$motif->insert();
                        $lastIdM=intval($i2);
                        if(empty($lastIdM)){ $db->rollback(); Alert::error('a'); };
                        $res['MOTIF_id']=$lastIdM;
                    }
                
                    if($res['status']!=$type){
                        $old_status=self::getStatus($res['status']);
                        $res['status']=$type;
                        $p=new PresenceModel();
                        $p->parse($res);
                        $ee=$p->update();
                        if ($ee=='ok') {
                            Alert::get('warning',"Mise à jour éfféctuée pour <b>{$res['ETUDIANT_nie']}</b> marqué comme <b>$old_status</b><br>\"Merci d'avoir préciser le motif\" !");
                        } else {
                            Alert::debug($ee);
                        }
                        
                    }else{
                        $p=new PresenceModel();
                        $p->parse($res);
                        $ee=$p->update();
                        if ($ee=='ok') {
                            Alert::get('info','Mise à jour de la presence éfféctuée avec succès !');
                        } else {
                            Alert::debug($ee);
                        }
                    }

                }
            }
        }else{
             //add
             $otc=[
                'date_cours'=> $date_cours,
                'hdebut'=>$st,
                'hfin'=>$et,
                'MAT_id'=>$mat_id,
                'PR_id'=>$prof_id,
                'SALLE_id'=>$salle_id,
            ];
            //si exist mise à jour sinon ajout
            try {
                $db=Database::getConnection();
                $db->beginTransaction();
                $tc=new TcoursModel();
                $tc->parse($otc);
                $i1=$tc->insert();
                $lastId=intval($i1);
                if(empty($lastId)){ $db->rollback(); Alert::error('a'); };
                $o=[
                    'TC_id'=>$lastId,
                    'status'=>'r',
                    'INSCR_num_matr'=>$num_matr,
                    'ETUDIANT_nie'=>$nie,
                    //A INSERER
                    // 'MOTIF_id'=>$
                ];
                
                if ($motif_id!=-1) {
                    $o['MOTIF_id']=$motif_id;
                } else {
                    $motif=new JustificationModel();
                    $motif->parse(['motif'=>$_POST['smot']]);
                    $i2=$motif->insert();
                    $lastIdM=intval($i2);
                    if(empty($lastIdM)){ $db->rollback(); Alert::error('a'); };
                    $o['MOTIF_id']=$lastIdM;
                    
                }
                
                $obj= new PresenceModel();
                $obj->parse($o);
                $in=$obj->insert();
                $ci=intval($in);
                
                if(!empty($ci) && $ci>0){
                    $db->commit();
                    Alert::info('a');
                }else{
                    $db->rollback();
                    Alert::warning('a');
                }
            } catch (\PDOException $ex) {
                Alert::debug($ex->getMessage());
            }
        }  

    }
    


}