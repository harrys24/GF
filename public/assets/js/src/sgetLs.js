$(function(){
    var iEnCours='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',sEnCours=iEnCours+'<span class="pl-2">En cours ...</span>';
    $('div.dropdown').on('click','.dropdown-menu button.dropdown-toggle', function(e) {
        if (!$(this).next().hasClass('show')) {
          $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        $(this).next(".dropdown-menu").toggleClass('show');
        $('div.dropdown.show').on('hidden.bs.dropdown', function(e) {
          $('.dropdown-submenus .show').removeClass("show");
        });
        return false;
    });

    $('#cnp').on('click','.dropdown-menu button.dropdown-item',function(){
        var item=$(this),nivt=item.text(),n=item.attr('n'),p=item.attr('p'),au=$('#cau').attr('sau');
        var params={au:au,niv:n,gp:p,abd:$('#abandon').prop('checked')};
        $('#ddniv').html(sEnCours);
        $('#cei').html('');
        $.post('/etudiant/getLsE', params,
                function(data) {
                    var edit=data.edit,res='',nbH=0,nbF=0,ls=data.list,nbE=ls.length;
                    ls.forEach(item => {
                        if (item.sexe=='1') { nbH++;} else { nbF++;}
                        res+=getView(item,edit);
                        setCM(item,data.type);
                    });
                    $('#ddniv').text(nivt);
                $('#ceih').html('<em> Efféctif <span class="text-danger">d\'étudiant trouvé</span> : '+nbE+' (<span class="text-boys"> Homme : '+nbH+'</span> , <span class="text-girls">Femme : '+nbF+'</span> )</em>');
                $('#cei').html(res);
                    
            },"json");
    })

    $('#cmigrate').on('click','.dropdown-menu button.dropdown-item',function(){
        var au=$('#cau').attr('sau'),item=$(this),ls=[];
        $('#cei input[type=checkbox]').each(function(){
            var ei=$(this);
            if (ei.prop('checked')) {
                ls.push({ne:ei.attr('id'),nm:ei.attr('nm')});
            }
        })
        var params={
            au:au,
            niv:item.attr('n'),
            gp:item.attr('p'),
            abd:$('#abandon').prop('checked'),
            list:ls
        };
        $.post('/etudiant/migrate', params,
            function(res) {
            if(res.color=='success'){
                for (const i in ls) {
                const nm = ls[i].nm;
                   $('#'+nm).remove();
                }
            }
            $(this).set_alert(res);

        },"json");
    })

    $('#cau button.dropdown-item').on('click',function(){
        $('#ceih').html('<i>Efféctifs : ?</i>');
        $('#ddau').html(sEnCours);
        $('#cei').html('');
        var aui=$(this).attr('ai'),aut=$(this).text();
        $.post('/etudiant/check_niv',{id:aui},function(res){
            var s='';
            for (const i in res) {
                const item=res[i];
                s+='<div class="dropdown-submenus">'+
                '<button class="dropdown-item dropdown-toggle">'+i+'</button>'+
                    '<div class="dropdown-menu">';
                var v='';
                if (item.length>0) {
                    for(const j in item){
                        const el=item[j];
                        v+='<button class="dropdown-item " n='+el.ni+' p='+el.pi+'>'+el.niv+' '+el.gp+'</button>';
                    }
                }else{
                    v+='<button class="dropdown-item" >vide</button>';
                }
                s+=v+'</div></div>';
            }
            $('#cau').attr('sau',aui);
            $('#ddau').text(aut);
            $('#cmigrate').html(s);
            $('#cnp').html(s);
        },'json')
    })
    
    context.init({
        preventDoubleContext: true,
        compress:false
    });

    $('#abandon').bootstrapToggle({
        on: 'ABD',
        off: 'NON ABD',
        onstyle:'danger',
        offstyle:'success',
        size:'normal',
        width:120,
        height:38

    });
    

    function abd(ei){
        $('#btn_confirm').attr('type','abd');
        $('#btn_confirm').attr('ni',ei.num_matr);
        $('#btn_confirm').attr('ne',ei.nie);
        $('#c_txt').html('<span class="text-danger">VOULEZ-VOUS VRAIMENT MARQUER CET ETUDIANT COMME ABANDON ?<span>');
        $('#cmodal').modal('show');
    }

    function del(ei){
        $('#btn_confirm').attr('type','del');
        $('#btn_confirm').attr('ni',ei.num_matr);
        $('#btn_confirm').attr('ne',ei.nie);
        $('#c_txt').html('<span class="text-danger">VOULEZ-VOUS VRAIMENT SUPPRIMER CET ETUDIANT ?<span>');
        $('#cmodal').modal('show');
    }
    
    function dlg(ei){
        $('#btn_confirm').attr('type','dlg');
        $('#btn_confirm').attr('ni',ei.num_matr);
        $('#btn_confirm').attr('ep',ei.photo);
        $('#c_txt').html('<span class="text-danger">CLIQUEZ SUR CONFIRMER POUR GENERER UN COMPTER DELEGUE.<span>');
        $('#cmodal').modal('show');

    }
    $('#btn_confirm').click(function(){
        //add compte delegue
        var type=$(this).attr('type');
        var el=$(this).attr('ni');
        switch (type) {
            case 'dlg':
                $.post('/delegues/generateCmp',{ni:$(this).attr('ni'),ep:$(this).attr('ep')},
                    function(res){
                        $('#cmodal').modal('hide');
                        $(this).set_alert(res);
                },'json');
                break;

                case 'abd':
                $.post('/Etudiant/setABD',{ne:$(this).attr('ne')},
                    function(res){
                        $('#cmodal').modal('hide');
                        if (res.color=='success') {$('#'+el).remove();}
                        $(this).set_alert(res);
                },'json');
                break;

                case 'del':
                $.post('/Etudiant/Delete',{ni:$(this).attr('ni'),ne:$(this).attr('ne')},
                    function(res){
                        $('#cmodal').modal('hide');
                        if (res.color=='success') {$('#'+el).remove();}
                        $(this).set_alert(res);
                },'json');
                break;
        }
    })

    $('#cmodal').on('hidden.bs.modal',function(e){
        $('#c_txt').html('');
        $('#btn_confirm').removeAttr('ni').removeAttr('ne').removeAttr('ep');
    })
    
    function getView(ei,edit){
        var sedit=(edit=='true')?'<a class="btn btn-sm btn-outline-warning" target="_blank" href="/Etudiant/View/'+ei.num_matr+'"><svg><use xlink:href="/assets/svg/list.svg#edit"></svg></a>':'';
        if (ei.photo==null) {
            ei.photo=(ei.sexe=='1')?'boys.png':'girls.png';
        }
        ei.fb=(ei.fb==null || ei.fb=='')?'':'<a class="text-'+ei.color+' ml-2" href="'+ei.fb+'" target="_blank"><svg><use xlink:href="/assets/svg/list.svg#fbs"></svg></a>';
        ei.email=(ei.email==null || ei.email=='')?'':'<a class="text-'+ei.color+'" href="mailto:'+ei.email+'"><svg><use xlink:href="/assets/svg/list.svg#mail"></svg></a>';
        
        return '<div class="ei shadow-sm" id='+ei.num_matr+'>'+
        '<div class="row no-gutters">'+
            '<div class="eig col-5">'+
            '<img src="/assets/images/students/'+ei.photo+'" class="eii" alt="Photo récent non disponible">'+
            '<div class="eigc" >'+
                '<div class="text-muted ml-2 mt-1"><span class="badge badge-secondary">'+ei.nom_niv+'-'+ei.nom_gp+'</span></div>'+
                '<div style="z-index:2">'+
                '<div class="eigf fr px-1">'+
                    '<div><span class="badge badge-'+ei.color+'">'+ei.age+'</span> <span class="txt-age">ans</span></div>'+
                    '<div class="ml-auto">'+ei.email+'</div>'+
                    '<div>'+ei.fb+'</div>'+
                '</div>'+
                '</div>'+
            '</div>'+
            '</div>'+
            '<div class="col-7 px-1">'+
            '<div class="fc" style="height:170px;">'+
                '<div class="fr mt-1 mr-1">'+
                
                '<div class="cne mr-auto"><label for="'+ei.nie+'">'+ei.nie+'</label></div>'+
                '<div><input type="checkbox" name="" id="'+ei.nie+'" nm="'+ei.num_matr+'"></div>'+
                '</div>'+
                '<div class="text-break cnp">'+
                '<span class="text-'+ei.color+'">'+ei.nom+'</span>'+
                '<span class="text-muted"> '+ei.prenom+'</span>'+
                '</div>'+
                '<div class="mt-auto fr align-items-end pb-1">'+
                '<div class="cf text-muted">Le : '+ei.dateInscr+'</br>'+ei.posteRec+' - '+ei.dateRec+'</div>'+
                '<div class="ml-auto btn-group">'+sedit+
                '<a class="btn btn-sm btn-outline-'+ei.color+'" target="_blank" href="/Liste/View/'+ei.num_matr+'"><svg><use xlink:href="/assets/svg/list.svg#eye"></svg></a></div>'+
                '</div>'+
            '</div>'+
            '</div>'+
        '</div>'+
        '</div>';
    }

    $('#abandon').change(function(){
        $('#txt_search').val('');
        $('#cei').html('');
    })

    $('#cei').click(function(){
        $('#cm').css('display','none');
    })

    function setCM(ei,type) {
        switch (type) {
            case 'job_etudiant':
                datac=[
                    {header: 'ACTIONS '+ei.nie},
                    {text: '<b class="text-primary">Voir</b>', href:'/Liste/View/'+ei.num_matr,target:'_blank'},
                    {text: '<b class="text-warning">Editer</b>', href:'/Etudiant/View/'+ei.num_matr,target:'_blank'},
                    {text: 'Telecharger l\'image ', href:'/assets/images/students/'+ei.photo},
                    {divider:true},
                    {text: 'Reinscription', href:'/Reinscription/Etudiant/'+ei.nie,target:'_blank'},                                
                ];
                break;
            case 'guest':
                datac=[
                    {header: 'ACTIONS '+ei.nie},
                    {text: '<b class="text-primary">Voir</b>', href:'/Liste/View/'+ei.num_matr,target:'_blank'},
                    {text: 'Telecharger l\'image ', href:'/assets/images/students/'+ei.photo},
                ];
                break;
            default:
                datac=[
                    {header: 'ACTIONS '+ei.nie},
                    {text: '<b class="text-primary">Voir</b>', href:'/Liste/View/'+ei.num_matr,target:'_blank'},
                    {text: '<b class="text-warning">Editer</b>', href:'/Etudiant/View/'+ei.num_matr,target:'_blank'},
                    {text: 'Telecharger l\'image ', href:'/assets/images/students/'+ei.photo},
                    {text: 'Nommer DELEGUES', action:function(e){e.preventDefault(); dlg(ei);}},
                    {text: 'Marquer comme ABANDON', action:function(e){e.preventDefault(); abd(ei);}},
                    {divider:true},
                    {text: 'Reinscription', href:'/Reinscription/Etudiant/'+ei.nie,target:'_blank'},
                    {text: 'Supprimer', action:function(e){e.preventDefault(); del(ei);}}
                    
                ];
                break;
        }
        context.attach('#'+ei.num_matr,datac);
    }
    
    $('#form_search').on('submit',function(e){
        e.preventDefault();
        var au=$('#cau').attr('sau');
        var txt=$(this).find('input:text').val();
        if (au) {
            var params={
                au:au,
                abd:$('#abandon').prop('checked'),
                by:$('#filter_search').val(),
                txt:txt
            };
            if (txt=='') {
                $(this).set_alert({color:'warning',message:'Vous devez taper le mot à rechercher'});
                return;
            }
            $('#cei').html('');
            $('#btn_search').html(iEnCours);
            $.post('/etudiant/getLs4E', params,
                function(data) {
                    var edit=data.edit,res='',nbH=0,nbF=0,ls=data.list,nbE=ls.length;
                    ls.forEach(item => {
                        if (item.sexe=='1') { nbH++;} else { nbF++;}
                        res+=getView(item,edit);
                        setCM(item,data.type);
                    });
                $('#btn_search').html('<svg width="16px" height="16px"><use xlink:href="/assets/svg/search.svg#data"></svg>');
                $('#ceih').html('<em> Efféctif <span class="text-danger">d\'étudiant trouvé</span> : '+nbE+' (<span class="text-boys"> Homme : '+nbH+'</span> , <span class="text-girls">Femme : '+nbF+'</span> )</em>');
                $('#cei').html(res);
                    
            },"json");
        }else{

            $(this).set_alert({color:'warning',message:'Vous devez choisir l\'année universitaire'});
        }
        
    });


    $('#btnSelectAll').click(function(){
        $('#cei input[type=checkbox]').prop('checked',true);
    })

    $('#btnUnselectAll').click(function(){
        $('#cei input:checked').prop('checked',false);
    })

   

    
})

