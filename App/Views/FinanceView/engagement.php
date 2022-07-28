<div class="container pt-1">
  <h3 class="text-center text-light bg-primary py-2 mb-4 rounded shadow-sm">FICHE D'ENGAGEMENT</h3>
  <div class="row">
    <div class="input-group form-group col-12 col-md-4 col-lg-3">
      <div class="input-group-prepend">
        <div id="pr_au" class="input-group-text" >AU<em class="text-danger pl-1">*</em></div>
      </div>
      <select name="au" id="au" class="form-control" required>
      <?php foreach ($au as  $item) { ?>
        <option value="<?= $item['idAU'] ?>"><?= $item['nom_au'] ?></option>
      <?php } ?>
      </select>
    </div>

    <div class="input-group form-group col-12 col-md-8 col-lg-5">
      <div class="input-group-prepend">
        <div id="pr_niv" class="input-group-text" >NIVEAU<em class="text-danger pl-1">*</em></div>
      </div>
      <select name="niv" id="niv" class="form-control" required>
      <?php foreach ($niv as  $item) { ?>
        <option value="<?= $item['idNIV'] ?>"><?= $item['nom_niv'] ?></option>
      <?php } ?>
      </select>
      <select name="gp" id="gp" class="form-control" required>
     
      </select>
    </div>

    <div class="input-group form-group col-12 col-md-4 col-lg-3">
      <div class="input-group-prepend">
        <div id="pr_nie" class="input-group-text" >NIE<em class="text-danger pl-1">*</em></div>
      </div>
      <input type="text" name="nie" id="nie" class="form-control">
    </div>
    <div class="form-group col-12 col-md-4 col-lg-3">
      <button id="btn-search" class="btn btn-primary"><span id="btn-search-icon"><i class="bi bi-search mr-2"></i></span>Rechercher</button>
    </div>
  </div>

  <div id="cres" class="shadow p-2 rounded mb-4">
    <div id="cres-header" class="d-flex flex-column flex-lg-row justify-content-between bg-success text-light px-4 pt-2 border-bottom rounded">
      <h4 class="">DÉTAIL SUR <span id="res_nie">SE2022----</span></h4>
      <h4>
        <span id="res_tranche" class="bg-light text-dark rounded px-2 mr-2">EN X FOIS</span>
        <span id="num" class="bg-light text-dark rounded px-2">#2563</span> 
      </h4>
    </div>
    <div class="px-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between pt-2">
      <h6 id="nom" class="mt-2 font-weight-bold">RAKOTOARIZAFY <span class="text-muted">Landry</span></h6>
      <h6 id="detail" class="mt-2">Né(e) le <span id="datenaiss" class="text-muted">12/02/1996</span> à 
        <span id="lieunaiss" class="text-muted">BEFELATANANA</span> - (<span id="sexe" class="text-muted">Femme</span>)
      </h6>
    </div>
    <div class="d-flex flex-column flex-lg-row justify-content-between">
      <h6 class="mt-1 mb-1 font-weight-bold">Niveau :  <span id="res_niv" class="text-muted">L3 BANCASS</span></h6>
      <h6 class="mt-1 mb-1 font-weight-bold">Frais de scolarité :  <span id="res_tarif" class="text-muted">1 500 000</span> AR</h6>
     
    </div>
      <hr>
      <h5 id="detail-titre" class="text-success">Détail de paiement par tranche</h5>
      <div id="ctranche" class="row"></div>
      <div class="d-flex flex-column flex-lg-row justify-content-between pt-3">
        <div class="">
          <div class="input-group form-group ">
            <div class="input-group-prepend">
              <div id="pr_tranche" class="input-group-text " >Tranche<em class="text-danger pl-1">*</em></div>
            </div>
            <select name="tranche" id="tranche" class="form-control" required>
            <?php foreach ($tranchefs as  $item) { ?>
              <option value="<?= $item['idT'] ?>"><?= $item['nbT'] ?> FOIS</option>
            <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <button id="btn-update" class="btn btn-success"><span id="btn-update-icon"><i  class="bi bi-arrow-repeat mr-2"></i></span>Mettre à jour</button>
        </div>
      </div>
    </div>

    
  </div>
</div>