<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="container-fluid">
  <div class="row pt-4">
    <?php getToken(); ?>
    <input type="hidden" id="inc" name="inc"/>
    <div class="dropdown col-12 col-md-4 col-lg-2 form-group">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddau"><i id="au_ico"></i>Année universitaire<em class="text-danger px-1">*</em></button>
      <div class="dropdown-menu" id="cau">
      <?php foreach ($au as $item) { ?> 
        <button class="dropdown-item" data-id=<?php echo $item['idAU']; ?>><?php echo $item['nom_au']; ?></button>
      <?php } ?>
      </div>
    </div>
      
    <div class="dropdown col-12 col-md-5 col-lg-2 form-group">
      <button class="btn btn-dark form-control dropdown-toggle"  id="ddniv" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Niveau<em class="text-danger px-1">*</em>
      </button>
      <div id="cnp" class="dropdown-menu">
      </div>
    </div>
    
    <div class="input-group form-group col-12 col-md-7 col-lg-2">
      <div class="input-group-prepend">
        <span class="input-group-text" >NIE<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="text"  id="ne" class="form-control" max_length="10" required>
    </div>

    <div class="input-group form-group col-12 col-md-7 col-lg-2">
      <button id="btn_verifier" class="btn btn-danger form-control"><i id="check-ico"></i>vérifier</button>
    </div>
  </div>

  <?php require 'list.php'; ?>
  <div id="ccontaint" class="row">
    <div class="input-group form-group col-12 col-md-5 col-lg-2">
      <div class="input-group-prepend">
        <span class="input-group-text" >Date<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="text" id="dc" value="<?php echo $dn; ?>" class="form-control form_date text-center font-italic" readonly required>
    </div>

    <div class="input-group form-group col-12 col-md-7 col-lg-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >Heure(s)<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="text"  id="st" class="form-control form_time text-center font-italic" readonly required>
      <label for="" class="form-control text-center">à</label>
      <input type="text"  id="et" class="form-control form_time text-center font-italic" readonly required>
    </div>

    <div class="dropdown col-12 col-md-4 col-lg-2 form-group">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddtp">TYPE<em class="text-danger px-1">*</em></button>
      <div class="dropdown-menu" id="ctp">
        <button class="dropdown-item" data-id="r">RETARD</button>
        <button class="dropdown-item" data-id="a">ABSENCE</button>
      </div>
    </div>

    <div class="dropdown col-12 col-md-4 col-lg-2 form-group">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddsal">SALLE<em class="text-danger px-1">*</em></button>
      <div class="dropdown-menu" id="csal">
      <?php foreach ($salles as $item) { ?> 
        <button class="dropdown-item" data-id=<?php echo $item['numSALLE']; ?>><?php echo $item['numSALLE']; ?></button>
      <?php } ?>
      </div>
    </div>
    
    <div class="col-12 col-md-7 col-lg-4">
      <div class="typeahead__container form-group">
        <div class="typeahead__field">
          <div class="typeahead__query input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">Matière</div>
            </div>
            <input id="txtMat" class="form-control" placeholder="Tapez le nom de la matière" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text px-3"></div>
            </div>
          </div>
          
        </div>
      </div>
    </div>

    <div class="col-12 col-md-7 col-lg-4">
      <div class="typeahead__container form-group">
        <div class="typeahead__field">
          <div class="typeahead__query input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">Enseignant</div>
            </div>
            <input id="txtProf" class="form-control" placeholder="Tapez le nom ou prénom du prof" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text px-3"></div>
            </div>
          </div>
          
        </div>
      </div>
    </div>

    <div id="cmotif" class="dropdown col-12 col-md-4 col-lg-3 form-group">
      <button class="btn btn-dark form-control dropdown-toggle" data-toggle="dropdown" id="ddmot">MOTIFS<em class="text-danger px-1">*</em></button>
      <div class="dropdown-menu" id="cmot">
      <?php foreach ($motif as $item) { ?> 
        <button class="dropdown-item" data-id=<?php echo $item['idMOTIF']; ?>><?php echo $item['motif']; ?></button>
      <?php } ?>
        <button class="dropdown-item" data-id='-1'>Autre...</button>
      </div>
    </div>

    <div class="col-12 col-md-4 col-lg-2 form-group">
      <button class="btn btn-primary form-control"  id="btnValider">Valider</button>
    </div>
  </div>

    <!-- <div id="cautre" class="input-group form-group col-12 col-md-7 col-lg-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >Motif<em class="text-danger pl-1">*</em></span>
      </div>
      <input type="text"  id="txtmotif" class="form-control" required>
      <div class="input-group-append">
        <button id="btncclose" class="btn btn-danger">X</button>
      </div>
    </div> -->
</div>