<?php for($i=0;$i<count($attrMats);$i++) { ?>
<tr id="attrMats<?php echo $attrMats[$i]['idMAT']; ?>">
    <th scope="row" data-id="<?php echo $attrMats[$i]['idMAT']; ?>"><?php echo $i+1; ?></th>
    <td><?php echo $attrMats[$i]['nom_mat']; ?></td>
    <td><?php echo $attrMats[$i]['code_mat']; ?></td>
    <td class="text-center"><button class="btn btn-sm btn-outline-warning btn-edit"><i class="fal fa-edit"></i></button></td>
    <td class="text-center"><button class="btn btn-sm btn-outline-danger btn-del"><i class="fal fa-trash-alt"></i></button></td>
</tr>
<?php  } ?> 

<div class="row no-gutters p-2">
<div class="col-md-6 col-lg-4">
    <div class="input-group form-group">
    <div class="input-group-prepend">
        <div class="input-group-text">EN</div>
    </div>
    <select id="gp1" class="form-control gp" required>
    </select>
    </div>
</div>
<div class="col-md-6 col-lg-4 pl-md-2">
    <div class="input-group form-group">
    <div class="input-group-prepend">
        <div class="input-group-text">Semestre</div>
    </div>
    <select id="sem1" class="form-control sem" required>
    </select>
    </div>
</div>
<div class="col-8 col-md-6 col-lg-4 pl-lg-2">
    <div class="input-group form-group">
    <div class="input-group-prepend">
        <div class="input-group-text">CREDIT</div>
    </div>
    <input type="text" id="crd1" class="form-control">
    </div>
</div>

<div class="col-lg-8">
    <div class="typeahead__container form-group">
    <div class="typeahead__field">
        <div class="typeahead__query input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">Enseignant</div>
        </div>
        <input class="txtProf form-control" placeholder="Tapez le nom ou prénom du prof" autocomplete="off">
        <div class="input-group-append">
            <div class="input-group-text px-3"></div>
        </div>
        </div>
    </div>
    </div>
</div>


</div>