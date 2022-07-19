$(function(){
    $('#au').prop('selectedIndex',-1);
    $('#niv').prop('selectedIndex',-1);
    $('#tranche').prop('selectedIndex',-1);
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
    function checkView(){
        var date_debut=$('#date_debut').val(),fs_annuel=$('#niv').data('fs'),nbt=$('#tranche option:selected').data('nbt');
        if (nbt==1) {
            $('#montant_initial').val(fs_annuel);
        }
        var montant_initial=$('#montant_initial').val(),step=$('#decalage_mois option:selected').val(),
        html='';
        var DF='YYYY-MM-DD';
        var dd=moment(date_debut),mi,fs,mr;
        if (fs_annuel && montant_initial) {
            fs=parseFloat(fs_annuel);
            mi=parseFloat(montant_initial);
            mr=(fs-mi)/(nbt-1);
            mr=Math.round(mr * 100)/100;
        }else{$('body').info('Vous n\'avez pas saisissé le 1er montant !');}
        for (let index = 1; index < nbt+1; index++) {
            let montant=(index==1)?montant_initial:mr
            html+=viewT(index,dd.format(DF),montant);
            dd.add(step,'M');
        }
        $('#ctranche').html(html);
    }
    $('#tranche').on('change',function(){
        checkView();
        
    })
    $('#date_debut').on('change',function(){
        checkView();
    })
    $('#montant_initial').on('change',function(){
        checkView();
    })

    $('#decalage_mois').on('change',function(){
        checkView();
    })

    $('#detail_form button:submit').on('click',function(e){
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
        var loading='<i class="spinner-grow spinner-grow-sm text-primary" role="status"></i>';
        $('#niv-title').html(loading);
        $.post('/detail_tranche/getFS',{'au':au,'niv':niv},function(res){
            console.log(res);
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