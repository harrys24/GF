<form action="" method="POST" id="register" class="col-12 col-md-4" >
  <?php getToken() ?>
  <input type="hidden" id="opk" name="opk">
  <div class="d-flex justify-content-center my-4">
    <div><i class="fal fa-4x fa-users-cog"></i></div>
  </div>
  <div class="form-group">
    <p class="h5 text-center">Gestion des utilisateurs</p>
  </div>
  <div class="form-group">
    <label for="nie">NIE</label>
    <input type="text" class="form-control" id="nie"  placeholder="nie" readonly>
  </div>
  <div class="form-group">
    <label for="nom">Nom(s)</label>
    <input type="text" class="form-control" id="nom"  placeholder="nom" readonly>
  </div>
  <div class="form-group">
    <label for="prenom">Prénom(s)</label>
    <input type="text" class="form-control" id="prenom"  placeholder="prénom" readonly>
  </div>
  <div class="form-group">
    <label for="email">Adresse email</label>
    <input type="email" class="form-control" id="email"  placeholder="Adresse email" readonly>
  </div>
  <div class="form-group">
    <label for="username">Nom d'utilisateur ou Pseudo</label>
    <input type="text" name="username" class="form-control" id="username"  placeholder="nom d'utilisateur ou pseudo" required>
  </div>

  <div class="form-group">
    <label for="pwd">Mot de passe</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Tapez le mot de passe" required>
  </div>
  <div class="form-group">
    <label for="cpwd">Confirmation</label>
    <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Retapez le mot de passe" required>
  </div>

  <div class="d-flex justify-content-center mt-2 mb-4">
    <button type="button" id="btn-aff" class="btn btn-outline-warning px-4">Afficher MDP</button>
    <button type="submit" class="btn btn-outline-primary px-4 ml-4">mettre à jour</button>
  </div>
</form>


