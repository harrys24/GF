
<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="bg-white sticky-top" style="top:56px;">
  <div class="d-flex flex-wrap">
    <?php if ($_SESSION['type']!='job_etudiant' && $_SESSION['type']!='guest') { ?>
    <div id="drd" class="dropdown col-12 col-md-2 col-lg-1 my-2">
      <button class="btn btn-primary dropdown-toggle"  id="ddaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
      </button>
      <div class="dropdown-menu" aria-labelledby="ddaction">
        <button id="btnSelectAll" class="dropdown-item">Sélectionner tout</button>
        <button id="btnUnselectAll" class="dropdown-item">Desélectionner tout</button>
        <div class="dropdown-divider"></div>
        <div class="dropdown-submenus">
          <button id="hmigrate" class="dropdown-item dropdown-toggle" >Migrer vers</button>
          <div id="cmigrate" class="dropdown-menu">
          <?php if(App\Core\Conf::debug==1){ ?>
            <div class="dropdown-submenus">
            <button class="dropdown-item dropdown-toggle">sub Menu</button>
              <div class="dropdown-menu">
                <button class="dropdown-item">Subsubmenu action</button>
                <button class="dropdown-item">Another subsubmenu action</button>
              </div>
            </div>
  
            <div class="dropdown-submenus">
            <button class="dropdown-item dropdown-toggle">sub Menu</button>
              <div class="dropdown-menu">
                <button class="dropdown-item">Subsubmenu action</button>
                <button class="dropdown-item">Another subsubmenu action</button>
              </div>
            </div>
            
          <?php }?>
  
  
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="dropdown col-12 col-md-4 col-lg-2 my-2">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddau">Année universitaire</button>
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
  
    <div  class="col-12 col-md-2 col-lg-2 my-2">
      <input type="checkbox" id="abandon" >
    </div>
    
    <form id="form_search" class="ml-auto  col-12 col-md-4 col-lg-3 my-2">
      <div class="input-group">
        <input type="text" id="txt_search" class="form-control" placeholder="Rechercher . . .">
        <select name="filter_search" id="filter_search" class="form-control" >
          <option value="e">ETUDIANT</option>
          <option value="p">PÈRE</option>
          <option value="m">MÈRE</option>
          <option value="t">TUTEUR</option>
        </select>
        <div class="input-group-append">
          <button type="submit" id="btn_search" class="btn btn-<?php echo $_SESSION['type']; ?>"><svg width="16px" height="16px"><use xlink:href="/assets/svg/search.svg#data"></svg></button>
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
<div class="row no-gutters" id="cei">
  <?php if(App\Core\Conf::debug==1){ require 'ei.php'; } ?>
</div>



