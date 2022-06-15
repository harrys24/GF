<div class="container py-3">
    <h3 class="text-center">Synthèse des données saisies</h3>
    <hr>
</div>

<div class="container">
    <div class="row justify-content-around">
        <div class="col-12 col-lg-5">
            <div class="card m-1">
                <div class="card-header text-center">
                    <div class="card-img-top">
                        <i class="bi bi-bank"></i>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h2>Montant perçus</h2>
                    <h4 class="text-primary"><b><?= number_format($data, 2,",",' ') ?></b> ARIARY</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card m-1">
                <div class="card-header text-center">
                    <div class="card-img-top">
                        <i class="bi bi-bank2"></i>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h2>Montant à percevoire</h2>
                    <h4 class="text-primary"><b>0,00</b> ARIARY</h4>
                </div>
            </div>
        </div>
    </div>
</div>