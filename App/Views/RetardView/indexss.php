<div id="feedback" class="fixed-top m-2"></div>
<div class="container-fluid">
  <p class="text-center pt-2">
    <span class="text-muted font-italic"><?php echo $_SESSION['nom_niv'].'-'.$_SESSION['nom_gp'].' ('.$_SESSION['nom_au'].')'; ?> </span></br>
  </p>
  <div class="row">
    <?php getToken(); ?>
    <div class="input-group form-group col-12 col-md-7 col-lg">
      <div class="input-group-prepend">
        <span class="input-group-text" >Matière(s)<em class="text-warning pl-1">*</em></span>
      </div>
      <select id="mat" class="form-control" required>
        <?php foreach ($matieres as $item) { ?> 
          <option value="<?php echo $item['nom_mat']; ?>" m="<?php echo $item['MAT_id']; ?>"><?php echo $item['nom_mat'].' ('.$item['nom_type'].') - '.$item['nom_pr'].' '.$item['prenom_pr']; ?></option>
        <?php } ?>
      </select>
    </div>

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
      <input type="text" id="dn" value="<?php echo $dn; ?>" class="form-control form_date text-center font-italic" readonly required>
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

  <div class="row no-gutters">
    <div class="table-responsive ">
      <table class="table table-striped table-bordered">
      <caption>Liste des étudiants</caption>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">NIE</th>
          <th scope="col">Nom</th>
          <th scope="col">Prénom(s)</th>
          <th scope="col">Sexe</th>
          <th scope="col">PR</th>
          <th scope="col">ABS</th>
          <th scope="col">RT</th>
        </tr>
      </thead>
      <tbody id="cei">
      <?php 
        if(isset($etudiants)){
          $i=1;
          foreach ($etudiants as $etudiant) { ?>
          <tr>
          <th scope="row" ne="<?php echo $etudiant['num_matr']; ?>"><?php echo $i; ?></th>
          <td><?php echo $etudiant['nie']; ?></td>
          <td class="font-weight-bold"><?php echo $etudiant['nom']; ?></td>
          <td><?php echo $etudiant['prenom']; ?></td>
          <td><?php echo $etudiant['sexe']; ?></td>
          <th class="pr col-th"><input name="rd<?php echo $i; ?>" type="radio" ck="p" checked /></th>
          <th class="abs col-th"><input name="rd<?php echo $i ;?>" type="radio" ck="a" /></th>
          <th class="rt col-th"><input name="rd<?php echo $i++; ?>" type="radio" ck="r" /></th>
        </tr>
        <?php  }
        }
      ?>
      </tbody>
      </table>
    </div>
  </div>
  <div class="row px-4 mb-3">
    <textarea id="cms" cols="30" rows="3" class="form-control" placeholder="Tapez ici votre commentaire"></textarea>
  </div>

  <div class="custom-control custom-checkbox mr-sm-2">
    <input type="checkbox" class="custom-control-input" id="ckc">
    <label class="custom-control-label" for="ckc"><em class="text-primary">"J'accepte la conformité de la partie susciter."</em></label>
  </div>
  
  <div class="d-flex justify-content-center my-3">
    <button class="btn btn-primary col-5" id="btnValider"><i class="fa fa-check mr-2"></i>VALIDER</button>
  </div>

</div>

