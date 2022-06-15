<?php require 'data_show.php'; ?>
<div class="container">
<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<form method="POST" action="/Etudiant/checkEtudiant" enctype="multipart/form-data" id="formEtudiant">
  
  <div id="htitre">
    <h3 class="text-primary bg-white py-3 px-4 border">FICHE DE REINSCRIPTION : <span class="text-secondary"><?php echo $etudiant['prenom'].' '.$etudiant['nom']; ?></span></h3>
  </div>
  <div id="cphoto">
    <?php if(isset($etudiant)) showPhoto($etudiant['photo']); ?>
  </div>
  <!-- ETUDIANT -->
  <div class="row">
      <span class="h5 text-<?php echo $_SESSION['type']; ?> my-3 ml-2" data-toggle="tooltip" data-placement="top" title="ETUDIANT">ETUDIANT</span>
  </div>
  <!-- AU -->
  <div class="row">
    <div class="input-group form-group col-10 col-md-6 col-lg-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >AU<em class="text-warning pl-1">*</em></span>
      </div>
      <select name="AU_id" id="au" class="form-control" required>
      <?php isset($etudiant)?showUptOPT($etudiant['AU_id'],$au,'idAU','nom_au'):showOPT($au,'idAU','nom_au') ?>
      </select>
    </div>
    <div class="col-8 col-md-2 form-group">
        <input type="checkbox" name="abandon" data-toggle="toggle" data-on="ABANDON" data-off="NON ABD" data-onstyle="danger" data-offstyle="primary" data-width="156" <?php if(isset($etudiant)){ showCHK($etudiant['abandon']); }; ?>>
    </div>
     <!-- PHOTO -->
     <div class="input-group form-group col-12 col-md-6 col-lg-4">
      <div class="custom-file">
          <input type="file" name="photo" class="custom-file-input" id="photo" lang="fr" accept=".jpg,.jpeg,.png">
          <label class="custom-file-label" for="photo" id="photoText">Parcourir</label>
      </div>
    </div>
  </div>
  <div class="row">
    <!-- NIE -->
      <div class="input-group form-group col-10 col-md-6 col-lg-4">
      <div class="input-group-prepend">
        <span class="input-group-text" >NIE<em class="text-warning pl-1">*</em></span>
      </div>
      <?php 
      if(isset($etudiant)){
        $nie=$etudiant['nie'];
        $ns=substr($nie,0,2);
        $na=substr($nie,2,4);
        $nn=substr($nie,-4);

        echo'<input type="hidden" id="_nie" name="nie" value="'.$nie.'"/>';
      }?>
      <select id="nie_saison" class="form-control" disabled>
        <?php showOPT_NIE($ns); ?>
      </select>
      <input type="text" value="<?php echo isset($etudiant)?$na:''; ?>" id="nie_annee" class="form-control " placeholder="ANNEE" disabled>
      <input type="text" value="<?php echo isset($etudiant)?$nn:''; ?>" id="nie_num" class="form-control" placeholder="NUM." disabled>
    </div>
    <!-- Niveau et GP -->
    <div class="input-group form-group col-10 col-md-6 offset-lg-1 col-lg-4">
      <div class="input-group-prepend">
        <span id="pr_niv" class="input-group-text" >NIVEAU<em class="text-warning pl-1">*</em></span>
      </div>
      <select name="NIV_id" id="niv" class="form-control" required>
      <?php isset($etudiant)?showUptOPT($etudiant['NIV_id'],$niv,'idNIV','nom_niv'):showOPT($niv,'idNIV','nom_niv') ?>
      </select>
      <select name="GP_id" id="gp" class="form-control" required>
      <?php isset($etudiant)?showUptOPT($etudiant['GP_id'],$gp,'idGP','nom_gp'):showOPT($gp,'idGP','nom_gp') ?>
      </select>
    </div>
   
      
  </div>

    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom<em class="text-warning pl-1">*</em></span>
        </div>
      <input type="text" name="nom" value="<?php echo isset($etudiant)?$etudiant['nom']:''; ?>" class="form-control" placeholder="votre nom(s)" required>
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)<em class="text-warning pl-1">*</em></span>
        </div>
      <input type="text" name="prenom" value="<?php echo isset($etudiant)?$etudiant['prenom']:''; ?>" class="form-control" placeholder="votre prénom(s)" required>
      </div>
    </div>
    <!--SEXE et NATIONALITE -->
    <div class="row">
      <div class="input-group col-12 col-md-5 col-lg-4 mt-0 mt-md-1 mt-lg-2">
        <?php isset($etudiant)?showUptSexe($etudiant['sexe']):showSexe(); ?>
      </div>
      
      <div class="input-group form-group col-10 col-md-5 offset-lg-1 col-lg-3">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nationalité<em class="text-warning pl-1">*</em></span>
        </div>
        <select name="NAT_id" id="nat" class="form-control" required>
        <?php isset($etudiant)?showUptAOPT($etudiant['NAT_id'],$nat,'idNAT','nationalite'):showAOPT($nat,'idNAT','nationalite') ?>
        </select>
      </div>
      <div id="ca_nat" class="ca"></div>
    </div>
    <!--DATE et LIEU DE NAISSANCE -->
    <div class="row">
      <div class="input-group form-group col-8 col-md-4 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >Date de naissance<em class="text-warning pl-1">*</em></span>
        </div>
        <input id="dateNaiss" name="dateNaiss" value="<?php if(isset($etudiant)){ echo $etudiant['datenaiss'];} ?>" size="16" type="text" class="form-control form_date text-center" readonly required>
        <div class="input-group-append">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#calendar"></svg></span>
        </div>
      </div>

      <div class="input-group form-group col-12 col-md-8  offset-lg-1 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Lieu de naissance<em class="text-warning pl-1">*</em></span>
        </div>
      <input type="text" name="lieuNaiss" class="form-control" placeholder="à" value="<?php echo isset($etudiant)?$etudiant['lieunaiss']:''; ?>" required>
      </div>
    </div>
    <!-- ADRESSE ,CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-10 col-md-9 col-lg-5">
        <div class="input-group-prepend">
        <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#home"></svg><em class="text-warning pl-1">*</em></span>
        </div>
      <input class="form-control" type="text" name="adresse" value="<?php echo isset($etudiant)?$etudiant['adresse']:''; ?>" required>
      </div>
      <div id="cce" class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text"><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg><em class="text-warning pl-1">*</em></span>
        </div>
        <?php isset($etudiant)?showUpdContact($etudiant['contacte'],'',true):showContact('',true); ?>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
        </div>
      <input type="email" name="email" value="<?php echo isset($etudiant)?$etudiant['email']:''; ?>" class="form-control" placeholder="__@mail.com" >
      </div>
    </div>

    <!-- BACC -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >BACC<em class="text-warning pl-1">*</em></span>
        </div>
        <select name="AB_id" id="ab" class="form-control" required>
        <?php isset($etudiant)?showUptOPT($etudiant['AB_id'],$ab,'idAB','annee'):showOPT($ab,'idAB','annee') ?>
        </select>
        <select name="SB_id" id="sb" class="form-control" required>
        <?php isset($etudiant)?showUptAOPT($etudiant['SB_id'],$sb,'idSB','serie'):showAOPT($sb,'idSB','serie') ?>
        </select>
        <select name="MB_id" id="mb" class="form-control" required>
        <?php isset($etudiant)?showUptOPT($etudiant['MB_id'],$mb,'idMB','mention'):showOPT($mb,'idMB','mention') ?>
        </select>
      </div>
        <div id="ca_sb" class="ca"></div>
      <!-- ETABLISSEMENT PRECEDENT -->
      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <div class="input-group-text" >Etablissement<em class="text-warning pl-1">*</em></div>
        </div>
      <input type="text" name="EP" class="form-control" required>
      </div>
    </div>

    <div class="row">
      <div class="input-group form-group col-12 col-md-5 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >Dernier diplôme<em class="text-warning pl-1">*</em></span>
        </div>
        <select name="DO_id" id="do" class="form-control" required>
        <?php isset($etudiant)?showUptAOPT($etudiant['DO_id'],$do,'idDO','diplome'):showAOPT($do,'idDO','diplome') ?>
        </select>
      </div>
      <div id="ca_do" class="ca"></div>

      <div class="input-group form-group col-12 col-md-7 offset-lg-1 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >en</span>
        </div>
      <input type="text" name="do_en" class="form-control" >
      </div>
    </div>

    <!-- PERE -->
    <div class="row">
        <span class="h5 text-<?php echo $_SESSION['type']; ?> my-3 ml-2">PÈRE</span>
    </div>
    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom</span>
        </div>
      <input type="text" name="nom_p" value="<?php echo isset($etudiant)?$etudiant['nom_p']:''; ?>" class="form-control" placeholder="nom du père" >
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
        <input type="text" name="prenom_p" value="<?php echo isset($etudiant)?$etudiant['prenom_p']:''; ?>" class="form-control" placeholder="prénom du père" >
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
      <input type="text" name="profession_p" value="<?php echo isset($etudiant)?$etudiant['profession_p']:''; ?>" class="form-control" placeholder="proféssion du père" >
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#home"></span>
        </div>
      <input type="text" name="adresse_p" value="<?php echo isset($etudiant)?$etudiant['adresse_p']:''; ?>" class="form-control" placeholder="adresse du père" >
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg></span>
        </div>
        <?php isset($etudiant)?showUpdContact($etudiant['contacte_p'],'_p'):showContact('_p'); ?>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
        </div>
      <input type="email" name="email_p" value="<?php echo isset($etudiant)?$etudiant['email_p']:''; ?>" class="form-control" placeholder="__@mail.com" >
      </div>
    </div>


    <!-- MÈRE -->
    <div class="row">
        <span class="h5 text-<?php echo $_SESSION['type']; ?> my-3 ml-2">MÈRE</span>
    </div>
    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom</span>
        </div>
      <input type="text" name="nom_m" value="<?php echo isset($etudiant)?$etudiant['nom_m']:''; ?>" class="form-control" placeholder="nom de la mère" >
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
      <input type="text" name="prenom_m" value="<?php echo isset($etudiant)?$etudiant['prenom_m']:''; ?>" class="form-control" placeholder="prénom de la mère" >
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
      <input type="text" name="profession_m" value="<?php echo isset($etudiant)?$etudiant['profession_m']:''; ?>" class="form-control" placeholder="proféssion de la mère" >
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#home"></span>
        </div>
      <input type="text" name="adresse_m" value="<?php echo isset($etudiant)?$etudiant['adresse_m']:''; ?>" class="form-control" placeholder="adresse de la mère" >
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg></span>
        </div>
        <?php isset($etudiant)?showUpdContact($etudiant['contacte_m'],'_m'):showContact('_m'); ?>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
        </div>
      <input type="email" name="email_m" value="<?php echo isset($etudiant)?$etudiant['email_m']:''; ?>" class="form-control" placeholder="__@mail.com" >
      </div>
    </div>


    <!-- tuteur -->
    <div class="row">
        <span class="h5 text-<?php echo $_SESSION['type']; ?> my-3 ml-2">TUTEUR</span>
    </div>
    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom</span>
        </div>
      <input type="text" name="nom_t" value="<?php echo isset($etudiant)?$etudiant['nom_t']:''; ?>" class="form-control" placeholder="nom du tuteur" >
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
      <input type="text" name="prenom_t" value="<?php echo isset($etudiant)?$etudiant['prenom_t']:''; ?>" class="form-control" placeholder="prénom du tuteur" >
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
      <input type="text" name="profession_t" value="<?php echo isset($etudiant)?$etudiant['profession_t']:''; ?>" class="form-control" placeholder="proféssion du tuteur" >
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#home"></span>
        </div>
      <input type="text" name="adresse_t" value="<?php echo isset($etudiant)?$etudiant['adresse_t']:''; ?>" class="form-control" placeholder="adresse du tuteur" >
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg></span>
        </div>
        <?php isset($etudiant)?showUpdContact($etudiant['contacte_t'],'_t'):showContact('_t'); ?>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
        </div>
      <input type="email" name="email_t" value="<?php echo isset($etudiant)?$etudiant['email_t']:''; ?>" class="form-control" placeholder="__@mail.com" >
      </div>
    </div>

    <!-- DOSSIER-->
    <div class="row">
        <span class="h5 text-<?php echo $_SESSION['type']; ?> my-3 ml-2">DOSSIER ET DI</span>
    </div>

    <div class="ml-3 mb-3">
      <input type="hidden" id="list_dossier" name="list_dossier"/>
      <div id="ckdossier" class="row">
      <?php if(isset($dossier)){ 
        foreach ($dossier as $key => $value) {?>
        <div class="col-6 col-md-4 col-lg-3 custom-control custom-checkbox">
          <input type="checkbox" name="<?php echo $key; ?>" class="custom-control-input" id="<?php echo $key; ?>" <?php showCHK($etudiant[$key]); ?>>
          <label class="custom-control-label" for="<?php echo $key; ?>"><?php echo $value; ?></label>
        </div>
      <?php }} ?>
      </div>
    </div>

    <!--ENTRETIEN -->
    <div class="form-row">
      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text bg-white text-<?php echo $_SESSION['type']; ?>" >ENTRETIEN<em class="text-warning pl-1">*</em></span>
        </div>
        <input name="dateRec" value="<?php if(isset($etudiant)){ echo $etudiant['dateRec'];} ?>" size="16" type="text" class="form-control form_date text-center" readonly required>
        <div class="input-group-prepend">
          <span class="input-group-text bg-white text-<?php echo $_SESSION['type']; ?>" >AVEC</span>
        </div>
        <select name="REC_id" id="recruteur" class="form-control" required>
        <?php isset($etudiant)?showUptOPT($etudiant['REC_id'],$rec,'idREC','poste_rec'):showOPT($rec,'idREC','poste_rec') ?>
        </select>
      </div>
    </div>

    <!--MODE DE PAIEMENT -->
    <div class="row">
      <!--DEBUT DE PAIEMENT -->
    <div class="input-group form-group col-10  col-md-4 col-lg-3">
        <div class="input-group-prepend">
          <span class="input-group-text" >A partir du<em class="text-warning pl-1">*</em></span>
        </div>
      <input name="sd" value="<?php echo isset($fs)?$fs[0]['date_prevu']:date('d/m/Y'); ?>" id="sd" size="16" type="text" class="form-control form_date text-center font-italic" readonly required>
      </div>
      <div class="input-group form-group col-8 col-md-6 col-lg-3">
        <div class="input-group-prepend">
          <span class="input-group-text" >Tranche<em class="text-warning pl-1">*</em></span>
        </div>
        <input type="hidden" id="nbTranche" name="nbTranche">
        <select name="TrancheFS_id" id="tranchefs" class="form-control" required> 
        <?php isset($etudiant)?showUptOPT($etudiant['TrancheFS_id'],$tranchefs,'idT','nbT'):showOPT($tranchefs,'idT','nbT') ?>
        </select>
        <div class="input-group-append">
          <span class="input-group-text" >FOIS</span>
        </div>
      </div>
    
    </div>

    <!--LISTES DPAIEMENT -->
    <div class="form-row" id="listPContainer">
    <?php if(isset($fs)){ showDate_prevu($fs); } ?>
    </div>
    <!-- DI -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >DI<em class="text-warning pl-1">*</em></span>
        </div>
      <input type="text" name="DI" class="form-control font-italic" placeholder="droit d'inscription" required>
      <input type="text" name="Reste_DI" class="form-control font-italic" placeholder="reste" required>
      <div class="input-group-append">
        <em class="input-group-text" >AR</em>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="input-group form-group col-12 col-md-11">
      <div class="input-group-prepend">
        <span class="input-group-text text-danger font-italic bg-light" >Commentaire</span>
      </div>
      <textarea name="comment" class="form-control font-italic" placeholder="Tapez votre commentaire ..."></textarea>
      </div>
    </div>

  <!--MODE DE PAIEMENT -->
    <div class="row">
    <!--DEBUT DE PAIEMENT -->
    <div class="input-group form-group col-10  col-md-4 col-lg-3">
        <div class="input-group-prepend">
        <span class="input-group-text text-info font-italic bg-light" >s'inscrire le<em class="text-warning pl-1">*</em></span>
        </div>
      <input name="dateInscr" value="<?php echo date('d/m/Y'); ?>" id="dateInscr" size="16" type="text" class="form-control form_date text-center font-italic" readonly required>
      </div>
    
    </div>

    <div class="d-flex justify-content-center mb-3">
        <button type="submit" class="btn btn-<?php echo $_SESSION['type']; ?> col-4" id="btnValider">VALIDER</button>
    </div>
</form>











