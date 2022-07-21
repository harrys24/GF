<h4 id="titre" class="mt-3 mb-4 text-center">FS ANNUEL</h4>
<div class="container">
    <table class="table  table-striped">
        <thead>
            <tr>
                <th style="width:200px;">Année universitaire</th>
                <th style="width:100px;">Niveaux</th>
                <th>Montants</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($list as $item) { ?>
                <tr>
                    <td><?= $item['nom_au'] ?></td>
                    <td><?= $item['nom_niv'] ?></td>
                    <td><?= $item['montant_tar'] ?></td>
                    <td><a href=""><i class="bi bi-pen"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>