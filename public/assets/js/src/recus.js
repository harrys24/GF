$(function(){
    toastr.info('informations bien chargés !');
    var spinner = $('#spin-save');
    $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
    $('#ajout').on("click", function(){
        initModal();
        var modal = $("#modalRecus"), date = $.datepicker.formatDate('dd M yy', new Date()), heure= new Date().getHours()+':'+new Date().getMinutes(); 
        modal.modal({backdrop: 'static', keyboard: false});
        $("#date").html(date);
        $("#heure").html(heure);
    });

    $('#btnRecherche').on('click', function(){
        var txt = $('#recherche').val();
        if(txt.length != 10){
            toastr.error('Veuillez vérifier le NIE !');
        }else{
            $(this).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span>`);
            $.post('/finance/findByNie', {txt:txt}, function(res){
                var recu = res, tr = '';
                for(i in recu){
                    var cls = recu[i].annul_recu == 1 ? 'bg-annul text-light' : '';
                    tr += '<tr class="'+cls+'"><td>'+(parseInt(i)+1)+'</td><td>'+recu[i].NIE+'</td><td>'+recu[i].nom+'</td><td>'+recu[i].prenom+'</td><td>'+(recu[i].nom_niv+""+recu[i].nom_gp)+'</td><td>'+($.date(new Date(recu[i].date_heure)))+'</td><td>'+format(parseFloat(recu[i].montant).toFixed(2))+' Ar</td><td class="d-flex justify-content-around flex-lg-row flex-column"><button class="btn btn-outline-warning btn-warning btn-light" id="modif" data-idr='+recu[i].idR+'><i class="bi bi-pen"></i></button><a href="./print/'+recu[i].idR+'" target="_blank" class="btn btn-outline-admin btn-light mt-lg-0 mt-1"><i class="bi bi-printer"></i></a></td></tr>';
                }
                $('#tbody').html(tr);
                $('#btnRecherche').html('<i class="bi bi-search"></i>');
                toastr.info('Informations bien chargé !')
            }, 'JSON');

        }
    })

    function initModal(){
        $('#nie').val('');
        $('#nom').val('');
        $('#prenom').val('');
        $('#niveau').val('');  
        $('#montant').val('');
        $('#reste').val('');
        $('#mode').val('ESP').change();
        $('#designation').val('F.S');
        $('#signataire').val('AD01-SPDE').change();
        $('#designationTxt').addClass('d-none');
        $('#signataireTxt').addClass('d-none');
        $('#divNum').addClass('d-none');
        $('#divRef').addClass('d-none');
        $('#divChq').addClass('d-none');
        $('#save').attr('data-modif', '');
        $('#save').removeAttr('disabled');
        spinner.addClass('d-none');
    }

    $('#designation').on('change', function(){
        var val = $(this).val();
        if(val == 'autre'){
            $('#designationTxt').removeClass('d-none');
        }else{
            $('#designationTxt').addClass('d-none');
        }
    })
    $('#signataire').on('change', function(){
        var val = $(this).val();
        if(val == 'autre'){
            $('#signataireTxt').removeClass('d-none');
        }else{
            $('#signataireTxt').addClass('d-none');
        }
    })

    $(document).on("keypress", "#nie", function(e){
        if(e.which == 13){
            $('#searchNie').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            if($('#nie').val().length != 10){
                toastr.error('Veuillez vérifier le NIE !');
                $('#searchNie').html('<i class="bi bi-search"></i>');
            }else{
                $.post('/finance/getStudent',{nie:$('#nie').val()}, function(res){
                    if(res.etudiant.length == 0){
                        initModal();
                        toastr.warning('Etudiant introuvable !');
                    }else{
                        $('#nom').val(res.etudiant[0].nom);
                        $('#prenom').val(res.etudiant[0].prenom);
                        $('#niveau').val(res.etudiant[0].nom_niv+''+res.etudiant[0].nom_gp);
                        $('#save').attr('data-matr', res.etudiant[0].num_matr)
                        toastr.info('informations bien chargés !');
                    }
                    $('#searchNie').html('<i class="bi bi-search"></i>');
                }, 'JSON')
            }
        }
      });
    $.date = function(dateObject) {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        var hours = d.getHours();
        var i = d.getMinutes();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        // var date = day + "/" + month + "/" + year+" "+hours+":"+i;
        var date = day + "/" + month + "/" + year;
    
        return date;
    }
    $('#filtre').on('change', function(){
        var filtre = $(this).val();
        $("#recherche").val('');
        $.post('/finance/filtreRecu', {filtre:filtre}, function(res){
            var recu = res.recu, tr = '';
            for(i in recu){
                var cls = recu[i].annul_recu == 1 ? 'bg-annul text-light' : '';
                var c = recu[i].annul_recu == 1 ? 'btn-secondary' : 'btn-outline-admin btn-light';
                var onclick = recu[i].annul_recu == 1 ? 'return false;' : '';
                var style = recu[i].annul_recu == 1 ? 'pointer-events: none;cursor: default;' : '';
                if(res.type == "devmaster"){
                    tr += '<tr class="'+cls+'"><td>'+(parseInt(i)+1)+'</td><td>'+recu[i].NIE+'</td><td>'+recu[i].nom+'</td><td>'+recu[i].prenom+'</td><td>'+(recu[i].nom_niv+""+recu[i].nom_gp)+'</td><td class="text-center">'+($.date(new Date(recu[i].date_p)))+'</td><td>'+format(parseFloat(recu[i].montant).toFixed(2))+' Ar</td><td>'+format(parseFloat(recu[i].reste).toFixed(2))+' Ar</td><td>'+recu[i].mode+'</td><td class="d-flex justify-content-around flex-lg-row flex-column"><button class="btn btn-outline-warning btn-warning btn-light" id="modif" data-idr='+recu[i].idR+'><i class="bi bi-pen"></i></button><button class="btn btn-outline-danger btn-light" id="delete" data-idr="'+recu[i].idR+'"><i class="bi bi-trash"></i></button><a onclick="'+onclick+'" style="'+style+'" href="./print/'+recu[i].idR+'" target="_blank" class="btn '+c+' mt-lg-0 mt-1"><i class="bi bi-printer"></i></a></td></tr>';
                }else{
                    tr += '<tr class="'+cls+'"><td>'+(parseInt(i)+1)+'</td><td>'+recu[i].NIE+'</td><td>'+recu[i].nom+'</td><td>'+recu[i].prenom+'</td><td>'+(recu[i].nom_niv+""+recu[i].nom_gp)+'</td><td class="text-center">'+($.date(new Date(recu[i].date_p)))+'</td><td>'+format(parseFloat(recu[i].montant).toFixed(2))+' Ar</td><td>'+format(parseFloat(recu[i].reste).toFixed(2))+' Ar</td><td>'+recu[i].mode+'</td><td class="d-flex justify-content-around flex-lg-row flex-column"><button class="btn btn-outline-warning btn-warning btn-light" id="modif" data-idr='+recu[i].idR+'><i class="bi bi-pen"></i></button><a onclick="'+onclick+'" style="'+style+'" href="./print/'+recu[i].idR+'" target="_blank" class="btn '+c+' mt-lg-0 mt-1"><i class="bi bi-printer"></i></a></td></tr>';
                }
            }
            if(filtre == 'now'){
                $('#totalNow').html(format(res.total[0].montant));
            }else{
                $('#totalNow').html("??");
            }
            toastr.info('informations bien chargés !')
            $('#tbody').html(tr);
        },'JSON')
    })

    $("#tbody").on('dblclick','#delete', function(){
        var id = $(this).data("idr");
        var parent = $(this).parent().parent();
        $.post('/finance/deleteRecu', {idr : id}, function(res){
            parent.remove();
            toastr.success('Supprimé avec succès !')
        }, 'JSON');
    })
    
    $('#searchNie').on('click', function(){
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        if($('#nie').val().length != 10){
            toastr.error('Veuillez vérifier le NIE !');
            $('#searchNie').html('<i class="bi bi-search"></i>');
        }else{
            $.post('/finance/getStudent',{nie:$('#nie').val()}, function(res){
                if(res.etudiant.length == 0){
                    initModal();
                    toastr.warning('Etudiant introuvable !');
                }else{
                    $('#nom').val(res.etudiant[0].nom);
                    $('#prenom').val(res.etudiant[0].prenom);
                    $('#niveau').val(res.etudiant[0].nom_niv+''+res.etudiant[0].nom_gp);
                    $('#save').attr('data-matr', res.etudiant[0].num_matr)
                    toastr.info('informations bien chargés !');
                }
                $('#searchNie').html('<i class="bi bi-search"></i>');
            }, 'JSON')
        }
    })
    const format = num => { a=String(num).replace(/(?<!\..*)(\d)(?=(?:\d{3})+(?:\.|$))/g, '$1 '); return a.replace('.',','); };
    $('#montant').on('input', function(){
        var valeur = $(this).val();
        var mt = valeur.replace(' ', '');
        $(this).val(format(mt.replace(' ', '')));
    })
    $('#reste').on('input', function(){
        var valeur = $(this).val();
        var mt = valeur.replace(' ', '');
        $(this).val(format(mt.replace(' ', '')));
    })
    $('#save').on('click', function(){
        spinner.removeClass('d-none');
        $(this).attr( "disabled", true);
        console.log($(this));
        var date_bv = $('#date_bv').val(), date_p = $('#date_p').val() , modif = $(this).attr('data-modif') ,num_matr = $(this).attr('data-matr'), nie = $('#nie').val(), montant= $('#montant').val().replace(' ',''), reste = $("#reste").val().replace(' ',''), mode =  $('#mode').val();
        if($('#mode').val() == 'MVOLA'){
            var num = $('#ref').val();
        }else if($('#mode').val() == 'ESP'){
            var num = '';
        }else if($('#mode').val() == 'Cheque'){
            var num = $('#chq').val();
        }else{
            var num = $('#num').val();
        }
        if($('#designation').val() == "autre"){
            designation = $('#designationTxt').val();
        }else{
            designation = $('#designation').val();
        }
        if($("#signataire").val() == "autre"){
            signataire= $("#signataireTxt").val();
        }else{
            signataire= $("#signataire").val();
        }
        if(nie == "" || montant == "" || reste == "" || ($('#designation').val() == "autre" && $('#designationTxt').val() == "") || ($("#signataire").val() == "autre" && $("#signataireTxt").val() == "") || ($('#mode').val()!="ESP" && num =="") || $('#date_p').val() == '' ||(($('#mode').val() == 'Société Générale' || $('#mode').val() == 'BNI') && $('#date_bv').val() == '' )){
            toastr.error('Veuillez vérifier les données !');
            spinner.addClass('d-none');
            $('#save').removeAttr('disabled');
        }else{
            $.post('/finance/addRecus', {modif:modif, date_bv: date_bv, date_p : date_p, num_matr:num_matr, nie:nie, designation:designation, montant:montant, reste:reste, mode:mode, num :num, signataire:signataire}, function(res){
                if(res.status == 'ok'){
                    toastr.success('Enregistré avec succès');
                    $('modalRecus').modal('hide');
                    location.reload(true);
                    
                }else{
                    toastr.error('Erreur d\'insertion !');
                }
                spinner.addClass('d-none');
                $('#save').removeAttr('disabled');
            }, 'JSON')
            .fail(function(){
                toastr.error('Erreur de connexion !');
                spinner.addClass('d-none');
                $('#save').removeAttr('disabled');
            })

        }
    })
    $('#mode').on('change', function(){
        if($(this).val() == 'MVOLA'){
            $('#divNum').addClass('d-none');
            $('#divChq').addClass('d-none');
            $('#divRef').removeClass('d-none');
            $('#divDate_bv').addClass('d-none');
        }else if($(this).val() == 'ESP'){
            $('#divNum').addClass('d-none');
            $('#divRef').addClass('d-none');
            $('#divChq').addClass('d-none');
            $('#divDate_bv').addClass('d-none');
        }else if($(this).val() == 'Cheque'){
            $('#divNum').addClass('d-none');
            $('#divRef').addClass('d-none');
            $('#divChq').removeClass('d-none');
            $('#divDate_bv').addClass('d-none');
        }else{
            $('#divNum').removeClass('d-none');
            $('#divDate_bv').removeClass('d-none');
            $('#divRef').addClass('d-none');
            $('#divChq').addClass('d-none');
        }
    })
    $('#tbody').on('click', '#modif',function(){
        var idR = $(this).data('idr');
        $('#save').attr('data-modif', idR);
        $('#save').removeAttr('disabled')
        $.post('/finance/getRecu', {idR:idR}, function(res){
            var recu = res.recu;
            for(i in recu){
                $('#nie').val(recu[i].NIE);
                $('#nom').val(recu[i].nom);
                $('#prenom').val(recu[i].prenom);
                $('#niveau').val(recu[i].nom_niv+''+recu[i].nom_gp);
                $('#date_p').val(recu[i].date_p);
                $('#date_bv').val(recu[i].date_bv);
                if(recu[i].designation != 'F.S' && recu[i].designation !='D.I'){
                    $('#designationTxt').removeClass('d-none');
                    $('#designationTxt').val(recu[i].designation);
                    $('#designation').val('autre').change();
                }else{
                    $('#designation').val(recu[i].designation);
                    console.log(recu[i].designation);
                }
                if(recu[i].signataire != 'AD07-SPDE' && recu[i].signataire !='AD-RH01' && recu[i].signataire !='AD13-SPDE' && recu[i].signataire !='AD11-SPDE' && recu[i].signataire !='AD10-SPDE' && recu[i].signataire !='AD01-SPDE'){
                    $('#signataireTxt').removeClass('d-none');
                    $('#signataireTxt').val(recu[i].signataire);
                    $('#signataire').val('autre').change();
                }else{
                    $('#signataire').val(recu[i].signataire);
                }
                $('#montant').val(format(recu[i].montant));
                $('#reste').val(format(recu[i].reste));
                $('#mode').val(recu[i].mode).change();
                $('#num').val(recu[i].num);
                $('#chq').val(recu[i].num);
                $('#ref').val(recu[i].num);
                $('#save').attr('data-matr', recu[i].num_matr)
                $('#modalRecus').modal({backdrop: 'static', keyboard: false});
                toastr.info('informations bien chargéss !')
            }
        },'JSON');
    })
})