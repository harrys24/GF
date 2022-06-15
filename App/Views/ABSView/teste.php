<div class="container-fluid">
<div class="row my-4">
<div class="input-group form-group col-12 col-md-5 col-lg">
      <div class="input-group-prepend">
        <span class="input-group-text" >Salle(s)<em class="text-warning pl-1">*</em></span>
      </div>
      <select id="salle" class="form-control" required>
        <?php foreach ($salles as $item) { ?> 
          <option value="<?php echo $item['numSALLE']; ?>"><?php echo $item['numSALLE']; ?></option>
        <?php } ?>
      </select>
    </div>
    
    <div class="input-group form-group col-12 col-md-5 col-lg">
      <div class="input-group-prepend">
        <span class="input-group-text" >Date<em class="text-warning pl-1">*</em></span>
      </div>
      <input type="text" id="dn"  class="form-control form_date text-center font-italic" readonly required>
    </div>

    <div class="input-group form-group col-12 col-md-7 col-lg">
      <div class="input-group-prepend">
        <span class="input-group-text" >Heure(s)<em class="text-warning pl-1">*</em></span>
      </div>
      
      <input type="text"  id="st" class="form-control form_time text-center font-italic" readonly required>
      <label for="" class="form-control text-center">à</label>
      <input type="text"  id="et" class="form-control form_time text-center font-italic" readonly required>
    </div>
</div>
</div>