<div class="container-fluid">
  <div class="d-flex flex-column flex-lg-row justify-content-between pt-3">
    
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

  
    <form method="post" action="" id="form_search" class="input-group form-group col col-md-5 col-lg-2">
      <input type="text" class="form-control" placeholder="Rechercher . . .">
      <div class="input-group-append">
        <button type="submit" class="btn btn-<?php echo $_SESSION['type']; ?>"><i class="fal fa-search"></i></button>
      </div>
    </form>

  </div>
  <div class="row">
    <div class="table-responsive col-12">
      <table class="table table-striped table-bordered">
      <caption>Liste des étudiants</caption>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">NIE</th>
          <th scope="col">Nom</th>
          <th scope="col">Prénom(s)</th>
          <th scope="col">Sexe</th>
          <th scope="col">PR</th>
          <th scope="col">ABS</th>
          <th scope="col">RT</th>
        </tr>
      </thead>
      <tbody id="cei">
        <?php if(App\Core\Conf::debug==1){ ?>
        <tr>
          <th scope="row">1</th>
          <td>SE20190001</td>
          <td class="font-weight-bold">RAKOTONJANAHARY RAKOTONJANAHARY</td>
          <td>Alphonse Faniriarimalala</td>
          <td>M</td>
          <th class="pr"><input name="rd1" type="radio"/></th>
          <th class="abs"><input name="rd1" type="radio"/></th>
          <th class="rt"><input name="rd1" type="radio"/></th>
        </tr>
        
        <tr>
          <th scope="row">1</th>
          <td>SE20190001</td>
          <td class="font-weight-bold">RAKOTONJANAHARY RAKOTONJANAHARY</td>
          <td>Alphonse Faniriarimalala</td>
          <td>M</td>
          <th class="pr"><input name="rd2" type="radio"/></th>
          <th class="abs"><input name="rd2" type="radio"/></th>
          <th class="rt"><input name="rd2" type="radio"/></th>
        </tr>
        <?php } ?>
        
      </tbody>
      </table>
      <div class="d-flex justify-content-center mb-3">
        <button type="submit" class="btn btn-primary col-3" id="btnValider"><i class="fa fa-check mr-2"></i>VALIDER</button>
      </div>
    </div>
  </div>
</div>