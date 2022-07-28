<div class="container pt-1">
    <h3 id="titre" class="text-center text-light bg-primary py-2 mb-4 rounded shadow-sm">FRAIS DE SCOLARITÉ ANNUEL</h3>
    <form id="detail_form" action="/TarifFs/checkData" method="post">
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
        </div>
        <div id="cmontant" class="row"></div>
        <div id="btn-submit" class="form-group">
            <button  type="submit" class="btn btn-primary"><i class="bi bi-save mr-2"></i>Sauvegarder</button>
        </div>
    </form>

</div>