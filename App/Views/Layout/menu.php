<header class="mb-5 pb-2">
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-<?= $_SESSION['type']; ?>">
    <div class="dropdown">
    <?php 
      if (!empty($_SESSION['photo'])) {
        $photo=$_SESSION['photo'];
      } else {
        $photo=($_SESSION['sexe']==='1')?'boys.png':'girls.png';
      }
    ?>
      <img src="<?php userImg($photo); ?>" class="rounded-circle mr-3" width="40" height="40" alt="image non disponible" data-toggle="dropdown" id="dropdownMenu2"  aria-haspopup="true" aria-expanded="false">
      <div class="dropdown-menu border-0 shadow mt-3" style="min-width:24rem;">
        <div class="d-flex px-3">
          <div class="d-flex flex-column justify-content-between">
            <h5><span class=" text-<?= $_SESSION['type']; ?> font-weight-bold"><?= $_SESSION['nom'] ?></span> <br><span class="text-muted"><?= $_SESSION['prenom'] ?></span></h5>
            <p class="mt-3 mb-0"><span class="text-muted font-italic"><?= $_SESSION['email']; ?> </span></p>
          </div>
          <div class="text-center">
            <img class="rounded-circle border border-<?= $_SESSION['type']; ?>" src="<?php userImg($photo); ?>" alt="" width="100" height="100"></br>
            <span class="font-italic text-<?= $_SESSION['type']; ?>"> <?= $_SESSION['username']; ?></span>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="d-flex px-2 bg-muted">
          <?php if($_SESSION['type']=='devmaster' || $_SESSION['type']=='admin'){ ?>
          <a href="/register" class="btn btn-sm btn-outline-<?= $_SESSION['type']; ?> mr-auto">s'inscrire</a>
          <?php }?>
          <a href="/user/logout" class="btn btn-sm btn-outline-<?= $_SESSION['type']; ?>">se déconnecter</a>
        </div>
        
      </div>


    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <?php getMenu($_SESSION['menu'],$current_menu);?>

        
      </ul>
    </div>
  </nav>
</header>







