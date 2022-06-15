<?php require 'data_show.php'; ?>
<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="d-flex flex-md-row flex-column justify-content-start">
 
  <div class="dropdown col-12 col-md-4 col-lg-2 my-2">
    <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddau">Année universitaire</button>
    <div class="dropdown-menu" id="cau">
    <?php foreach ($au as $item) { ?> 
      <button class="dropdown-item" ai=<?php echo $item['idAU']; ?>><i id="au_ico"></i><?php echo $item['nom_au']; ?></button>
    <?php } ?>
    </div>
  </div>
    
  <div class="dropdown col-12 col-md-5 col-lg-2 my-2">
    <button class="btn btn-dark form-control dropdown-toggle"  id="ddniv" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Niveau
    </button>
    <div id="cnp" class="dropdown-menu">
    </div>
  </div>

  <form id="form_search" class="ml-auto  col-12 col-lg-2 my-2">
    <div class="input-group">
      <input type="text" id="txt_search" class="form-control" placeholder="Rechercher . . .">
      <div class="input-group-append">
        <button type="submit" class="btn btn-<?php echo $_SESSION['type']; ?>"><i class="fal fa-search"></i></button>
      </div>
    </div>
  </form>

</div>
<div class="container-fluid">
  <div class="row mt-3">
    <div class="form-group col-12 col-md-3">
      <input type="text" name="nom_pr" id="nom_pr" class="form-control" placeholder="nom">
    </div>
    <div class="form-group col-12 col-md-4">
      <input type="text" name="prenom_pr" id="prenom_pr" class="form-control" placeholder="prénoms">
    </div>
  </div>
  <div class="row">
    <div class="input-group col-12 col-md-5 col-lg-3 mt-0 mt-md-1 mt-lg-2">
      <label class="mr-3">SEXE<em class="text-warning pl-1">*</em></label>
      <?php isset($etudiant)?showUptSexe($etudiant['sexe']):showSexe(); ?>
    </div>
    <div class="form-group col-12 col-md-4">
      <input type="text" name="contacte" id="contacte" class="form-control" placeholder="contact">
    </div>
  </div>

  <div class="row">
   
    <div class="form-group col-12 col-md-5">
      <input type="text" name="email_pr" id="email_pr" class="form-control" placeholder="email">
    </div>
    
    <div class="dropdown col-12 col-md-4 col-lg-2 form-group">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddgr">Grade</button>
      <div class="dropdown-menu" id="cgr">
      <?php foreach ($grade as $item) { ?> 
        <button class="dropdown-item" gri=<?php echo $item['idGR']; ?>><?php echo $item['nom_gr']; ?></button>
      <?php } ?>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="form-group col-12 col-md-4">
      <button class="btn btn-primary form-control">Ajouter enseignant</button>
    </div>
  </div>

  <!-- //matière -->
  <div class="row mt-3">
    <div class="form-group col-12 col-md-3">
      <input type="text" name="nom_mat" id="nom_mat" class="form-control" placeholder="nom matière">
    </div>
    <div class="dropdown col-12 col-md-4 col-lg-2 form-group">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddtm">Type</button>
      <div class="dropdown-menu" id="ctm">
      <?php foreach ($type as $item) { ?> 
        <button class="dropdown-item" tmi=<?php echo $item['idTM']; ?>><?php echo $item['nom_type']; ?></button>
      <?php } ?>
      </div>
    </div>
    
    <div class="form-group col-12 col-md-4 col-lg-1">
      <input type="text" name="prenom_pr" id="prenom_pr" class="form-control" placeholder="crédits">
    </div>
    
  </div>

</div>