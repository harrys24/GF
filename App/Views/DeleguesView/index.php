<div id="feedback" class="fixed-top m-2"></div>
<div class="container-fluid">
  <div class="d-flex justify-content-around pt-2 pb-4">

    <div class="input-group py-2 col-10 col-md-6 col-lg-4 pl-4">
      <div class="input-group-prepend">
        <span class="input-group-text" >Année Universitaire<em class="text-success pl-1">*</em></span>
      </div>
      <select id="au" class="form-control">
        <?php foreach ($au as $item) { ?> 
          <option value="<?php echo $item['idAU']; ?>" ><?php echo $item['nom_au']; ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="input-group py-2 col-10 col-md-6 col-lg-4 pl-4">
      <div class="input-group-prepend">
        <span class="input-group-text" >NIVEAU<em class="text-success pl-1">*</em></span>
      </div>
      <select id="gp" class="form-control">
       
      </select>
    </div>
  </div>
  <div class="row  bg-white rounded mb-4 shadow-sm p-3 mx-2">
      
    <?php 
        include 'form.php'; 
        include 'list.php'; 
    ?>
  </div>
</div>