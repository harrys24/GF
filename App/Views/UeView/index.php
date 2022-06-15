<center><h1 class="text-primary" style="margin-top:80px;">Unité d'enseignement</h1></center>
<button class="btn btn-primary ajout" data-toggle="modal" data-target="#modalUe">Ajouter</button>
<center>
<div id="success" style="width:60%;"></div>
<div id="table-responsive">
  <table class="table table-striped mt-3 list" id="tableauUE">
      <thead class="table-primary">
          <th>Titre</th>
          <th>Nom de l'unité d'enseignement</th>
          <th>Modifier</th>
          <th>Supprimer</th>
      </thead>
      <tbody id="trProf">
          <?php $this->showUE() ?>
      </tbody>
  </table>
</div>
</center>

<!-- Modal -->
<div class="modal fade" id="modalUe" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal">Ajouter une unité d'enseignement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-group">
                <label for="titre">Titre:</label>
                <input type="text" name="titre" id="titre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom de l'unité d'enseignement:</label>
                <input type="text" name="nom" id="nom" class="form-control" required>
            </div>
            <div id="err">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary" id="valider">Valider</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalModif" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal">Modifier l'unité d'enseignement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-group">
                <label for="t">Titre:</label>
                <input type="text" name="titre" id="t" class="form-control" required>
                <input type="hidden" id="idUE">
            </div>
            <div class="form-group">
                <label for="n">Nom de l'unité d'enseignement:</label>
                <input type="text" name="nom" id="n" class="form-control" required>
            </div>
            <div id="errM">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary" id="v">Valider</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal">Confirmer la suppression</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
            <ul>Voulez-vous vraiment supprimer cette unité d'enseignement?
                <li>Si vous continuez cette action, tout les éléments rattachés à cette unité d'enseignement seront aussi supprimés!</li>
            </ul>
        </div>
        <input type="hidden" id="idUE">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-danger" id="validerS">Supprimer</button>
      </div>
    </div>
  </div>
</div>