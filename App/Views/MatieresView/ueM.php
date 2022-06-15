<!-- UE -->
<div class="modal fade" id="ueModal" tabindex="-1" role="dialog" aria-labelledby="ueModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ueModalTitle">Formulaire d'ajout Unité d'Enseignant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div id="ueFD" ></div>
          <div class="d-flex justify-content-center">
            <div class="col-md-6 form-group">
              <button id="ueBtnAdd" class="btn btn-dark form-control"><svg class="ebtn"><use xlink:href="/assets/svg/scrud.svg#plus"></svg>Nouveau UE</button>
            </div>
          </div>
          <form id="ueForm" class="form-group" method="post" action="">
            <div class="row">
              <div class="col-md-4 col-lg-3">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Titre </div>
                  </div>
                  <input type="text" id="titre_ue" name="titre_ue" class="form-control" placeholder="UE?">
                </div>
              </div>
              <div class="col-md-8 col-lg-6">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Libellé</div>
                  </div>
                  <input type="text" id="nom_ue" name="nom_ue" class="form-control" placeholder="Tapez ici ..." aria-label="Tapez ici ..." required>
                </div>
              </div>
              <div class="col-md-5 col-lg-3">
                <button type="submit" id="ueBtnSave" class="btn btn-primary form-control"><i id="matIco"></i> Enregistrer</button>
              </div>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Libellé</th>
                <th scope="col" colspan="2">Opérations</th>
              </tr>
            </thead>
            <tbody id="ueCei">
            <?php foreach ($ue as $i => $item) { ?>
            <tr id="ue<?= $item['idUE']; ?>">
              <th scope="row" data-id="<?= $item['idUE']; ?>"><?= $i+1; ?></th>
              <td><?= $item['titre_ue']; ?></td>
              <td><?= $item['nom_ue']; ?></td>
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