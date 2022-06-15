<!-- Enseignant -->
<div class="modal fade" id="profModal" tabindex="-1" role="dialog" aria-labelledby="profModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profModalTitle">Formulaire d'ajout enseignant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="profForm" method="post" action="">
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-5">
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Nom</div>
                </div>
                <input type="text" name="nom_pr" class="form-control" placeholder="Tapez ici ..." aria-label="Tapez ici ..." required>
              </div>
            </div>
            <div class="col-md-7">
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Prénoms</div>
                </div>
                <input type="text" name="prenom_pr" class="form-control" placeholder="Tapez ici ..." aria-label="Tapez ici ..." required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 form-group">
              <input id="sexe" name="sexe_pr" style="width=200" type="checkbox">
            </div>
            <div class="col-md-4">
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-phone"></i></div>
                </div>
                <input type="text" name="contacte_pr" class="form-control" placeholder="contacte" aria-label="contacte" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                </div>
                <input type="email" name="email_pr" class="form-control" placeholder="Email" aria-label="Email" required>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
      </form>
    </div>
  </div>
</div>