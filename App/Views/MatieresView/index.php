<div id="feedback" class="fixed-top m-2" style="top:50px;"></div>
<div class="container-fluid">
  <div class="d-flex flex-column">
    <div class="col-md-5 col-lg-3">
      <button type="button" class="form-control btn btn-dark mt-2" data-toggle="modal" data-target="#profModal">
        <svg class="ebtn"><use xlink:href="/assets/svg/scrud.svg#setting"></svg>Enseignants
      </button>
      <button type="button" class="form-control btn btn-dark mt-2" data-toggle="modal" data-target="#matsModal">
        <svg class="ebtn"><use xlink:href="/assets/svg/scrud.svg#setting"></svg>Matières
      </button>
      <button type="button" class="form-control btn btn-dark mt-2" data-toggle="modal" data-target="#ueModal">
        <svg class="ebtn"><use xlink:href="/assets/svg/scrud.svg#setting"></svg>Unité d'Enseignant
      </button>
      <button type="button" class="form-control btn btn-dark mt-2" data-toggle="modal" data-target="#attrMatsModal">
        <svg class="ebtn"><use xlink:href="/assets/svg/scrud.svg#setting"></svg>Configuration Matières
      </button>
    </div>
  </div>
</div>


<?php 
getToken();
require 'matsM.php';
require 'ueM.php';
require 'profM.php';
require 'attrMatsM.php';
?>



