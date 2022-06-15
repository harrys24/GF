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
          <th scope="col">Matière(s)</th>
          <th scope="col">Salle(s) et Horaire(s)</th>
          <th scope="col" id="th-action" class="text-danger text-center">Actions ?</th>
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
          <td>HTML</td>
          <td>A003</td>
          <th class="pr text-center"><input type="checkbox" name="ck" /></th>
        </tr>
      <?php } ?>

      </tbody>
      </table>
      <div class="custom-control custom-checkbox mr-sm-2">
        <input type="checkbox" class="custom-control-input" id="ckc">
        <label class="custom-control-label" for="ckc"><em class="text-primary">"Lu et approuvé."</em></label>
      </div>
      <div class="d-flex justify-content-center mb-3">
        <button class="btn btn-primary col-3" id="btnValider"></i>VALIDER</button>
      </div>
    </div>
  </div>