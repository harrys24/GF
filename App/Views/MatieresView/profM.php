<!-- Matière -->
<div class="modal fade" id="profModal" tabindex="-1" role="dialog" aria-labelledby="profModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profModalTitle">Formulaire d'ajout matière</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div id="profFD" ></div>
          <div class="d-flex justify-content-center">
            <div class="col-md-6 form-group">
              <button id="profBtnAdd" class="btn btn-dark form-control"><svg class="ebtn"><use xlink:href="/assets/svg/scrud.svg#user-add"></svg>Nouveau enseignant</button>
            </div>
          </div>
          <form id="profForm" class="form-group" method="post" action="">
            
            <div class="row">
              <div class="col-md-5">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Nom</div>
                  </div>
                  <input type="text" id="nom_pr" name="nom_pr" class="form-control" placeholder="Tapez ici ..." aria-label="Tapez ici ..." required>
                </div>
              </div>
              <div class="col-md-7">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Prénoms</div>
                  </div>
                  <input type="text" id="prenom_pr" name="prenom_pr" class="form-control" placeholder="Tapez ici ..." aria-label="Tapez ici ..." required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 form-group">
                <input id="sexe_pr" name="sexe_pr" style="width=200" type="checkbox">
              </div>
              <div class="col-md-4">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><svg><use xlink:href="/assets/svg/inscr.svg#phone"></svg></span>
                  </div>
                  <input type="text" id="contacte_pr" name="contacte_pr" class="form-control" placeholder="contacte" aria-label="contacte">
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><svg><use xlink:href="/assets/svg/inscr.svg#mail"></svg></span>
                  </div>
                  <input type="email" id="email_pr" name="email_pr" class="form-control" placeholder="Email" aria-label="Email">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Grade</div>
                  </div>
                  <select name="GR_id" id="GR_id" class="form-control" required>
                  <?php foreach ($grade as $item) { ?> 
                  <option value="<?= $item['idGR']; ?>" ><?= $item['nom_gr']; ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-5 col-lg-3">
                <button type="submit" id="profBtnSave" class="btn btn-primary form-control"><i id="matIco"></i> Enregistrer</button>
              </div>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom(s)</th>
                <th scope="col">Prénom(s)</th>
                <th scope="col">Sexe</th>
                <th scope="col">Contacte(s)</th>
                <th scope="col">Email(s)</th>
                <th scope="col" colspan="2">Opérations</th>
              </tr>
            </thead>
            <tbody id="profCei">
            <?php foreach ($prof as $i => $item) { ?>
            <tr id="prof<?= $item['idPR']; ?>">
              <th scope="row" data-id=<?= $item['idPR']; ?> data-gr=<?= $item['GR_id']; ?> > <?= $i+1; ?> </th>
              <td><?= $item['nom_pr']; ?></td>
              <td><?= $item['prenom_pr']; ?></td>
              <td><?= ($item['sexe_pr']=='1')?'H':'F'; ?></td>
              <td><?= $item['contacte_pr']; ?></td>
              <td><?= $item['email_pr']; ?></td>
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