<?php require 'data_show.php'; ?>
<div class="container">
<div id="feedback" class="fixed-top" style="margin-top:60px;"></div>
<form method="POST" action="#">
  <div id="htitre">
    <h3 class="text-muted bg-white py-3 px-4 border">
    DETAILS : <span class="text-primary"><?php echo $prenom.' '.$nom; ?></span>
    </h3>
  </div>
  <div id="cphoto">
    <?php showPhoto($photo); ?>
  </div>
    <!-- ETUDIANT -->
    <div class="row">
      <span class="h5 text-<?php echo $_SESSION['type']; ?> my-3 ml-2" data-toggle="tooltip" data-placement="top" title="ETUDIANT">ETUDIANT</span>
    </div>
    <!-- AU -->
    <div class="row">
      <div class="input-group form-group col-10 col-md-6 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >Année Universitaire</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $nom_au; ?>" readonly>
      </div>
      <div class="col-8 col-md-4 offset-lg-1 col-lg-4 form-group">
        <input type="checkbox" name="abandon" data-toggle="toggle" data-on="ABANDON" data-off="NON ABD" data-onstyle="danger" data-offstyle="primary" data-width="156" <?php if(isset($etudiant)){ showCHK($etudiant['abandon']); }; ?>>
      </div>
    </div>
    <!-- NIE ET NIVEAU-->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >NIE</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $nie; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-6 offset-lg-1 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >NIVEAU</span>
        </div>
        <input class="form-control" type="text" value="<?= $nom_niv.' '.$nom_gp; ?>" readonly>
      </div>
    </div>

    <!-- NOM ET PRENOMS -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nom</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $nom; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $prenom; ?>" readonly>
      </div>
    </div>
    <!--SEXE et NATIONALITE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-5 col-lg-3 mt-md-2">
        <?php showSexe($sexe); ?>
      </div>
      
      <div class="input-group form-group col-10 col-md-5 offset-lg-2 col-lg-3">
        <div class="input-group-prepend">
          <span class="input-group-text" >Nationalité</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $nationalite; ?>" readonly>
      </div>
    </div>
    <!--DATE et LIEU DE NAISSANCE -->
    <div class="row">
      <div class="input-group form-group col-12  col-md-4 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >Date de naissance</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $this->getDate($datenaiss); ?>" readonly>
        <div class="input-group-append">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#calendar"></svg></span>
        </div>
      </div>

      <div class="input-group form-group col-12 col-md-8 offset-lg-1 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Lieu de naissance</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $lieunaiss ?>" readonly>
      </div>
    </div>
    <!-- ADRESSE ,CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-10 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#home"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $adresse; ?>" readonly>
      </div>
      <div id="cce" class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text"><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo str_replace(',','    ',$contacte); ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $email; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text text-primary" ><svg><use xlink:href="/assets/svg/inscr.svg#fb"></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $fb ?>" readonly>
      </div>
    </div>

    <!-- BACC -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >BACC</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $annee.' '.$mention.' '.$serie; ?>" readonly>
      </div>
      <!-- ETABLISSEMENT PRECEDENT -->
      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Etablissement</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $EP; ?>" readonly>
      </div>
    </div>

    <div class="row">
      <div class="input-group form-group col-12 col-md-5 col-lg-4">
        <div class="input-group-prepend">
          <span class="input-group-text" >Dernier diplôme</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $diplome; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-7 offset-lg-1 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >en</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $do_en; ?>" readonly>
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
        <input class="form-control" type="text" value="<?php echo $nom_p; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $prenom_p; ?>" readonly>
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $profession_p; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#home"></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $adresse_p; ?>" readonly>
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo str_replace(',','    ',$contacte_p); ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $email_p; ?>" readonly>
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
        <input class="form-control" type="text" value="<?php echo $nom_m; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $prenom_m; ?>" readonly>
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $profession_m; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#home"></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $adresse_m; ?>" readonly>
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo str_replace(',','    ',$contacte_m); ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $email_m; ?>" readonly>
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
        <input class="form-control" type="text" value="<?php echo $nom_t; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" >Prénom(s)</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $prenom_t; ?>" readonly>
      </div>
    </div>
    <!-- PROFESSION ET ADRESSE -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >Profession</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $profession_t; ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#home"></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $adresse_t; ?>" readonly>
      </div>
    </div>
    <!-- CONTACTES ET EMAIL -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-9 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo str_replace(',','    ',$contacte_t); ?>" readonly>
      </div>

      <div class="input-group form-group col-12 col-md-9 col-lg-6">
        <div class="input-group-prepend">
          <span class="input-group-text" ><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
        </div>
        <input class="form-control" type="text" value="<?php echo $email_t; ?>" readonly>
      </div>
    </div>

    <!-- DOSSIER-->
    <div class="row">
        <span class="h5 text-<?php echo $_SESSION['type']; ?> my-3 ml-2">DOSSIER ET DI</span>
    </div>
    <div class="ml-3 mb-3">
      <input type="hidden" id="list_dossier" name="list_dossier"/>
      <div id="ckdossier" class="row">
      <?php showDossier($dossier,$list_dossier); ?>
      </div>
    </div>

    <!--ENTRETIEN -->
    <div class="form-row">
      <div class="input-group form-group col-12  col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text bg-white text-<?php echo $_SESSION['type']; ?>" >ENTRETIEN</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $this->getDate($dateRec); ?>" readonly>
        <div class="input-group-prepend">
          <span class="input-group-text bg-white text-<?php echo $_SESSION['type']; ?>" >AVEC</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $poste_rec; ?>" readonly>
      </div>
    </div>

    <!--MODE DE PAYEMENT -->
    <div id="cmp" class="row">
      <div class="input-group form-group col-8 col-md-6 col-lg-3">
        <div class="input-group-prepend">
          <span class="input-group-text" >Tranche</span>
        </div>
        <input class="form-control text-center" type="text" value="<?php echo $nbT; ?>" readonly>
        <div class="input-group-append">
          <span class="input-group-text" >FOIS</span>
        </div>
      </div>
      <!--DEBUT DE PAYEMENT -->
      <?php 
      if (isset($fs) && count($fs)>0) {  ?>
      <div class="input-group form-group col-10  col-md-4 col-lg-3">
        <div class="input-group-prepend">
          <span class="input-group-text" >A partir du</span>
        </div>
        <input name="sd" value="<?php echo $fs[0]['date_prevu']; ?>" id="sd" size="16" type="text" class="form-control form_date text-center font-italic" readonly required>
      </div>
      <?php  }  ?>
        
    </div>

    <!--LISTES DPAYEMENT -->
    <div class="form-row" id="listPContainer">
    <?php if(isset($fs)){ showDate_prevu($fs); } ?>
    </div>
    <!-- DI -->
    <div class="row">
      <div class="input-group form-group col-12 col-md-6 col-lg-5">
        <div class="input-group-prepend">
          <span class="input-group-text" >DI</span>
        </div>
        <input class="form-control" type="text" value="<?php echo $DI; ?>" readonly>
          <span class="form-control input-group-text" >Reste</span>
        <input class="form-control" type="text" value="<?php echo $Reste_DI; ?>" readonly>
        <div class="input-group-append">
          <em class="input-group-text" >AR</em>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="input-group form-group col-12 col-md-10 col-lg-11">
      <div class="input-group-prepend">
        <span class="input-group-text text-danger font-italic bg-light" >Commentaire</span>
      </div>
      <textarea class="form-control font-italic" placeholder="Tapez votre commentaire ..." readonly><?php echo $comment; ?></textarea>
      </div>
    </div>

  <!--MODE DE PAYEMENT -->
    <div class="row">
    <!--DEBUT DE PAYEMENT -->
    <div class="input-group form-group col-10  col-md-4 col-lg-3">
        <div class="input-group-prepend">
        <span class="input-group-text text-info font-italic bg-light" >s'inscrire le</span>
        </div>
      <input name="dateInscr" value="<?php echo isset($etudiant)?$etudiant['dateInscr']:date('d/m/Y'); ?>" id="dateInscr" size="16" type="text" class="form-control form_date text-center font-italic" readonly required>
      </div>
    
    </div>

</form>











