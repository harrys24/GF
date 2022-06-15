<div class="d-flex justify-content-center">
	<div class="col-12 col-lg-5 form-group">
			<button id="attrMatsBtnAdd" class="btn btn-dark form-control"><svg class="ebtn"><use xlink:href="/assets/svg/scrud.svg#plus"></svg>Nouvelle attribution</button>
	</div>
</div>
<form id="attrMatsForm" class="form-group" method="post" action="">
	<div class="row">
    <div class="col-md-9 col-lg-3">
      <div class="input-group form-group">
        <div class="input-group-prepend">
          <div class="input-group-text">AU</div>
        </div>
        <select name="au" id="au" class="form-control text-center" required>
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
        <select name="niv" id="niv" class="form-control text-center" required>
        <?php foreach ($niv as $item) { ?> 
          <option value="<?php echo $item['idNIV']; ?>"><?php echo $item['nom_niv']; ?></option>
        <?php } ?>
        </select>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="typeahead__container form-group">
          <div class="typeahead__field">
          <div class="typeahead__query input-group">
              <div class="input-group-prepend">
              <div class="input-group-text">Matière</div>
              </div>
              <input id="txtMat" class="form-control" placeholder="Tapez le nom de la matière" autocomplete="off" required>
              <div class="input-group-append">
              <div class="input-group-text px-3"></div>
              </div>
          </div>
          
          </div>
      </div>
    </div>
	</div>
	<div class="row">
	
			<div class="col-lg-3">
				<div class="form-group">
						<input id="toggle-one" class="form-controle" type="checkbox" checked>
				</div>
			</div>
			
			<div id="cAttrMatsType" class="col-md-6 col-lg-3">
				<div class="input-group form-group">
					<div class="input-group-prepend">
						<div class="input-group-text">Type</div>
					</div>
					<select name="type_mat" id="type_mat" class="form-control text-center" required>
					<?php foreach ($tm as $item) { ?> 
						<option value="<?php echo $item['idTM']; ?>"><?php echo $item['nom_type']; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			
			<div id="cAttrMatsUE" class="col-lg-6">
				<div class="typeahead__container form-group">
					<div class="typeahead__field">
						<div class="typeahead__query input-group">
								<div class="input-group-prepend">
								<div class="input-group-text">UE</div>
								</div>
								<input id="txtUE" class="form-control" placeholder="Tapez le nom de l'UE" autocomplete="off" required>
								<div class="input-group-append">
								<div class="input-group-text px-3"></div>
								</div>
						</div>
					
					</div>
				</div>
			</div>

			<div class="col-md-7 col-lg-3">
			<div class="input-group form-group">
					<div class="input-group-prepend">
					<div class="input-group-text">Nombre d'insertion</div>
					</div>
					<select name="nb" id="nb" class="form-control" required>
					<?php for($i=1;$i<10;$i++){ ?> 
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php } ?>
					</select>
			</div>
			</div>
	</div>

	<div id="ceii"></div>

	<div class="row">
			<div class="col-md-5 col-lg-3">
			<button type="submit" id="attrMatsBtnSave" class="btn btn-primary form-control mt-3"><i id="matIco"></i> Enregistrer</button>
			</div>
	</div>
</form>