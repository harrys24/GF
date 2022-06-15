<!-- <div id="feedback"></div> -->
<div id="feedback" class="fixed-top" style="margin-top:60px;"></div>
<div class="container-fluid">
<div class="d-flex justify-content-around py-2">

  <div class="input-group form-group col-12 col-md-6 col-lg-4 pl-4">
    <div class="input-group-prepend">
      <span class="input-group-text" >Année Universitaire<em class="text-success pl-1">*</em></span>
    </div>
    <select id="au" class="form-control">
      <?php foreach ($au as $item) { ?> 
        <option value="<?php echo $item['idAU']; ?>" ><?php echo $item['nom_au']; ?></option>
      <?php } ?>
    </select>
  </div>

  
</div>

  <div class="p-3 bg-white rounded shadow-sm mb-4  mx-2">
  <?php 
   
    foreach($niv as $key=>$value) { ?>
    <div class="row form-group">
        <div class="col-2"><h3><?php echo $key?></h3></div>
        <?php $gp=$$key; ?>
        <div class="col-10 ">
        <div class="row">
        <?php 
        foreach($gp as $item) { ?>
          <div class="col-6 col-lg-2">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" inv="<?php echo $value; ?>" igp="<?php echo $item['idGP']; ?>" id="<?php echo $key.$item['idGP']; ?>">
              <label class="custom-control-label" for="<?php echo $key.$item['idGP']; ?>"><?php echo $item['nom_gp']; ?></label>
            </div>
          </div>
        <?php  } ?>
        </div>
        </div>
    </div>
    <?php  } ?>
  </div>
</div>

<div class="d-flex justify-content-center">
<button id="btnValider" class="btn btn-outline-primary form-control col-2 mb-4">Valider</button>
</div>