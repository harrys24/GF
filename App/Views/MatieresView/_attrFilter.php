<div class="row">
  <div class="col-md-9 col-lg-3">
    <div class="input-group form-group">
      <div class="input-group-prepend">
        <div class="input-group-text">AU</div>
      </div>
      <select name="attr_au" id="attr_au" class="form-control text-center" required>
      <?php foreach ($au as $item) { ?> 
      <option value="<?php echo $item['idAU']; ?>"><?php echo $item['nom_au']; ?></option>
      <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="input-group form-group">
      <div class="input-group-prepend">
        <div class="input-group-text">Niveau</div>
      </div>
      <select name="attr_niv" id="attr_niv" class="select_niv form-control text-center" required>
      <?php foreach ($niv as $item) { ?> 
      <option value="<?php echo $item['idNIV']; ?>"><?php echo $item['nom_niv']; ?></option>
      <?php } ?>
      </select>
    </div>
  </div>

  <div class="col-md-6 col-lg-3">
    <div class="input-group form-group">
      <div class="input-group-prepend">
        <div class="input-group-text">GP</div>
      </div>
      <select name="attr_gp" id="attr_gp" class="form-control text-center" required></select>
    </div>
  </div>

  <div class="col-md-6 col-lg-3">
    <div class="input-group form-group">
      <div class="input-group-prepend">
        <div class="input-group-text">Semestre</div>
      </div>
      <select name="attr_sem" id="attr_sem" class="form-control text-center" required></select>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <button id="attr_btn_filter"class="btn btn-primary w-100 form-group">Filter</button>
  </div>
</div>
<h6 class="text-uppercase font-weight-bold mt-2">Les matières avec UE et Crédits</h6>
<div class="table-responsive">
  <table class="table table-sm table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Unités d'enseignements</th>
      <th scope="col">Matières</th>
      <th scope="col">Types</th>
      <th scope="col">Crédit</th>
      <th scope="col">Professeurs</th>
      <th scope="col">Opérations</th>
    </tr>
  </thead>
  <tbody id="attrMatsCei" class="cAttrMatrTB">
  </tbody>
  </table>
</div>
<h6 class="text-uppercase font-weight-bold mt-2">Les autres matières</h6>
<div class="table-responsive">
  <table class="table table-sm table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Matières</th>
      <th scope="col">Professeurs</th>
      <th scope="col">Opérations</th>
    </tr>
  </thead>
  <tbody id="attrAutMatsCei" class="cAttrMatrTB">
  </tbody>
  </table>
</div>