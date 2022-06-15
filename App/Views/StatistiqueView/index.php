
<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="bg-white sticky-top" style="top:56px;">
  <div class="d-flex flex-wrap">
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
  
   
   
  </div>
 
</div>

<div id="cchart" class="container mb-4"></div>