
<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="container-fluid pt-md-5 pt-lg-0">
  <form id="form-export" action="/export/etudiant" method="post" class="row">
    <input type="hidden" id="anp" name="anp">
    <input type="hidden" id="a" name="a">
    <input type="hidden" id="n" name="n">
    <input type="hidden" id="p" name="p">
    <input type="hidden" id="abd" name="abd" value="false">
    <div class="dropdown col-12 col-md-4 col-lg-2 my-2">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddau">Année universitaire</button>
      <div class="dropdown-menu" id="cau">
      <?php foreach ($au as $item) { ?> 
        <button type="button" class="dropdown-item" ai=<?php echo $item['idAU']; ?>><i id="au_ico"></i><?php echo $item['nom_au']; ?></button>
      <?php } ?>
      </div>
    </div>
      
    <div class="dropdown col-12 col-md-5 col-lg-2 my-2">
      <button type="button" class="btn btn-dark form-control dropdown-toggle"  id="ddniv" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Niveau
      </button>
      <div id="cnp" class="dropdown-menu">
      </div>
    </div>

    <div  class="col-5 col-md-2 col-lg-1 my-2">
      <input type="checkbox" id="abandon">
    </div>

    <div  class="col-6 col-md-5 col-lg-4 my-2">
      <select name="fm[]" multiple="multiple" id="fm" class="form-control">
        <option value="dn">Date de naissance</option>
        <option value="ln">Lieu de naissance</option>
        <option value="ce">Contacts étudiants</option>
        <option value="cp">Contacts parents</option>
        <option value="npp">Père</option>
        <option value="npm">Mère</option>
        <option value="npt">Tuteur</option>
      </select>
    </div>

    <div  class="col-12 col-md-2 col-lg-2 my-2">
      <button type="submit" id="btn-export" class="btn btn-danger w-100">Exporter</button>
    </div>
  </form>

  <?php if ($_SESSION['type']=='devmaster') { ?>
  <a href="/export/all" class="btn btn-outline-primary">Exporter tous</a>
  <?php } ?>

</div>

