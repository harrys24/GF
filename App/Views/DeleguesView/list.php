<div class="table-responsive col-12 col-md-8 mt-3">
  <table class="table table-sm table-striped table-bordered">
  <caption>Liste des utilisateurs</caption>
  <thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Identifiant(s)</th>
    <th scope="col">Mot de passe</th>
    <th scope="col">NIE</th>
    <th scope="col">Nom(s)</th>
    <th scope="col">Prénom(s)</th>
    <th scope="col">Email(s)</th>
    <th scope="col">Parcours</th>
    <th scope="col" colspan="2">Opérations</th>
  </tr>
  </thead>
  <tbody id="cei">
  <?php for($i=0;$i<count($list);$i++) { ?>
    <tr>
      <th scope="row" ni="<?php echo $list[$i]['INSCR_num_matr']; ?>"><?php echo $i+1; ?></th>
      <td><?php echo $list[$i]['username']; ?></td>
      <td><?php echo $list[$i]['password']; ?></td>
      <td><?php echo $list[$i]['nie']; ?></td>
      <td><?php echo $list[$i]['nom']; ?></td>
      <td><?php echo $list[$i]['prenom']; ?></td>
      <td><?php echo $list[$i]['email']; ?></td>
      <td><?php echo $list[$i]['nom_niv'].' '.$list[$i]['nom_gp']; ?></td>
      <td><button class="btn btn-sm btn-outline-warning btn-edit"><i class="fal fa-user-edit"></i></button></td>
      <td><button class="btn btn-sm btn-outline-danger btn-del"><i class="fal fa-user-times"></i></button></td>
    </tr>
  <?php  } ?> 
 
  
  

  
  </tbody>
  </table>

</div>
