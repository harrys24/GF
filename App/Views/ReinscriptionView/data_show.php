<?php 

//SHOW OPTION 
function showOPT_NIE($ns){
    $tab=['SE','SI'];
    if(isset($ns)){
        foreach ($tab as $value) {
            $n=($ns==$value)?'selected':'';
            echo '<option value="'.$value.'"'.$n.'>'.$value.'</option>';
        }
    } else {
        foreach ($tab as $value) {
        echo '<option value="'.$value.'">'.$value.'</option>';
        }
    }
}


function showUptOPT($fk_id,$ls,$key,$value){
    foreach ($ls as $item) {
        $s=($item[$key]==$fk_id)?'selected':'';
        echo '<option value="'.$item[$key].'"'.$s.'>'.$item[$value].'</option>';
    }
    
}

function showUptAOPT($fk_id,$ls,$key,$value){
    showUptOPT($fk_id,$ls,$key,$value);
    echo '<option value="-1">Autre...</option>';
}

function showOPT($ls,$key,$value){
    foreach ($ls as $item) {
        echo '<option value="'.$item[$key].'">'.$item[$value].'</option>';
    }
}

function showAOPT($ls,$key,$value){
    showOPT($ls,$key,$value);
    echo '<option value="-1">Autre...</option>';
}

function showPhoto($img_name){
    if(!empty($img_name)){
        echo '<img id="iphoto" class="img-thumbnail" src="/assets/images/students/'.$img_name.'" alt="non disponible">'.
        '<input type="hidden" name="checkPhoto" value="'.$img_name.'">';
    }
}
//SHOW SEXE
function showUptSexe($sexe){
    $sexe=($sexe=='1')?'H':'F';
    $tab=['H'=>'Homme','F'=>'Femme'];
    foreach ($tab as $key=>$value) {
        $c=($key==$sexe)?'checked':'';
        echo '<div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="rd_sexe'.$key.'" name="sexe" value="'.$key.'" class="custom-control-input" '.$c.'>
            <label class="custom-control-label" for="rd_sexe'.$key.'">'.$value.'</label>
        </div>';
    }
}
function showSexe(){
    $tab=['H'=>'Homme','F'=>'Femme'];
    foreach ($tab as $key=>$value) {
        echo '<div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="rd_sexe'.$key.'" name="sexe" value="'.$key.'" class="custom-control-input">
            <label class="custom-control-label" for="rd_sexe'.$key.'">'.$value.'</label>
        </div>';
    }
}

//SHOW CHECK VALUES
function showCHK($value){
    if($value=='1'){echo 'checked';}
}

//SHOW CONTACT
function showUpdContact($value,$suffixe='',$required=false){
    if($value){
        $required=($required)?'required':'';
        $t=explode(',',$value);
        echo '<input type="text" name="tel1'.$suffixe.'" value="'.$t[0].'" class="form-control font-italic" '.$required.'>
        <input type="text" name="tel2'.$suffixe.'" value="'.$t[1].'" class="form-control font-italic">
        <input type="text" name="tel3'.$suffixe.'" value="'.$t[2].'" class="form-control font-italic">';
    }else{
        showContact($suffixe,$required);
    }
    
}
function showContact($suffixe='',$required=false){
    $required=($required)?'required':'';
    echo '<input type="text" name="tel1'.$suffixe.'" class="form-control font-italic" '.$required.'>
    <input type="text" name="tel2'.$suffixe.'" class="form-control font-italic">
    <input type="text" name="tel3'.$suffixe.'" class="form-control font-italic">';
}

function showDetail_Tranche($fs){
    $str='';
    foreach ($fs as $item) {
        $str.='<div class="col-12 col-md-6 col-lg-4 form-group">
        <b>Tranche '.$item['num_tranche'].'</b>
        <input type="hidden" name="detail['.$item['num_tranche'].'][id]" value="'.$item['id'].'"/>
        <input type="hidden" value="'.$item['num_tranche'].'"/>
        <div class="input-group">
            <input type="date" value="'.$item['date_prevu'].'" class="col-lg-8 form-control" disabled>
            <input type="text" value="'.$item['montant_prevu'].'" class="col-lg-4 form-control" disabled>
            <div class="input-group-append bg-light"><div class="input-group-text">AR</div></div>
        </div></div>';
    }
    echo $str;
    
}

//SHOW LIST DATE PREVU
function showDate_prevu($fs){
    $str='';
    foreach ($fs as $item) {
    $str.='<div class="input-group form-group col-6  col-md-3 col-lg-2">
        <div class="input-group-prepend">
            <span class="input-group-text" >'.$item['num_tranche'].'T</span>
        </div>
        <input name="i'.$item['num_tranche'].'" value="'.$item['idFS'].'" type="hidden"/>
        <input name="'.$item['num_tranche'].'T" size="16" type="text" class="form-control form_date text-center" value="'.$item['date_prevu'].'" readonly >
        </div>';
    }
    echo $str;
    
}


?>