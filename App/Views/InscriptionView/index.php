<?php require 'data_show.php'; ?>
<div class="container">
<div id="feedback" class="fixed-top" style="margin-top:60px;"></div>
<form method="POST" action="/Etudiant/checkEtudiant" enctype="multipart/form-data" id="formEtudiant">
  <div id="htitre">
    <h3 class="text-primary bg-white py-3 px-4 border"><?php 
      if(isset($etudiant)){ 
        echo 'DETAILS : <span class="text-secondary">'.$etudiant['prenom'].' '.$etudiant['nom'].'</span>'; 
      }else{
        echo 'FICHE D\'INSCRIPTION'; } ?>
    </h3>
  </div>
  <div id="cphoto">
    <?php if(isset($etudiant)) showPhoto($etudiant['photo']); ?>
  </div>
  <!-- ETUDIANT -->
  <div class="row">
      <span class="h5 text-<?= $_SESSION['type']; ?> my-3 ml-2" data-toggle="tooltip" data-placement="top" title="ETUDIANT">ETUDIANT</span>
  </div>
  <!-- AU -->
  <div class="row">
    <div class="input-group form-group col-12 col-md-4 col-lg-3">
      <div class="input-group-prepend">
        <div id="pr_au" class="input-group-text" >AU<em class="text-danger pl-1">*</em></div>
      </div>
      <input type="hidden" id="au_txt" name="AU">
      <select name="AU_id" id="au" class="form-control" required>
      <?php isset($etudiant)?showUptOPT($etudiant['AU_id'],$au,'idAU','nom_au'):showOPT($au,'idAU','nom_au') ?>
      </select>
    </div>
    <div class="col-12 col-md-2 form-group">
        <input type="checkbox" name="abandon" data-toggle="toggle" data-on="ABANDON" data-off="NON ABD" data-onstyle="danger" data-offstyle="primary" data-width="156" <?php if(isset($etudiant)){ showCHK($etudiant['abandon']); }; ?>>
    </div>
    <!-- PHOTO -->
    <div class="input-group form-group col-12 col-md-10 col-lg-4">
      <div class="custom-file">
          <input type="file" name="photo" class="custom-file-input" id="photo" lang="fr" accept=".jpg,.jpeg,.png">
          <label class="custom-file-label" for="photo" id="photoText">Parcourir</label>
      </div>
    </div>
  </div>
  <div class="row">
    <!-- NIE -->
    <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <div id="pr_nie" class="input-group-text" >NIE<em class="text-danger pl-1">*</em></div>
        </div>
        <?php 
        if(isset($etudiant)){
          $nie=$etudiant['nie'];
          $ns=substr($nie,0,2);
          $na=substr($nie,2,4);
          $nn=substr($nie,-4);
          $mode=count($fs)>0?'u':'a';

          echo'<input type="hidden" id="_nie" name="_nie" value="'.$nie.'"/>';
          echo '<input type="hidden" id="mode" name="mode" value="'.$mode.'"/>';

        }?>
        
        <input type="hidden" id="num_matr" name="num_matr" value="<?= isset($etudiant)?$etudiant['num_matr']:''; ?>">
        <select name="nie_saison" id="nie_saison" class="form-control" required>
          <?php showOPT_NIE($ns); ?>
        </select>
        <input type="text" name='nie_annee' value="<?= isset($etudiant)?$na:''; ?>" id="nie_annee" class="form-control " placeholder="ANNEE" required>
        <input type="text" name='nie_num' value="<?= isset($etudiant)?$nn:''; ?>" id="nie_num" class="form-control" placeholder="NUM." required>
        <div class="input-group-append">
          <button type="button" id="maj_nie" class="btn btn-primary">MAJ</button>
        </div>
    </div>
    <!-- Niveau et GP -->
    <div class="input-group form-group col-12 col-md-6 col-lg-4">
      <div class="input-group-prepend">
        <span id="pr_niv" class="input-group-text" >NIVEAU<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="hidden" id="niv_gp_txt" name="NIV_GP">
      <select name="NIV_id" id="niv" class="form-control " required>
      <?php isset($etudiant)?showUptOPT($etudiant['NIV_id'],$niv,'idNIV','nom_niv'):showOPT($niv,'idNIV','nom_niv') ?>
      </select>
      <select name="GP_id" id="gp" class="form-control" required>
      <?php isset($etudiant)?showUptOPT($etudiant['GP_id'],$gp,'igp','gp'):showOPT($gp,'igp','gp') ?>
      </select>
    </div>
   
      
  </div>
 

    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom<em class="text-danger pl-1">*</em></span>
        </div>
      <input type="text" name="nom" value="<?= isset($etudiant)?$etudiant['nom']:''; ?>" class="form-control" placeholder="votre nom(s)" required>
      </div>

      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)<em class="text-danger pl-1">*</em></span>
        </div>
      <input type="text" name="prenom" value="<?= isset($etudiant)?$etudiant['prenom']:''; ?>" class="form-control" placeholder="votre prénom(s)" required>
      </div>
    </div>
    <!--SEXE et NATIONALITE -->
    <div class="row">
      <div class="input-group col-12 col-md-5 col-lg-4 mt-0 mt-md-1 mt-lg-2">
          <span class="px-2">SEXE : <em class="text-danger pl-1">*</em></span>
        <?php isset($etudiant)?showUptSexe($etudiant['sexe']):showSexe(); ?>
      </div>
      
      <div class="input-group form-group col-10 col-md-5 offset-lg-1 col-lg-3">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nationalité<em class="text-danger pl-1">*</em></span>
        </div>
        <select name="NAT_id" id="nat" class="form-control" required>
        <?php isset($etudiant)?showUptAOPT($etudiant['NAT_id'],$nat,'idNAT','nationalite'):showAOPT($nat,'idNAT','nationalite') ?>
        </select>
      </div>
      <div id="ca_nat" class="ca"></div>
    </div>
    <!--DATE et LIEU DE NAISSANCE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >Date de naissance<em class="text-danger pl-1">*</em></span>
        </div>
        <input id="dateNaiss" name="dateNaiss" value="<?php if(isset($etudiant)){ echo $etudiant['datenaiss'];} ?>" type="date" class="form-control" required>
      </div>

      <div class="input-group form-group col-12 col-md-9  offset-lg-1 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Lieu de naissance<em class="text-danger pl-1">*</em></span>
        </div>
      <input type="text" name="lieuNaiss" class="form-control" placeholder="à" value="<?= isset($etudiant)?$etudiant['lieunaiss']:''; ?>" required>
      </div>
    </div>
    <!-- ADRESSE ,CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-house"></i><em class="text-danger pl-1">*</em></span>
        </div>
      <input class="form-control" type="text" name="adresse" value="<?= isset($etudiant)?$etudiant['adresse']:''; ?>" required>
      </div>
      <div id="cce" class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="bi bi-phone"></i></svg><em class="text-danger pl-1">*</em></span>
        </div>
        <?php isset($etudiant)?showUpdContact($etudiant['contacte'],'',true):showContact('',true); ?>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-send"></i></span>
        </div>
      <input type="email" name="email" value="<?= isset($etudiant)?$etudiant['email']:''; ?>" class="form-control" placeholder="__@mail.com" >
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text text-primary" ><i class="bi bi-facebook"></i></span>
        </div>
      <input type="fb" name="fb" value="<?= isset($etudiant)?$etudiant['fb']:''; ?>" class="form-control" placeholder="https://web.facebook.com/adresse_du_compte" >
      </div>
    </div>

    <!-- BACC -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >BACC<em class="text-danger pl-1">*</em></span>
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
      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Etablissement<em class="text-danger pl-1">*</em></span>
        </div>
      <input type="text" name="EP" class="form-control" value="<?= isset($etudiant)?$etudiant['EP']:''; ?>" required>
      </div>
    </div>

    <div class="row">
      <div class="input-group form-group col-12 col-md-5 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >Dernier diplôme<em class="text-danger pl-1">*</em></span>
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
      <input type="text" name="do_en" class="form-control" value="<?= isset($etudiant)?$etudiant['do_en']:''; ?>" >
      </div>
    </div>

    <!-- PERE -->
    <div class="row">
        <span class="h5 text-<?= $_SESSION['type']; ?> my-3 ml-2">PÈRE</span>
    </div>
    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom</span>
        </div>
      <input type="text" name="nom_p" value="<?= isset($etudiant)?$etudiant['nom_p']:''; ?>" class="form-control" placeholder="nom du père" >
      </div>

      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
        <input type="text" name="prenom_p" value="<?= isset($etudiant)?$etudiant['prenom_p']:''; ?>" class="form-control" placeholder="prénom du père" >
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
      <input type="text" name="profession_p" value="<?= isset($etudiant)?$etudiant['profession_p']:''; ?>" class="form-control" placeholder="profession du père" >
      </div>

      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-house"></i></span>
        </div>
      <input type="text" name="adresse_p" value="<?= isset($etudiant)?$etudiant['adresse_p']:''; ?>" class="form-control" placeholder="adresse du père" >
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-phone"></i></svg></span>
        </div>
        <?php isset($etudiant)?showUpdContact($etudiant['contacte_p'],'_p'):showContact('_p'); ?>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-send"></i></span>
        </div>
      <input type="email" name="email_p" value="<?= isset($etudiant)?$etudiant['email_p']:''; ?>" class="form-control" placeholder="__@mail.com" >
      </div>
    </div>


    <!-- MÈRE -->
    <div class="row">
        <span class="h5 text-<?= $_SESSION['type']; ?> my-3 ml-2">MÈRE</span>
    </div>
    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom</span>
        </div>
      <input type="text" name="nom_m" value="<?= isset($etudiant)?$etudiant['nom_m']:''; ?>" class="form-control" placeholder="nom de la mère" >
      </div>

      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
      <input type="text" name="prenom_m" value="<?= isset($etudiant)?$etudiant['prenom_m']:''; ?>" class="form-control" placeholder="prénom de la mère" >
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
      <input type="text" name="profession_m" value="<?= isset($etudiant)?$etudiant['profession_m']:''; ?>" class="form-control" placeholder="profession de la mère" >
      </div>

      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-house"></i></span>
        </div>
      <input type="text" name="adresse_m" value="<?= isset($etudiant)?$etudiant['adresse_m']:''; ?>" class="form-control" placeholder="adresse de la mère" >
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-phone"></i></svg></span>
        </div>
        <?php isset($etudiant)?showUpdContact($etudiant['contacte_m'],'_m'):showContact('_m'); ?>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-send"></i></span>
        </div>
      <input type="email" name="email_m" value="<?= isset($etudiant)?$etudiant['email_m']:''; ?>" class="form-control" placeholder="__@mail.com" >
      </div>
    </div>


    <!-- tuteur -->
    <div class="row">
        <span class="h5 text-<?= $_SESSION['type']; ?> my-3 ml-2">TUTEUR</span>
    </div>
    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom</span>
        </div>
      <input type="text" name="nom_t" value="<?= isset($etudiant)?$etudiant['nom_t']:''; ?>" class="form-control" placeholder="nom du tuteur" >
      </div>

      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
      <input type="text" name="prenom_t" value="<?= isset($etudiant)?$etudiant['prenom_t']:''; ?>" class="form-control" placeholder="prénom du tuteur" >
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
      <input type="text" name="profession_t" value="<?= isset($etudiant)?$etudiant['profession_t']:''; ?>" class="form-control" placeholder="profession du tuteur" >
      </div>

      <div class="input-group form-group col-12 col-md-6 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-house"></i></span>
        </div>
      <input type="text" name="adresse_t" value="<?= isset($etudiant)?$etudiant['adresse_t']:''; ?>" class="form-control" placeholder="adresse du tuteur" >
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-phone"></i></svg></span>
        </div>
        <?php isset($etudiant)?showUpdContact($etudiant['contacte_t'],'_t'):showContact('_t'); ?>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><i class="bi bi-send"></i></span>
        </div>
      <input type="email" name="email_t" value="<?= isset($etudiant)?$etudiant['email_t']:''; ?>" class="form-control" placeholder="__@mail.com" >
      </div>
    </div>

    <!-- DOSSIER-->
    <div class="row">
        <span class="h5 text-<?= $_SESSION['type']; ?> my-3 ml-2">DOSSIER ET DI</span>
    </div>
    
    <div class="ml-3 mb-3">
      <input type="hidden" id="list_dossier" name="list_dossier"/>
      <div id="ckdossier" class="row">
      <?php showDossier($dossier,$etudiant); ?>
      </div>
    </div>

    <!--ENTRETIEN -->
    <div class="form-row">
      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text bg-white text-<?= $_SESSION['type']; ?>" >ENTRETIEN DU<em class="text-danger pl-1">*</em></span>
        </div>
        <input name="dateRec" value="<?php if(isset($etudiant)){ echo $etudiant['dateRec'];} ?>" size="16" type="date" class="form-control text-center" required>
        <div class="input-group-prepend">
          <span class="input-group-text bg-white text-<?= $_SESSION['type']; ?>" >AVEC</span>
        </div>
        <select name="REC_id" id="recruteur" class="form-control" required>
        <?php isset($etudiant)?showUptOPT($etudiant['REC_id'],$rec,'idREC','poste_rec'):showOPT($rec,'idREC','poste_rec') ?>
        </select>
      </div>
    </div>

    <!--MODE DE PAIEMENT -->
    <?php
    if (isset($etudiant)) { $display=''; ?>
      <div id="cmp" class="row">
        <?php if (empty($etudiant['TrancheFS_id'])) { $display='d-none'; ?>
        <div class="col-12">
          <span id="btn-new-tranche" class="bg-warning text-light rounded form-control"><i class="bi bi-info-circle mr-2"></i>A éditer au Service Financier</span>
        </div>
        <?php }else{ ?>
        <div class="input-group form-group col-12 col-md-6 col-lg-4">
          <div class="input-group-prepend">
            <span class="input-group-text" >Tranche</span>
          </div>
          <input type="hidden" id="nbTranche" name="nbTranche">
          <select name="TrancheFS_id" id="tranchefs" class="form-control"> 
          <?php showUptOPT($etudiant['TrancheFS_id'],$tranchefs,'idT','nbT') ?>
          </select>
          <div class="input-group-append">
            <span class="input-group-text" >FOIS</span>
          </div>
        </div>
        <?php } ?>
      </div>
      <?php } else { ?>
        <div id="cmp" class="row">
          <div class="input-group form-group col-12 col-md-6 col-lg-4">
            <div class="input-group-prepend">
              <span class="input-group-text" >Tranche</span>
            </div>
            <input type="hidden" id="nbTranche" name="nbTranche">
            <select name="TrancheFS_id" id="tranchefs" class="form-control"> 
            <?php showOPT($tranchefs,'idT','nbT') ?>
            </select>
            <div class="input-group-append">
              <span id="btn-tranche-reset" class="input-group-text" ><i class="bi bi-arrow-repeat"></i></span>
            </div>
          </div>
        </div>
    <?php } ?>

    <!-- DETAIL DE PAIEMENT-->
    <div class="row">
      <span class="h5 text-<?= $_SESSION['type']; ?> my-3 ml-2">DETAIL DE PAIEMENT</span>
    </div>
    <div id="ctranche" class="row">
      <?php if(isset($fs)){ showDetail_Tranche($fs); } ?>
    </div>
    <!-- DI -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >DI</span>
        </div>
      <input type="text" name="DI" value="<?= isset($etudiant)?$etudiant['DI']:''; ?>" class="form-control font-italic" placeholder="droit d'inscription">
      <input type="text" name="Reste_DI" value="<?= isset($etudiant)?$etudiant['Reste_DI']:''; ?>" class="form-control font-italic" placeholder="reste">
      <div class="input-group-append">
        <em class="input-group-text" >AR</em>
      </div>
    </div>
  </div>

    <div class="row">
      <div class="input-group form-group col-12">
        <div class="input-group-prepend">
          <i class="input-group-text text-danger bg-light" >Commentaire</i>
        </div>
        <textarea name="comment" class="form-control font-italic" placeholder="Tapez votre commentaire ..."><?= isset($etudiant)?$etudiant['comment']:''; ?></textarea>
      </div>
    </div>

  <!--MODE DE PAIEMENT -->
    <div class="row">
      <!--DEBUT DE PAIEMENT -->
      <div class="input-group form-group col-10  col-md-5 col-lg-4">
          <div class="input-group-prepend">
          <span class="input-group-text text-info font-italic bg-light" >s'inscrire le<em class="text-danger pl-1">*</em></span>
          </div>
        <input name="dateInscr" value="<?= isset($etudiant)?$etudiant['dateInscr']:date('Y-m-d'); ?>" id="dateInscr" type="date" class="form-control" required>
        </div>
      
      </div>

      <div class="d-flex justify-content-center mb-3">
        <?php if (isset($etudiant)) { ?>
          <button type="submit" id="btnValider" class="btn btn-danger px-4"><i class="bi bi-arrow-repeat mr-2"></i>Mettre à jour</button>
          <?php } else { ?>
            <button type="submit" id="btnValider" class="btn btn-success px-4"><i class="bi bi-save mr-2"></i>Sauvegarder</button>
        <?php } ?>
    </div>
</form>
</div>











