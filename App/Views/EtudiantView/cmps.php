
<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="bg-white sticky-top" style="top:56px;">
  <div class="d-flex flex-wrap">
    <div class="dropdown col-12 col-md-4 col-lg-2 my-2">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddau"><i id="au_ico"></i>Année universitaire</button>
      <div class="dropdown-menu" id="cau">
      <?php foreach ($au as $item) { ?> 
        <button class="dropdown-item" ai=<?php echo $item['idAU']; ?>><?php echo $item['nom_au']; ?></button>
      <?php } ?>
      </div>
    </div>
      
    <div class="dropdown col-12 col-md-3 col-lg-2 my-2">
      <button class="btn btn-dark form-control dropdown-toggle"  id="ddniv" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Niveau
      </button>
      <div id="cnp" class="dropdown-menu">
      </div>
    </div>
    <div class="col-md-2 my-2">
      <button class="btn btn-primary d-none" id="btn_adds">Génerer compte</button>
      <form action="/Etudiant/printCmps" method="post" id="btn_prints" class="d-none">
      <input type="hidden" name="au" id="hau">
      <input type="hidden" name="niv" id="hniv">
      <input type="hidden" name="gp" id="hgp">
      <input type="hidden" name="nom_au" id="hnau">
      <input type="hidden" name="nom_niv" id="hnniv">
      <button type="submit" class="btn btn-warning"  ><svg width="20" height="20"><use xlink:href="/assets/svg/scrud.svg#print"></svg></button>
      </form>
    </div>
    <form id="form_search" class="ml-auto  col-12 col-md-4 col-lg-2 my-2">
      <div class="input-group">
        <input type="text" id="txt_search" class="form-control" placeholder="Rechercher . . .">
        <div class="input-group-append">
          <button type="submit" class="btn btn-<?php echo $_SESSION['type']; ?>"><svg width="16px" height="16px"><use xlink:href="/assets/svg/search.svg#data"></svg></button>
        </div>
      </div>
    </form>

    
  </div>
  <div class="d-flex border-bottom">
    <div id="ceih" class="pl-3">
      <?php if(App\Core\Conf::debug==1){ ?>
        <em class="text-info pl-3"> Efféctifs : 45 (<span class="text-boys"> Homme : 21</span> , <span class="text-girls">Femme : 30</span> )</em>
      <?php } ?>
    </div>
  </div>
</div>
<div class="row no-gutters px-4">
  <?php 
    require 'cmps_form.php'; 
    require 'cmps_list.php'; 
  ?>
</div>





