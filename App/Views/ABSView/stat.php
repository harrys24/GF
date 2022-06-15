<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="container-fluid">
  <div class="row pt-3">
    <?php getToken(); ?>
    <div class="input-group form-group col-12 col-md-5 col-lg-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >Date Debut<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="text" id="sd"  class="form-control form_date text-center font-italic" readonly required>
    </div>
    
    <div class="input-group form-group col-12 col-md-5 col-lg-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >Date Fin<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="text" id="ed"  class="form-control form_date text-center font-italic" readonly required>
    </div>
    
    <div class="input-group form-group col-12 col-md-7 col-lg-2">
      <button id="btn_verifier" class="btn btn-danger form-control"><i id="icon-load"></i>vérifier</button>
    </div>
  </div>

  <div class="row">
    <?php require 'list_stat.php'; ?>
  </div>

</div>