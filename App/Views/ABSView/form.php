<form action="" method="POST" id="upload-form" class="col-12 col-md-4" enctype="multipart/form-data" >
  <?php getToken() ?>
  <div class="row">
  <div class="input-group form-group col-12 col-md">
    <div class="custom-file">
        <input type="file" name="file_data" class="custom-file-input" id="photo" lang="fr" accept=".csv">
        <label class="custom-file-label" for="photo" id="photoText">Parcourir</label>
    </div>
  </div>
  </div>
  <div class="d-flex justify-content-center mt-2 mb-4">
    <button type="submit" class="btn btn-outline-primary px-4">uploader</button>
  </div>
</form>


