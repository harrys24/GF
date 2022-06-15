<style>
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu button::after {
  transform: rotate(-90deg);
  position: absolute;
  right: 6px;
  top: .8em;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-left: .11rem;
  margin-right: .1rem;
}
</style>
<script>
$(function(){
    $('.dropdown-menu button.dropdown-toggle').on('click', function(e) {
      if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
      }
      var $subMenu = $(this).next(".dropdown-menu");
      $subMenu.toggleClass('show');
    
    
      $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass("show");
      });
    
    
      return false;
    });
})
</script>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand" href="#">Listes des Etudiants</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      
   <li class="nav-item dropdown">
        <button class="btn btn-primary dropdown-toggle"  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Actions
        </button>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <button class="dropdown-item">Sélectionner tout</button>
          <button class="dropdown-item">Desélectionner tout</button>
          <div class="dropdown-submenu">
            <button class="dropdown-item dropdown-toggle">Migrer vers</button>
            <div class="dropdown-menu">
              <button class="dropdown-item">Subsubmenu action</button>
              <button class="dropdown-item">Another subsubmenu action</button>


              <div class="dropdown-submenu">
              <button class="dropdown-item dropdown-toggle">sub Menu</button>
                <div class="dropdown-menu">
                  <button class="dropdown-item">Subsubmenu action</button>
                  <button class="dropdown-item">Another subsubmenu action</button>
                </div>
              </div>

              <div class="dropdown-submenu">
              <button class="dropdown-item dropdown-toggle">sub Menu</button>
                <div class="dropdown-menu">
                  <button class="dropdown-item">Subsubmenu action</button>
                  <button class="dropdown-item">Another subsubmenu action</button>
                </div>
              </div>
             



            </div>
          </div>
        </div>
      </li>
    </div>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

