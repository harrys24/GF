<div class="input-group form-group col-8 col-md-5 col-lg-2">
    <div class="input-group-prepend">
    <span class="input-group-text" >AU<em class="text-warning pl-1">*</em></span>
    </div>
    <select name="AU_id" id="au" class="form-control" required>
    <?php foreach ($au as $item) { ?> 
        <option value="<?php echo $item['idAU']; ?>"><?php echo $item['nom_au']; ?></option>
    <?php } ?>
    </select>
</div>

<div class="input-group form-group col-10 col-md-6 col-lg-3">
    <div class="input-group-prepend">
    <span class="input-group-text" >NIVEAU<em class="text-success pl-1">*</em></span>
    </div>
    <select id="list-gp" class="form-control" required>
    </select>
</div>

<div class="input-group form-group col-12 col-md-7 col-lg-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >Heure(s)<em class="text-warning pl-1">*</em></span>
      </div>
      
      <input type="text"  id="st" class="form-control form_time text-center font-italic" readonly required>
      <label for="" class="form-control text-center">à</label>
      <input type="text"  id="et" class="form-control form_time text-center font-italic" readonly required>
    </div>

<script>
      $('#au').prop('selectedIndex',-1);
    function getOPT(v){
        return '<option n='+v.ni+' p='+v.pi+'>'+v.niv+' '+v.gp+'</option>';
    }
    $('#au').on('change',function(e){
        $('#list-gp').html('');
        $.post('/etudiant/check_niv',{id:$(this).val()},function(res){
            var s='';
            for(var i in res){
                s+=getOPT(res[i]);
            }
            $('#list-gp').html(s).prop('selectedIndex',-1);
        },'json')
    });
</script>