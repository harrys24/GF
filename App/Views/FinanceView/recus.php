<div class=" container-fluid py-2 px-3 sticky-top bg-white" style="top:56px;">
    <!-- <div class="container"> -->
        <h3 class="text-center">LISTES DES DERNIERS RECUS</h3>
        <div class="d-flex flex-lg-row flex-column  justify-content-between py-lg-3 py-0">
            <div class="input-group">
                <button class="btn btn-primary" id="ajout"><i class="bi bi-plus"></i>Ajouter</button>
            </div>
            <div class="input-group col-12 col-lg-3 mt-lg-0 mt-1">
                <h4 class="text-primary"> TOTAL: <span id="totalNow">??</span> Ar</h4>
            </div>
            <div class="input-group mr-2 col-12 col-lg-2 mt-lg-0 mt-2 p-0">
                <div class="input-group-prepend">
                    <div class="input-group-text">Filtre <span class="text-warning">*</span></div>
                </div>
                <select class="custom-select" id="filtre">
                    <option value="tous">Tous</option>
                    <option value="now">Aujourd'hui</option>
                    <option value="annule">Annulé</option>
                </select>
            </div>
            <div class="input-group col-12 col-lg-3 mt-lg-0 mt-2 p-0">
                <input type="text" name="recherche" id="recherche" class="form-control" placeholder="NIE...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="btnRecherche"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>


<div class="container-fluid py-2">
    <div class="table-md-responsive table-custom">
        <table class="table table-hover table-striped border">
            <thead>
                <th>#</th>
                <th>NIE</th>
                <th>Nom</th>
                <th>Prénom(s)</th>
                <th>Classe</th>
                <th class="text-center">Date de paiement</th>
                <th style="width: 150px;">Montant</th>
                <th style="width: 150px;">R.A.P</th>
                <th>Mode</th>
                <?php if($_SESSION['type'] == 'devmaster'){ ?>
                <th class="text-center" style="width: 160px">Action</th>
                <?php }else{ ?>
                    <th class="text-center" style="width: 120px">Action</th>
                <?php } ?>
            </thead>
            <tbody id="tbody">
                <?php foreach($recus as $k => $r){ ?>
                    <tr class="<?= $r['annul_recu'] == 1 ? 'bg-annul text-light' : ''?>">
                        <td><?= $k + 1 ?></td>
                        <td><?= $r["NIE"] ?></td>
                        <td><?= $r["nom"] ?></td>
                        <td><?= $r["prenom"] ?></td>
                        <td><?= $r["nom_niv"].''.$r['nom_gp'] ?></td>
                        <td class="text-center"><?php echo(date_format(new DateTime($r["date_p"]), 'd/m/Y')); ?></td>
                        <td><?= number_format($r['montant'], 2,",",' ') ?> Ar</td>
                        <td><?= number_format($r['reste'], 2,",",' ') ?> Ar</td>
                        <td><?= $r['mode'] ?></td>
                        <?php if(($r['annul_recu'] != 1 && $_SESSION['type'] != 'devmaster') || $_SESSION['type'] == 'devmaster'){ ?>
                            <td class="d-flex justify-content-around flex-lg-row flex-column">
                                <button class="btn btn-outline-warning btn-warning btn-light" id="modif" data-idr="<?= $r["idR"] ?>"><i class="bi bi-pen"></i></button>
                                <?php if($_SESSION['type'] == 'devmaster'){ ?>
                                    <button class="btn btn-outline-danger btn-light" id="delete" data-idr="<?= $r["idR"] ?>"><i class="bi bi-trash"></i></button>
                                <?php } ?>
                                <a href="./print/<?= $r["idR"] ?>" onclick="<?= $r['annul_recu'] == 1 ? 'return false;' : ''?>" style="<?= $r['annul_recu'] == 1 ? ' pointer-events: none;cursor: default;' : ''?>" target="_blank" class="btn mt-lg-0 mt-1 <?= $r['annul_recu'] == 1 ? 'btn-secondary' : 'btn-outline-admin btn-light'?>"><i class="bi bi-printer"></i></a>
                            </td>
                        <?php }else{
                            echo('<td></td>');
                        } ?>
                        <!-- <td class="d-flex justify-content-around"> <a href="#" class="btn btn-warning"><i class="bi bi-eye"></i></a><a href="./print/<?= $r["idR"] ?>" target="_blank" class="btn btn-primary"><i class="bi bi-printer"></i></a></td> -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>  
<!-- Modal -->
<div class="modal fade" id="modalRecus" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-end">
            <h4>Reçu</h4>
            <h5 class="ml-2">(<span class="text-primary" id="date">24/05/2022</span> à <span class="text-primary" id="heure">15:00</span>)</h6>
        </div>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="container d-flex flex-column">
                <div class="text-center mb-2">
                    <img src="/assets/images/logo-esmia.png" alt="" class="w-25">
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">NIE <span class="text-warning">*</span></div>
                    </div>
                    <input type="text" name="nie" id="nie" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="searchNie"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Nom</div>
                    </div>
                    <input type="text" name="nom" id="nom" class="form-control" disabled>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Prénoms</div>
                    </div>
                    <input type="text" name="prenom" id="prenom" class="form-control" disabled>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Niveau</div>
                    </div>
                    <input type="text" name="niveau" id="niveau" class="form-control" disabled>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Désignation <span class="text-warning">*</span></div>
                    </div>
                    <select class="custom-select" id="designation">
                        <option value="F.S">F.S</option>
                        <option value="D.I">D.I</option>
                        <option value="autre">Autre</option>
                    </select>
                    <input type="text" name="designation" id="designationTxt" class="form-control d-none">
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Montant <span class="text-warning">* Ar</span></div>
                    </div>
                    <input type="text" name="montant" id="montant" class="form-control">
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Reste <span class="text-warning">* Ar</span></div>
                    </div>
                    <input type="text" name="reste" id="reste" class="form-control">
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Date de paiement <span class="text-warning">*</span></div>
                    </div>
                    <input type="date" name="date_p" id="date_p" class="form-control">
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Mode de paiement <span class="text-warning">*</span></div>
                    </div>
                    <select class="custom-select" id="mode">
                        <option value="ESP">ESP</option>
                        <option value="Société Générale">Société Générale</option>
                        <option value="BNI">BNI</option>
                        <option value="MVOLA">MVOLA</option>
                        <option value="Cheque">Chèque</option>
                    </select>
                </div>
                <div class="input-group mb-2 d-none" id="divRef">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Ref <span class="text-warning">*</span></div>
                    </div>
                    <input type="text" name="ref" id="ref" class="form-control">
                </div>
                <div class="input-group mb-2 d-none" id="divNum">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Num Bordereau <span class="text-warning">*</span></div>
                    </div>
                    <input type="text" name="num" id="num" class="form-control">
                </div>
                <div class="input-group mb-2 d-none" id="divDate_bv">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Date du bordereau <span class="text-warning">*</span></div>
                    </div>
                    <input type="date" name="date_bv" id="date_bv" class="form-control">
                </div>
                <div class="input-group mb-2 d-none" id="divChq">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Num Chèque <span class="text-warning">*</span></div>
                    </div>
                    <input type="text" name="chq" id="chq" class="form-control">
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Signataire <span class="text-warning">*</span></div>
                    </div>
                    <select class="custom-select" id="signataire">
                        <option value="AD07-SPDE">Corine</option>
                        <option value="AD01-SPDE">Françoise</option>
                        <option value="AD-RH01">Steffy</option>
                        <option value="AD13-SPDE">Felana</option>
                        <option value="AD11-SPDE">Alexandra</option>
                        <option value="AD10-SPDE">Francesca </option> 
                        <option value="autre">Autre</option>
                    </select>
                    <input type="text" name="signataireTxt" id="signataireTxt" class="form-control d-none">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi bi-file-x"></i> Fermer</button>
        <button type="button" class="btn btn-primary" disabled id="save" data-modif="">
            <i class="bi bi-check-circle"></i> 
            Enregistrer
            <span class="spinner-border spinner-border-sm d-none" id="spin-save" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span>
        </button>
      </div>
    </div>
  </div>
</div>

