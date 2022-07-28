$(function(){
    $('#au').prop('selectedIndex',-1);
    function viewU(index,item=''){
        return '<div class="col-12 col-md-2 form-group">'+
            '<h6 class="text-primary">Niveau '+item.nom_niv+'</h6>'+
            '<input type="hidden" id="detail-'+index+'-id" name="detail['+index+'][id]" value="'+item.id+'">'+
            '<input type="hidden" id="detail-'+index+'-niv" name="detail['+index+'][niv]" value="'+item.NIV_id+'">'+
            '<div class="input-group">'+
                '<input type="text" id="detail-'+index+'-montant" name="detail['+index+'][montant]" value="'+item.montant_tar+'" class="form-control" placeholder="Montant" required>'+
                '<div class="input-group-append">'+
                    '<div data-index="'+index+'" id="btn-'+index+'-check" class="btn btn-primary btn-check "><i class="bi bi-check"></i></div>'+
               ' </div>'+
            '</div>'+
        '</div>';
    }
    function viewI(index,item=''){
        return '<div class="col-12 col-md-2 form-group">'+
            '<h6 class="text-primary">Niveau '+item.nom_niv+'</h6>'+
            '<input type="hidden" id="detail-'+index+'-niv" name="detail['+index+'][niv]" value="'+item.idNIV+'">'+
            '<div class="input-group">'+
                '<input type="text" id="detail-'+index+'-montant" name="detail['+index+'][montant]" class="form-control" placeholder="Montant" required>'+
            '</div>'+
        '</div>';
    }
    $('#au').on('change',function(){
        var au=$('#au').val(),au_text=$('#au option:selected').text();
        $.post('/TarifFs/checkView',{'au':au},function(res){
            var html='',mode='';
            if (res.mode=='u') {
                mode='ÉDITION';
                $('#titre').html('TARIF FS EN EDITION').removeClass('bg-primary').addClass('bg-danger')
                res['list'].forEach((v,k) => {
                    html+=viewU(k,v)
                });
                $('#au').data('mode','u');
                $('#cmontant').html(html);
                $('#btn-submit').addClass('d-none');
                
            }else{
                mode='INSERTION';
                $('#titre').html('AJOUT NOUVEAU TARIF FS').removeClass('bg-danger').addClass('bg-primary')
                res['list'].forEach((v,k) => {
                    html+=viewI(k,v)
                });
                $('#au').data('mode','i');
                $('#cmontant').html(html);
                $('#btn-submit').removeClass('d-none');
            }
            toastr.info('Frais de scolarité pour '+au_text+' bien chargé','INFORMATION : MODE '+mode)
        },'json')
    })
    $('#cmontant').on('click','.btn-check',function(){
        var index=$(this).data('index'),au=$('#au').val(),id=$('#detail-'+index+'-id').val()
        niv=$('#detail-'+index+'-niv').val(),montant=$('#detail-'+index+'-montant').val();
        var loading='<i class="spinner-grow spinner-grow-sm text-light" role="status"></i>';
        $('#btn-'+index+'-check').html(loading);
        $.post('/TarifFs/update',{'id':id,'au':au,'niv':niv,'montant':montant},function(res){
            $('#btn-'+index+'-check').html('<i class="bi bi-check"></i>');
        })
    })
    
})