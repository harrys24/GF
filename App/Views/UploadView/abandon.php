<div class="container">
  <h3 class="text-center mb-4">UPLOAD FICHIER ABANDON (CSV) </h3>
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Année universitaire</th>
        <th>Niveaux</th>
        <th>Parcours | Groupes</th>
        <th>NIE</th>
        <th>Abandon (OUI | NON)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>2020-2021</td>
        <td>L2</td>
        <td>BANCASS1</td>
        <td>SE2020001</td>
        <td>OUI</td>
      </tr>
    </tbody>
  </table>
  <form action="" method="post" id="upload-form">
    <div class="custom-file">
      <input type="file" name="file_data" class="custom-file-input" id="customFile" lang="fr" accept=".csv">
      <label class="custom-file-label" for="customFile" >Choisissez votre fichier <b>CSV</b> séparé par point virgule "<b>;</b>"</label>
    </div>
    <div class="d-flex justify-content-center my-4">
      <button type="submit" class="btn btn-outline-primary px-4"><i class="bi bi-upload mr-2"></i> uploader</button>
    </div>
  </form>
</div>