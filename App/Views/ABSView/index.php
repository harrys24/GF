<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="container-fluid">
  <div class="row pt-4">
    <?php getToken(); ?>
    <input type="hidden" id="inc" name="inc"/>
    <div class="input-group form-group col-10 col-md-6 col-lg-2">
      <div class="input-group-prepend">
        <span class="input-group-text" >Type<em class="text-danger pl-1">*</em></span>
      </div>
      <select id="type" class="form-control" required>
          <option value="a">ABSENCE</option>
          <option value="r">RETARD</option>
      </select>
    </div>

    <div class="input-group form-group col-12 col-md-5 col-lg-2">
      <div class="input-group-prepend">
        <span class="input-group-text" >Date<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="text" id="dc" value="<?php echo $dn; ?>" class="form-control form_date text-center font-italic" readonly required>
    </div>

    <div class="input-group form-group col-12 col-md-7 col-lg-2">
      <div class="input-group-prepend">
        <span class="input-group-text" >NIE<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="text"  id="ne" class="form-control" required>
    </div>

    <div class="input-group form-group col-12 col-md-7 col-lg-2">
      <button id="btn_verifier" class="btn btn-danger form-control"><i id="icon-load"></i>vérifier</button>
    </div>

   

  </div>
  <?php require 'list.php'; ?>
</div>