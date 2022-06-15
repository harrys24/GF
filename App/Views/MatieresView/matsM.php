<!-- Matière -->
<div class="modal fade" id="matsModal" tabindex="-1" role="dialog" aria-labelledby="matsModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="matsModalTitle">Formulaire d'ajout matière</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div id="matsFD" ></div>
          <div class="d-flex justify-content-center">
            <div class="col-md-6 form-group">
              <button id="matsBtnAdd" class="btn btn-dark form-control"><svg class="ebtn"><use xlink:href="/assets/svg/scrud.svg#plus"></svg>Nouveau matière</button>
            </div>
          </div>
          <form id="matsForm" class="form-group" method="post" action="">
            <div class="row">
              <div class="col-md-8 col-lg-6">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Libellé</div>
                  </div>
                  <input type="text" id="nom_mat" name="nom_mat" class="form-control" placeholder="Tapez ici ..." aria-label="Tapez ici ..." required>
                </div>
              </div>
              <div class="col-md-4 col-lg-3">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">code</div>
                  </div>
                  <input type="text" id="code_mat" name="code_mat" class="form-control" placeholder="_ _ _ _ _" aria-label="_ _ _ _ _">
                </div>
              </div>
              <div class="col-md-5 col-lg-3">
                <button type="submit" id="matsBtnSave" class="btn btn-primary form-control"><i id="matIco"></i> Enregistrer</button>
              </div>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Matières</th>
                <th scope="col">Codes</th>
                <th scope="col" colspan="2">Opérations</th>
              </tr>
            </thead>
            <tbody id="matsCei">
            <?php for($i=0;$i<count($mats);$i++) { ?>
            <tr id="mats<?php echo $mats[$i]['idMAT']; ?>">
              <th scope="row" data-id="<?php echo $mats[$i]['idMAT']; ?>"><?php echo $i+1; ?></th>
              <td><?php echo $mats[$i]['nom_mat']; ?></td>
              <td><?php echo $mats[$i]['code_mat']; ?></td>
              <td class="text-center"><button class="btn btn-sm btn-outline-warning btn-edit"><svg><use xlink:href="/assets/svg/scrud.svg#edit"></svg></button></td>
              <td class="text-center"><button class="btn btn-sm btn-outline-danger btn-del"><svg><use xlink:href="/assets/svg/scrud.svg#delete"></svg></button></td>
            </tr>
            <?php  } ?> 
            </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>