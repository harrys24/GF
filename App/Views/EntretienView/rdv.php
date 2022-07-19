<h1 id="titre" class="text-center">PRISE DE RDV</h1>
<div class="container">
    <form action="/entretien/saveRdv" method="post">

        <div class="row">
            <div class="col col-md-2 form-group">
                <select name="" id="" class="form-control">
                <?php foreach ($au as $v) { ?>
                    <option value="<?php echo $v['idAU']; ?>"><?php echo $v['nom_au'];  ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="col col-md-2 form-group">
                <select name="" id="" class="form-control">
                <?php foreach ($niv as $v) { ?>
                    <option value="<?php echo $v['idNIV']; ?>"><?php echo $v['nom_niv'];  ?></option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="row">
    
            <div class="col col-md-6 form-group">
                <input type="text" name="nom" id="nom" class="form-control" placeholder="nom">
            </div>
            <div class="col col-md-6 form-group">
                <input type="text" name="prenom" id="prenom" class="form-control" placeholder="prénom">
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary"><i class="bi bi-save mr-2"></i>Sauvegarder</button>
    </form>

</div>