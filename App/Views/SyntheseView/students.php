<div class="py-2 px-5 sticky-top bg-white" style="top:56px;">
    <h3 class="text-center">Synthèse par étudiant</h3>
    <div class="row justify-content-between py-2">
        <div class="input-group col-lg-2 col-12 py-lg-0 py-1">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-calendar-minus"></i></span>
            </div>
            <input type="date" name="debut" id="debut" class="form-control">
        </div>
        <div class="input-group col-lg-2 col-12 py-lg-0 py-1">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
            </div>
            <input type="date" name="fin" id="fin" class="form-control">
        </div>
        <div class="input-group col-lg-2 col-12 py-lg-0 py-1">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-lightbulb"></i></span>
            </div>
            <select name="filtre" id="filtre" class="custom-select">
                <option value="tous">Tous</option>
                <option value="FS">F.S</option>
                <option value="DI">D.I</option>
            </select>
        </div>
        <div class="input-group col-lg-6 col-12">
            <select class="custom-select" id="selectStudent">
                <option selected>Etudiants...</option>
                <?php foreach($students as $st){ ?>
                    <option value="<?= $st['num_matr'] ?>"><?= $st['nie'].' - '.$st['nom'].' '.$st['prenom'] ?></option>
                <?php } ?>
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="btnRecherche"><i class="bi bi-search"></i></button>
            </div>
        </div>
        <!-- <div class="input-group col-lg-4 col-12 py-lg-0 py-1">
            <input type="text" name="recherche" id="nie" class="form-control" placeholder="NIE...">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="searchNie"><i class="bi bi-search"></i></button>
            </div>
        </div> -->
    </div>
</div>

<div class="container py-3">
    <div class="d-flex flex-column">
        <h3 class="text-primary" id="nie"></h3>
        <h3 class="text-primary" id="nom"></h3>
    </div>
    <hr>
    <div class="row justify-content-around">
        <div class="col-12 col-lg-5">
            <div class="card m-1">
                <div class="card-header text-center">
                    <div class="card-img-top">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h2>Montants payés</h2>
                    <h4 class="text-primary" id="montant"></h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card m-1">
                <div class="card-header text-center">
                    <div class="card-img-top">
                        <i class="bi bi-bag-x"></i>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h2>Reste à payé</h2>
                    <h4 class="text-primary" id="reste"></h4>
                </div>
            </div>
        </div>
    </div>
</div>