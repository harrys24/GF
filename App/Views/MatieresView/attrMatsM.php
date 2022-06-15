<!-- Matière -->
<div class="modal fade" id="attrMatsModal" tabindex="-1" role="dialog" aria-labelledby="attrMatsModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attrMatsModalTitle">Fiche d'attribution matière</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="attrMatsFD" ></div>
        <div id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h4 class="mb-0">
                <button class="btn btn-link text-uppercase" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Formulaire d'attribution matière
                </button>
              </h4>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body"><?php require('_attrMatsFrm.php'); ?></div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h4 class="mb-0">
                <button class="btn btn-link text-uppercase collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Matières configurées
                </button>
              </h4>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body"><?php require('_attrFilter.php'); ?></div>
            </div>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>