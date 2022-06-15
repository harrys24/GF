<!-- <div id="feedback" class="fixed-top" style="margin-top:60px;"> -->
<div id="feedback" class="mt-4 bg-light">
<?php if(isset($notif)){ ?>
<div class="alert alert-<?php echo $notif['type']; ?>" role="alert">
<?php echo $notif['message']; ?>
</div>
<?php } ?>
</div>
<div class="container">
  <div class="d-flex justify-content-center mt-2 mb-4">
    <h3 class="text-primary bg-white py-3 px-4 border">
      Uploader le fichier dans GEO
    </h3>
  </div>
  <div class="row p-4 bg-white rounded mb-4 shadow-sm">
      
    <?php 
        include 'form.php'; 
        include 'list.php'; 
    ?>
  </div>
</div>