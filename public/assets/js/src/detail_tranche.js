$(function(){
    $('#au').prop('selectedIndex',-1);
    $('#niv').prop('selectedIndex',-1);
    $('#tranche').prop('selectedIndex',-1);
    var loading='<i class="spinner-grow spinner-grow-sm text-primary" role="status"></i>';
    function viewT(index,date_value='',montant_value=''){
        return '<div class="col-12 col-md-6 col-lg-4 form-group">'+
        '<b>Tranche '+index+'</b>'+
        '<input type="hidden" name="detail['+index+'][num_tranche]" value="'+index+'"/>'+
        '<div class="input-group">'+
            '<input type="date" name="detail['+index+'][date_prevu]" value="'+date_value+'" class="col-8 form-control" placeholder="date prévu" required>'+
            '<input type="text" name="detail['+index+'][montant]" value="'+montant_value+'" class="col-4 form-control" placeholder="0.00" required>'+
            '<div class="input-group-append"><div class="input-group-text">AR</div></div>'+
        '</div></div>'
    }
    function viewTU(index,id,num_tranche,date_value,montant_value){
        return '<div class="col-12 col-md-6 col-lg-4 form-group">'+
        '<b>Tranche '+index+'</b>'+
        '<input type="hidden" name="detail['+index+'][id]" value="'+id+'"/>'+
        '<input type="hidden" name="detail['+index+'][num_tranche]" value="'+num_tranche+'"/>'+
        '<div class="input-group">'+
            '<input type="date" name="detail['+index+'][date_prevu]" value="'+date_value+'" class="col-8 form-control" placeholder="date prévu" required>'+
            '<input type="text" name="detail['+index+'][montant]" value="'+montant_value+'" class="col-4 form-control" placeholder="0.00" required>'+
            '<div class="input-group-append"><div class="input-group-text">AR</div></div>'+
        '</div></div>'
    }
    function viewI(){
        var nbt=$('#tranche option:selected').data('nbt'),html='';
        for (let index = 1; index < nbt+1; index++) {
            html+=viewT(index);
        }
        $('#ctranche').html(html);
    }

    function viewU(list){
        var html='';
        list.forEach((item,index) => {
            //id num_tranche
            html+=viewTU(index+1,item.id,item.num_tranche,item.date_prevu,item.montant_prevu);
        });
        $('#ctranche').html(html);
    }
    $('#tranche').on('change',function(){
        // checkView();
        var tranche=$('#tranche').val(),au=$('#au').val(),niv=$('#niv').val();
        $('#tranche-title').html(loading);
        $.post('/DetailTranche/checkView',{'au':au,'niv':niv,'tranche':tranche},function(res){
            $('#tranche-title').html('Tranche');
            if (res.mode=='u') {
                $('#mode').val('u');
                $('#titre').html('MISE A JOUR');
                viewU(res.list);
            } else {
                $('#mode').val('i');
                $('#titre').html('INSERTION')
                viewI();
            }
            
        },'json')
        
    })
    $('#btn-filter').on('click',function(){
        if($.trim($("#ctranche").html())==''){
            $('body').info('Vous n\'avez pas de tranche inserée !');
        }
        
        var date_debut=$('#date_debut').val(),DF='YYYY-MM-DD',dd=moment(date_debut),nbt=$('#tranche option:selected').data('nbt'),
        fs_annuel=$('#niv').data('fs'),step=$('#decalage_mois option:selected').val();
        if (nbt==1) {$('#montant_initial').val(fs_annuel);}
        var montant_initial=$('#montant_initial').val();
        if (fs_annuel && montant_initial) {
            fs=parseFloat(fs_annuel);
            mi=parseFloat(montant_initial);
            mr=(fs-mi)/(nbt-1);
            mr=Math.round(mr * 100)/100;
            $('#ctranche input[type="text"]').each(function(index){
               $(this).val((index==0)?mi:mr);
            })
        }
        if (date_debut) {
            $('#ctranche input[type="date"]').each(function(){
                $(this).val(dd.format(DF));
                dd.add(step,'M');
            })
        }
    })

    $('#btn-submit').on('click',function(e){
        e.preventDefault();
        if($.trim($("#ctranche").html())==''){
            $('body').info('Vous n\'avez pas de tranche inserée !');
            return;
        }
        $('#detail_form').submit();
        
    })

    function getFS(){
        var au=$('#au').val(),niv=$('#niv').val(),sniv=$('#niv option:selected').text();
        if (au==null || niv==null) {
            $('body').info('remplir les champs au,niv et tranche svp!');
            return;
        }
        
        $('#niv-title').html(loading);
        $.post('/DetailTranche/getFS',{'au':au,'niv':niv},function(res){
            $('#niv').data('fs',res.fs);
            $('#niv-title').html(sniv+' : '+res.fs+' AR');
        },'json')
    }

    $('#au').on('change',function(){
        $('#niv-title').html('Niveau');
        $('#niv').prop('selectedIndex',-1);
    })
    
    $('#niv').on('change',function(){
        $('#ctranche').html('');
        $('#tranche').prop('selectedIndex',-1)
        getFS()
    })
})