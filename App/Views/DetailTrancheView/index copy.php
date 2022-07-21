<h4 id="titre" class="mt-3 mb-4 text-center">DETAIL PAR TRANCHE</h4>
<div class="container">
    <form id="detail_form" action="/detail_tranche/check" method="post">
        <div id="feedback"></div>
        <div class="row">
            <div class="col-12 col-md-3 col-lg-2 form-group">
                <h6 class="text-primary">Année universitaire</h6>
                <select name="au" id="au" class="form-control">
                <?php foreach ($au as $v) { ?>
                    <option value="<?php echo $v['idAU']; ?>"><?php echo $v['nom_au'];  ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="col-12 col-md-3 col-lg-2 form-group">
                <h6 id="niv-title" class="text-primary">Niveau</h6>
                <select name="niv" id="niv" class="form-control">
                <?php foreach ($niv as $v) { ?>
                    <option value="<?php echo $v['idNIV']; ?>"><?php echo $v['nom_niv'];  ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="col-12 col-md-3 col-lg-2 form-group">
                <h6 id="tranche-title" class="text-primary">Tranche</h6>
                <select name="tranche" id="tranche" class="form-control">
                <?php foreach ($tranche as $v) { ?>
                    <option value="<?= $v['idT']; ?>" data-nbt="<?= $v['nbT']; ?>"><?= $v['nbT'];  ?> FOIS</option>
                <?php } ?>
                </select>
            </div>

            <div class="col-12 col-md-3 col-lg-2 form-group">
                <h6 class="text-primary">Montant 1er tranche</h6>
                <div class="input-group">
                    <input type="text" id="montant_initial" class="form-control" placeholder="1T Montant">
                    <div class="input-group-append">
                        <div class="input-group-text">AR</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4 form-group">
                <h6 class="text-primary">Date début paiement | tous les x mois</h6>
                <div class="input-group">
                    <input type="date" id="date_debut" class="col col-md-7 form-control" placeholder="date prévu">
                    <select id="decalage_mois" class="col-4 col-md-5 form-control">
                    <?php for ($i=1; $i <= 3 ; $i++) { ?>
                        <option value="<?= $i ?>"><?= $i ?> MOIS</option>
                    <?php } ?>
                    </select>
                </div>
            </div>
           
        </div>
        
        <h5 class="mt-3">Tranche de paiement</h5>
        <div id="ctranche" class="row"></div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save mr-2"></i>Sauvegarder</button>
        </div>
    </form>

</div>