<!-- Modal -->
<div class="modal fade" id="item-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="item-title" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="item-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-md-responsive">
            <table class="table table-sm table-striped border">
                <thead>
                    <th>Echéance</th>
                    <th>Date prévu</th>
                    <th>Date paiement</th>
                    <th>N° Réçu</th>
                    <th>Montant (AR)</th>
                    <th class="text-center" style="width:50px;">Status</th>
                    <th class="text-center" style="width:50px;">Action</th>
                </thead>
                <tbody id="modal-tbody">
                   
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <h5 class="font-weight-light mb-3">Tarif  : <span class="text-blue" id="item-tarif">-</span> AR</h5>
            <h5 class="font-weight-light">Payé : <span class="text-blue" id="item-paye">-</span> AR</h5>
            <h5 class="font-weight-light">Reste : <span class="text-blue" id="item-reste">-</span> AR</h5>
        </div>
        <div class="d-flex justify-content-between">
            <h5 class="font-weight-light mb-3">Echéance : <span class="text-blue" id="item-echeance">10/10</span></h5>
            <h5 class="font-weight-light">N° Réçu : <span class="text-blue" id="item-num">ESP0001</span></h5>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">MODE</div>
                    </div>
                    <select class="form-control form-group" name="mode-paiement" id="mode-paiement">
                        <option value="CHQ">CHÈQUE</option>
                        <option value="ESP">ESPÈCE</option>
                        <option value="BV">BORDEREAU DE VERSEMENT</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">MONTANT (AR)</div>
                    </div>
                   <input type="text" name="montant" id="montant" class="form-control">
                </div>
            </div>
           
       
       </div>
       <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">PAYÉ LE</div>
                    </div>
                    <input type="date" name="date-paiement" id="date-paiement" value="<?php echo((new DateTime('now'))->format('Y-m-d')) ; ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
            </div>
       </div>
      
      </div>
      <div class="modal-footer">
            <button type="button" id="modal-reset" class="btn btn-danger"><i class="bi bi-arrow-repeat mr-2"></i>Initialiser</button>
            <button type="button" id="modal-valider" class="btn btn-blue"><i class="bi bi-save mr-2"></i>Valider</button>
            <a type="button" id="modal-imprimer" class="btn btn-blue" target="_blank" href="/Finance/Imprimer"><i class="bi bi-printer mr-2"></i>Imprimer</a>
            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button> -->
      </div>
    </div>
  </div>
</div>
<div class="py-2 px-3 sticky-top bg-white" style="top:56px;">
    <div class="d-flex justify-content-between align-items-center" >
        <div>
            <span class="text-success mr-5">Payé : <i class="bi bi-check-circle-fill px-2"></i></span>
            <span class="text-danger">Non Payé : <i class="bi bi-x-circle-fill px-2"></i></span>
        </div>
        <div class="">
            <span id="result"></span>
        </div>
        <form id="form" method="POST" action="">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Date</div>
                    </div>
                    <!-- A MODIFIER PAR '2022-04-01' par 'now' -->
                    <?php $now= ((new DateTime('2022-04-01'))->format('Y-m-d')) ; ?>
                    <input type="date" name="ck_date" id="ck_date" value="<?php echo $now; ?>" class="form-control">
                    <div class="input-group-append">
                        <button type="submit" id="btn_search" class="btn btn-<?php echo $_SESSION['type']; ?>">
                        <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
        </form>
    </div>
</div>
<div class="container">
    <!-- Button trigger modal -->
    <?php
    if (\App\Core\Conf::online==0) {  ?>
        <button type="button" class="btn btn-primary" style="position:fixed;bottom:10px;right:10px;" data-toggle="modal" data-target="#item-modal">
        Launch
        </button>
    <?php    } ?>
    <!-- style="height:83vh;overflow: scroll;" -->
    <div class="table-md-responsive" >
        <table class="table table-hover table-striped border">
            <thead>
                <th>#</th>
                <th>Niveau</th>
                <th>NIE</th>
                <th>Nom</th>
                <th>Prénom(s)</th>
                <th>Contact(s)</th>
                <th class="text-center">Echéance</th>
                <th class="text-center px-2">Payé</th>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>
</div>