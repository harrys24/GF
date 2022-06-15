$(function(){
    var matsM=$('#matsModal'),matsBtnSave=$('#matsBtnSave'),nom_mat=$('#nom_mat'),code_mat=$('#code_mat');
    function initMats(){
        nom_mat.val('');
        code_mat.val('');
        matsBtnSave.data('type','a').removeData('id');
    }
    matsM.on('hidden.bs.modal', function (e) {
        $(this).find('input:text').val('');
    })
    matsBtnSave.data('type','a');
    $('#matsBtnAdd').on('click',function(){
        initMats();
    })
   
    $('#matsForm').on('submit',function(e){
        e.preventDefault();
        var type=matsBtnSave.data('type'),
        params='type='+type+'&';
        params+=(type=='u')?'idMAT='+matsBtnSave.data('id')+'&':'';
        params+=$(this).serialize();
        $('#matIco').addClass('fas fa-spinner fa-pulse');
        $.post('/Matieres/matsCheck',params,function(res){
            $('#matIco').removeClass('fas fa-spinner fa-pulse');
            $(this).set_alert(res,'#matsFD');
            if (res.status=='u') {
                var c=$('#mats'+matsBtnSave.data('id'));
                c.find(':nth-child(2)').text(nom_mat.val());
                c.find(':nth-child(3)').text(code_mat.val());
                initMats();
                return;
            }
            if (res.lastId!==undefined) {
                 var s='<tr id="mats'+res.lastId+'">'+
                  '<th scope="row" data-id="'+res.lastId+'">-</th>'+
                  '<td>'+nom_mat.val()+'</td>'+
                  '<td>'+code_mat.val()+'</td>'+
                  '<td class="text-center"><button class="btn btn-sm btn-outline-warning btn-edit"><svg><use xlink:href="/assets/svg/scrud.svg#edit"></svg></button></td>'+
                  '<td class="text-center"><button class="btn btn-sm btn-outline-danger btn-del"><svg><use xlink:href="/assets/svg/scrud.svg#delete"></svg></button></td>'+
                '</tr>';
                $('#matsCei').prepend(s);
                initMats();
                
            }

        },'json')
    })
    $('#matsCei').on('click','.btn-edit',function(){
        var parent=$(this).parent().parent();
        nom_mat.val(parent.find(':nth-child(2)').text());
        code_mat.val(parent.find(':nth-child(3)').text());
        matsBtnSave.data({type:'u',id:parent.find(':first-child').data('id')});
    })
    $('#matsCei').on('dblclick','.btn-del',function(){
        var parent=$(this).parent().parent(),id=parent.find(':first-child').data('id');
        $.post('/Matieres/matsDelete',{id:id},function(res){
            $(this).set_alert(res,'#matsFD');
            parent.remove();
        },'json')
    })
//----------------------------------------------------------------------------
    var ueM=$('#ueModal'),ueBtnSave=$('#ueBtnSave'),nom_ue=$('#nom_ue'),titre_ue=$('#titre_ue');
    function initUe(){
        nom_ue.val('');
        titre_ue.val('');
        ueBtnSave.data('type','a').removeData('id');
    }
    titre_ue.prop('disabled',true);
    ueM.on('hidden.bs.modal', function (e) {
        $(this).find('input:text').val('');
    })
    ueBtnSave.data('type','a');
    $('#ueBtnAdd').on('click',function(){
        initUe();
        $.post('Matieres/generateTitre',function(res){
            $('#titre_ue').val(res);
        })
    })

    $('#ueForm').on('submit',function(e){
        e.preventDefault();
        var type=ueBtnSave.data('type'),
        params='type='+type+'&';
        params+=(type=='u')?'idUE='+ueBtnSave.data('id')+'&':'';
        params+='titre_ue='+titre_ue.val()+'&nom_ue='+nom_ue.val();
        console.log(params);
        $('#matIco').addClass('fas fa-spinner fa-pulse');
        $.post('/Matieres/ueCheck',params,function(res){
            $('#matIco').removeClass('fas fa-spinner fa-pulse');
            $(this).set_alert(res,'#ueFD');
            if (res.status=='u') {
                var c=$('#ue'+ueBtnSave.data('id'));
                c.find(':nth-child(2)').text(titre_ue.val());
                c.find(':nth-child(3)').text(nom_ue.val().toUpperCase());
                initUe();
                return;
            }
            if (res.lastId!==undefined) {
                console.log('lastId:'+res.lastId);
                var s='<tr id="ue'+res.lastId+'">'+
                '<th scope="row" data-id="'+res.lastId+'">-</th>'+
                '<td>'+titre_ue.val()+'</td>'+
                '<td>'+nom_ue.val().toUpperCase()+'</td>'+
                '<td class="text-center"><button class="btn btn-sm btn-outline-warning btn-edit"><svg><use xlink:href="/assets/svg/scrud.svg#edit"></svg></i></button></td>'+
                '<td class="text-center"><button class="btn btn-sm btn-outline-danger btn-del"><svg><use xlink:href="/assets/svg/scrud.svg#delete"></svg></button></td>'+
                '</tr>';
                $('#ueCei').prepend(s);
                initUe();
                
            }

        },'json')
    })
    $('#ueCei').on('click','.btn-edit',function(){
        var parent=$(this).parent().parent();
        titre_ue.val(parent.find(':nth-child(2)').text());
        nom_ue.val(parent.find(':nth-child(3)').text());
        ueBtnSave.data({type:'u',id:parent.find(':first-child').data('id')});
    })
    $('#ueCei').on('dblclick','.btn-del',function(){
        var parent=$(this).parent().parent(),id=parent.find(':first-child').data('id');
        $.post('/Matieres/ueDelete',{id:id},function(res){
            $(this).set_alert(res,'#ueFD');
            parent.remove();
        },'json')
    })
//----------------------------------------------------------------------------
    function initSexe(){
        $('#sexe_pr').bootstrapToggle({
            on: 'Homme',off: 'Femme',onstyle:'boys',offstyle:'girls',width:100
        });
    }

    function initProf(){
        nom_pr.val('');
        prenom_pr.val('');
        profBtnSave.data('type','a').removeData('id');
        sexe_pr.bootstrapToggle('off');
        contacte_pr.val('');
        email_pr.val('');
        gr_id.prop('selectedIndex',-1);
    }

    var profM=$('#profModal'),profBtnSave=$('#profBtnSave'),nom_pr=$('#nom_pr'),prenom_pr=$('#prenom_pr'),sexe_pr=$('#sexe_pr'),
    contacte_pr=$('#contacte_pr'),email_pr=$('#email_pr'),gr_id=$('#GR_id');
    initSexe();
    $('#GR_id').prop('selectedIndex',-1);
    profM.on('hidden.bs.modal', function (e) {
        sexe_pr.bootstrapToggle('off');
        $(this).find('input').val('');
    })
    profBtnSave.data('type','a');
    $('#profBtnAdd').on('click',function(){
        initProf();
    })
    
    $('#profForm').on('submit',function(e){
        e.preventDefault();
        var type=profBtnSave.data('type'),
        params='type='+type+'&';
        params+=(type=='u')?'idPR='+profBtnSave.data('id')+'&':'';
        params+=$(this).serialize();
        $('#matIco').addClass('fas fa-spinner fa-pulse');
        $.post('/Matieres/profCheck',params,function(res){
            $('#matIco').removeClass('fas fa-spinner fa-pulse');
            $(this).set_alert(res,'#profFD');
            var sexe=(sexe_pr.prop('checked'))?'H':'F';
            if (res.status=='u') {
                var c=$('#prof'+profBtnSave.data('id'));
                c.find(':nth-child(2)').text(nom_pr.val().toUpperCase());
                c.find(':nth-child(3)').text(prenom_pr.val());
                c.find(':nth-child(4)').text(sexe);
                c.find(':nth-child(5)').text(contacte_pr.val());
                c.find(':nth-child(6)').text(email_pr.val());
                initProf();
                return;
            }
            if (res.lastId!==undefined) {
                console.log('lastId:'+res.lastId);
                 var s='<tr id="prof'+res.lastId+'">'+
                  '<th scope="row" data-id="'+res.lastId+'">-</th>'+
                  '<td>'+nom_pr.val()+'</td>'+
                  '<td>'+prenom_pr.val()+'</td>'+
                  '<td>'+sexe+'</td>'+
                  '<td>'+contacte_pr.val()+'</td>'+
                  '<td>'+email_pr.val()+'</td>'+
                  '<td class="text-center"><button class="btn btn-sm btn-outline-warning btn-edit"><svg><use xlink:href="/assets/svg/scrud.svg#edit"></svg></button></td>'+
                  '<td class="text-center"><button class="btn btn-sm btn-outline-danger btn-del"><svg><use xlink:href="/assets/svg/scrud.svg#delete"></svg></button></td>'+
                '</tr>';
                $('#profCei').prepend(s);
                initProf();
                
            }
    
        },'json')
    })
    $('#profCei').on('click','.btn-edit',function(){
        var parent=$(this).parent().parent(),frst=parent.find(':first-child');
        nom_pr.val(parent.find(':nth-child(2)').text());
        prenom_pr.val(parent.find(':nth-child(3)').text());
        sexe_pr.bootstrapToggle((parent.find(':nth-child(4)').text()=='H')?'on':'off');
        contacte_pr.val(parent.find(':nth-child(5)').text());
        email_pr.val(parent.find(':nth-child(6)').text());
        $('#GR_id option[value="'+frst.data('gr')+'"]').prop('selected',true);
        profBtnSave.data({type:'u',id:frst.data('id')});
    })
    $('#profCei').on('dblclick','.btn-del',function(){
        var parent=$(this).parent().parent(),id=parent.find(':first-child').data('id');
        $.post('/Matieres/profDelete',{id:id},function(res){
            $(this).set_alert(res,'#profFD');
            parent.remove();
        },'json')
    })

    //---------------------------------------------------------------------------
    var attrMatsM=$('#attrMatsModal'),lsProf;
    $.getJSON('/matieres/getListProf',function(res){
        lsProf=res;
    })
    attrMatsM.on('hidden.bs.modal', function (e) {
        $('#ceii').html('');
        $('#attrMatsFD').html('');
        $(this).find(':input').val('').prop('selectedIndex',-1);
        $('#txtUE').removeData();
        $('#txtMat').removeData();
    })
    function initAttrMats(){
        $('#au').prop('selectedIndex',-1);
        $('#niv').prop('selectedIndex',-1);
        $('#tm').prop('selectedIndex',-1);
        $('#nb').prop('selectedIndex',-1);
    }
    initAttrMats()
    $.typeahead({
        input:'#txtMat',
        minLength:3,
        maxItem:20,
        order:'asc',
        display:['value'],
        template:'{{value}}',
        // hint:true,
        searchOnFocus: true,
        // blurOnTab: false,
        emptyTemplate: 'Aucun résultat trouvé : {{query}}',
        source: {
           matiere:{
               ajax:{
                   type:'POST',
                   url:'/matieres/getListMat',
               }
           }
        },
        debug: true,
        callback: {
            onClick: function (node,res,sel,u) {node.data('id',sel.id);}
        }
    });
    $.typeahead({
        input:'#txtUE',
        minLength:3,
        maxItem:20,
        order:'asc',
        display:['value'],
        template:'{{value}}',
        // hint:true,
        searchOnFocus: true,
        // blurOnTab: false,
        emptyTemplate: 'Aucun résultat trouvé : {{query}}',
        source: {
           ue:{
               ajax:{
                   type:'POST',
                   url:'/matieres/getListUE',
               }
           }
        },
        debug: true,
        callback: {
            onClick: function (node,res,sel) { node.data('id',sel.id);}
        }
    });
    function setTH(id){
        $.typeahead({
            input:id,
            minLength:3,
            maxItem:20,
            order:'asc',
            display:['fullname'],
            template:'{{fullname}}',
            // hint:true,
            searchOnFocus: true,
            // blurOnTab: false,
            emptyTemplate: 'Aucun résultat trouvé : {{query}}',
            source: {
               matiere:{
                   data:lsProf
               }
            },
            debug: true,
            callback: {
                onClick: function (node,res,sel,u) {node.data('id',sel.id);} 
            }
        });
    }
    //---------------------------------------------------------------------------
   
    var gp,sem,sgp,ssem;
    $('#au').on('change',function(){
        $('#niv').prop('selectedIndex',-1);
        $('#nb').prop('selectedIndex',-1);
        $('#ceii').html('');
    });
    $('#attr_au').on('change',function(){
        $('#attr_niv').prop('selectedIndex',-1);
        $('#attr_gp').prop('selectedIndex',-1).html('');
    });

    $('#niv').on('change',function(){
        sgp='';ssem='';$('#nb').prop('selectedIndex',-1);$('#ceii').html('');
        var au=$('#au option:selected').val();
        var niv=$(this).find("option:selected").val();
        if(au!=null && niv!=null){
          $.post('/Matieres/getListBy',{iau:au,iniv:niv},function(data){
            gp=data.gp;
            sem=data.sem;
            for(var i in gp){
              sgp+='<option value="'+gp[i].igp+'">'+gp[i].gp+'</option>';
            }
            for(var i in sem){
                ssem+='<option value="'+sem[i].idSEM+'">'+sem[i].nom_sem+'</option>';
            }
            $(this).set_alert({color:'info',message:'informations bien chargée !'},'#attrMatsFD');
          },'json');
        }else{
          $(this).set_alert({color:'warning',message:'Veuillez choisir l\'année universitaire puis le niveau !'},'#attrMatsFD');
        }
      
    });

    $('#nb').on('change',function(){
        var nb=parseInt($(this).find(':selected').val()),s='',isChecked=$('#toggle-one').prop('checked');
        for (let i = 1; i <= nb; i++) {
            s+=getView(i,isChecked);
        }
        $('#ceii').html(s);
        for (let i = 1; i <= nb; i++) {
            var id='#txtProf'+i;setTH(id);
        }
        $('#ceii :input').prop('selectedIndex',-1)
    
    })

    function resetAttrMatFrm(){
        $('#ceii').html('');
        $('#txtUE').val('');
        $('#txtMat').val('');
        $('#au').prop('selectedIndex',-1);
        $('#niv').prop('selectedIndex',-1);
        $('#nb').prop('selectedIndex',-1);
        $('#type_mat').prop('selectedIndex',-1);
    }

    $('#attrMatsBtnAdd').on('click',function(){
        resetAttrMatFrm();
    })

    
    function getView(i,isChecked){
        var cr='';
        if(isChecked){
            cr= '<div class="col-8 col-md-6 col-lg-2 pl-lg-2">'+
            '<div class="input-group form-group">'+
            '<div class="input-group-prepend"><div class="input-group-text">CREDIT</div></div>'+
            '<input type="number" id="crd'+i+'" class="form-control" required></div></div>';
        }
        return '<div class="row no-gutters p-2" style="border-top:1px solid gray;background-color:#efefef"><div class="col-md-6 col-lg-2">'+
            '<div class="input-group form-group">'+
            '<div class="input-group-prepend"><div class="input-group-text">EN</div></div>'+
            '<select id="gp'+i+'" class="form-control" required>'+sgp+'</select>'+
        '</div></div>'+
        '<div class="col-md-6 col-lg-3 pl-md-2">'+
            '<div class="input-group form-group">'+
            '<div class="input-group-prepend"><div class="input-group-text">Semestre</div></div>'+
            '<select id="sem'+i+'" class="form-control" required>'+ssem+'</select>'+
        '</div></div>'+cr+
        '<div class="col-lg-5 pl-md-2">'+
            '<div class="typeahead__container">'+
            '<div class="typeahead__field">'+
                '<div class="typeahead__query input-group">'+
                '<div class="input-group-prepend"><div class="input-group-text">Enseignant</div></div>'+
                '<input id="txtProf'+i+'" class="form-control" placeholder="Tapez ici ..." autocomplete="off" required>'+
                '<div class="input-group-append"><div class="input-group-text px-3"></div></div>'+
        '</div></div></div></div></div>';
    }

    $('#toggle-one').bootstrapToggle({
        on:'Avec UE/Crédit',
        off:'Sans UE/Crédit',
        onstyle:'primary',
        offstyle: 'danger',
        width:260,height:36
    });

    $('#toggle-one').change(()=>{
        $('#ceii').html('');
        $('#nb').prop('selectedIndex',-1);
        var isChecked=$('#toggle-one').prop('checked');
        if (!isChecked) {
            $('#type_mat').prop('required',false);
            $('#txtUE').prop('required',false);
            $('#cAttrMatsType').hide();
            $('#cAttrMatsUE').hide();
        } else {
            $('#type_mat').prop('required',true);
            $('#txtUE').prop('required',true);
            $('#cAttrMatsType').show();
            $('#cAttrMatsUE').show();
            
        }
    })

    $('#attr_au').prop('selectedIndex',-1);
    $('#attr_niv').prop('selectedIndex',-1);
    $('#type_mat').prop('selectedIndex',-1);
    $('#attrMatsForm').on('submit',function(e){
        e.preventDefault();
        var nb=parseInt($('#nb').val()),list=[];
        var isChecked=$('#toggle-one').prop('checked');
        if (!isChecked) {
           for (let i = 1; i <= nb; i++) {
               var item={GP_id:$('#gp'+i).val(),SEM_id:$('#sem'+i).val(),PR_id:$('#txtProf'+i).data('id')};
               list.push(item);
           }
           var params={AU_id:$('#au').val(),NIV_id:$('#niv').val(),MAT_id:$('#txtMat').data('id'),nb:nb,list:list};
           $.post('/Matieres/attrAutrMatsCheck',params,function(res){
               $(this).set_alert(res,'#attrMatsFD');
               if(res.response=='ok'){
                   resetAttrMatFrm();
               }
           },'json');
        } else {
            for (let i = 1; i <= nb; i++) {
                var item={GP_id:$('#gp'+i).val(),SEM_id:$('#sem'+i).val(),credit:$('#crd'+i).val(),PR_id:$('#txtProf'+i).data('id')};
                list.push(item);
            }
            var params={AU_id:$('#au').val(),NIV_id:$('#niv').val(),TM_id:$('#type_mat').val(),UE_id:$('#txtUE').data('id'),MAT_id:$('#txtMat').data('id'),nb:nb,list:list};
            $.post('/Matieres/attrMatsCheck',params,function(res){
                $(this).set_alert(res,'#attrMatsFD');
                if(res.response=='ok'){
                    resetAttrMatFrm();
                }
            },'json');
        }
    })

    $('#attr_niv').on('change',function(){
        var au=$('#attr_au option:selected').val();
        var niv=$(this).find("option:selected").val();
        if(au!=null && niv!=null){
            $.post('/Matieres/getCheckFilter',{iau:au,iniv:niv},function(res){
                var sres='',ssem='',gp=res.gp,sem=res.sem;
                for(var i in gp){
                    sres+='<option value="'+gp[i].igp+'">'+gp[i].gp+'</option>';
                }
                for(var i in sem){
                    ssem+='<option value="'+sem[i].idSEM+'">'+sem[i].nom_sem+'</option>';
                }
                $('#attr_gp').html(sres);
                $('#attr_sem').html(ssem);
            },'json')

        }else{
            $(this).set_alert({color:'warning',message:'Veuillez choisir l\'année universitaire puis le niveau !'},'#attrMatsFD');
        }
    });

    $('#attr_btn_filter').on('click',function(){
        var au=$('#attr_au option:selected').val(),
        niv=$('#attr_niv').find("option:selected").val(),
        au=$('#attr_au').find("option:selected").val(),
        gp=$('#attr_gp').find("option:selected").val(),
        sem=$('#attr_sem').find("option:selected").val();
        if(au!=null && niv!=null && gp!=null && sem!=null){
            var params={iau:parseInt(au),iniv:parseInt(niv),igp:parseInt(gp),isem:parseInt(sem)};
            $.post('/Matieres/findByFilter',params,function(res){
                var s='',as='';
                $('#attrMatsCei').data(params);
                res.mats.forEach((item,index) => {
                    s+='<tr><td data-type="a" data-ipr="'+item['ipr']+'" data-imat="'+item['imat']+'" data-iue="'+item['iue']+'">'+(index+1)+'</td>'+
                    '<td>'+item['due']+'</td>'+
                    '<td>'+item['nom_mat']+'</td>'+
                    '<td>'+item['nom_type']+'</td>'+
                    '<td>'+item['credit']+'</td>'+
                    '<td>'+item['np_pr']+'</td>'+
                    '<td class="text-center"><button class="btn btn-sm btn-outline-danger btn-del"><svg><use xlink:href="/assets/svg/scrud.svg#delete"></svg></button></td>'+
                    '</tr>';
                });
                res.aut_mats.forEach((item,index) => {
                    as+='<tr><td data-type="b" data-ipr="'+item['ipr']+'" data-imat="'+item['imat']+'">'+(index+1)+'</td>'+     
                    '<td>'+item['nom_mat']+'</td>'+
                    '<td>'+item['np_pr']+'</td>'+
                    '<td class="text-center"><button class="btn btn-sm btn-outline-danger btn-del"><svg><use xlink:href="/assets/svg/scrud.svg#delete"></svg></button></td>'+
                    '</tr>';
                });
                $('#attrMatsCei').html(s);
                $('#attrAutMatsCei').html(as);
            },'json')

        }else{
            $(this).set_alert({color:'warning',message:'Veuillez à bien remplir les champs pour filter vos données !'},'#attrMatsFD');
        }
    });

    $('.cAttrMatrTB').on('dblclick','.btn-del',function(){
        var parent=$(this).parent().parent(),cp=parent.find(':first-child').data(), 
        p=$('#attrMatsCei').data();
        console.log(cp);
        $.post('/Matieres/AttrMatsDelete',{p,cp},function(res){
            $(this).set_alert(res,'#attrMatsFD');
            parent.remove();
        },'json')
    })

    





})

