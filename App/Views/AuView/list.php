<div class="table-responsive col-12 col-md-8 mt-3">
  <table class="table table-sm table-striped table-bordered">
  <caption>Liste des utilisateurs</caption>
  <thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Identifiant(s)</th>
    <th scope="col">Nom(s)</th>
    <th scope="col">Prénom(s)</th>
    <th scope="col">Email(s)</th>
    <th scope="col">Type(s)</th>
    <th scope="col" colspan="2">Opérations</th>
  </tr>
  </thead>
  <tbody id="cei">
  <?php for($i=0;$i<count($list);$i++) { ?>
    <tr>
    <th scope="row" data-type="<?php echo $list[$i]['TU_id']; ?>"><?php echo $i+1; ?></th>
    <td><?php echo $list[$i]['username']; ?></td>
    <td><?php echo $list[$i]['nom']; ?></td>
    <td><?php echo $list[$i]['prenom']; ?></td>
    <td><?php echo $list[$i]['email']; ?></td>
    <td><?php echo $list[$i]['type']; ?></td>
    <td><button class="btn btn-sm btn-outline-warning btn-edit"><i class="fal fa-user-edit"></i></button></td>
    <td><button class="btn btn-sm btn-outline-danger btn-del"><i class="fal fa-user-times"></i></button></td>
  </tr>
  <?php  } ?> 
 
  
  

  
  </tbody>
  </table>

</div>