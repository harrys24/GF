$(function(){
    $('#au').prop('selectedIndex',-1);
    $('#niv').prop('selectedIndex',-1);
    $('#tranche').prop('selectedIndex',-1);
    $('#cres').hide();
    html_spinner='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    $('#niv').on('change',function(){
        var au=$('#au').val(),niv=$('#niv').val()
        $('#gp').html('');
        if (!au || !niv) {
            toastr.warning('Les champs Année universitaire et Niveau doivent être remplis !','ATTENTION');
            return;
        } 
        var params ={au:au,niv:niv}
        $.post('/Finance/getGP',params,function(res){
            console.log(res);
            if (res.gp.length >0 ) {
                let s='';
                res.gp.forEach(item => {s+='<option value="'+item.igp+'">'+item.gp+'</option>'});
                $('#gp').html(s);
            } else {
                toastr.error('Les groupes , parcours pour cet année universitaire ne sont pas encore ajoutés !')
            }
            if (res.tarif) {
                $('#res_tarif').html(res.tarif);
            } else {
                toastr.error('Les Frais de scolarités pour cet année universitaire ne sont pas encore ajoutés !')
            }
        },'json')
    })
    $('#au').on('change',function(){
        $('#niv').prop('selectedIndex',-1);
        $('#gp').prop('selectedIndex',-1);
    })

    $('#btn-search').on('click',function(){
        $('#btn-search-icon').html(html_spinner);
        var params ={au:$('#au').val(),niv:$('#niv').val(),gp:$('#gp').val(),nie:$('#nie').val()}
        $.post('/Finance/getEtudiant',params,function(res){
            $('#btn-search-icon').html('<i class="bi bi-search mr-2"></i>');
            if (res) {
                $('#res_nie').text(res.nie);
                var niveau =$('#niv option:selected').text()+' '+$('#gp option:selected').text();
                $('#res_niv').text(niveau);
                $('#num').text('#'+res.nm);
                $('#sexe').text(res.sexe);
                $('#datenaiss').text(res.datenaiss);
                $('#lieunaiss').text(res.lieunaiss);
                $('#nom').html(res.nom+' <span class="text-muted">'+res.prenom+'</span>');
                if (res.idt) {
                    let idt=Number.parseInt(res.idt)
                    $('#res_tranche').html('EN '+res.nbt+' FOIS').show();
                    // $('#tranche option[value='+idt+']').attr('selected','selected');
                    $('#tranche').val(idt).change();
                    $('#cres-header').removeClass('bg-success').addClass('bg-danger')
                    $('#detail-titre').removeClass('text-success').addClass('text-danger')
                    $('#btn-update').removeClass('btn-success').addClass('btn-danger')
                    
                } else {
                    $('#res_tranche').html('').hide();
                    $('#tranche').prop('selectedIndex',-1);
                    $('#ctranche').html('');
                    $('#cres-header').removeClass('bg-danger').addClass('bg-success')
                    $('#detail-titre').removeClass('text-danger').addClass('text-success')
                    $('#btn-update').removeClass('btn-danger').addClass('btn-success')
                }
                $('#cres').fadeIn('slow');
            } else {
                $('#cres').fadeOut('slow');
                toastr.info('Aucune information trouvée !','INFORMATION')
            }
        },'json')
    })
    $('#btn-update').on('click',function(){
        var params ={au:$('#au').val(),niv:$('#niv').val(),gp:$('#gp').val(),nie:$('#nie').val(),tranche:$('#tranche').val()}
        $('#btn-update-icon').html(html_spinner);
        $.post('/Finance/updateTranche',params,function(res){
            $('#btn-update-icon').html('<i  class="bi bi-arrow-repeat mr-2"></i>');
            if (res) {
                toastr.success('Tranche de paiement bien ajouté pour "'+$('#res_nie').text()+'"','INFORMATION')
            } else {
                toastr.error('erreur de réseau détécté !','ERREUR')
            }
        },'json')
    })


    function viewTU(index,id,num_tranche,date_value,montant_value){
        return '<div class="col-12 col-md-6 col-lg-4 form-group">'+
        '<b>Tranche '+index+'</b>'+
        '<input type="hidden" name="detail['+index+'][id]" value="'+id+'"/>'+
        '<input type="hidden" value="'+num_tranche+'"/>'+
        '<div class="input-group">'+
            '<input type="date" value="'+date_value+'" class="col-lg-8 form-control"  disabled>'+
            '<input type="text" value="'+montant_value+'" class="col-lg-4 form-control" disabled>'+
            '<div class="input-group-append bg-light"><div class="input-group-text">AR</div></div>'+
        '</div></div>'
      }
    
      $('#tranche').on('change',function(){
        var au=$('#au').val(),niv=$('#niv').val(),tranche=$('#tranche option:selected').val();
        if (!au || !niv) {
            toastr.error('Vous deviez d\'abord choisir l\'année universitare et le niveau','OBLIGATION');
            return;
        }
        $.post('/inscription/getDetailTranche',{'au':au,'niv':niv,'tranche':tranche},function(res){
            console.log(res);
            if (res.length>0) {
              var html='';
              res.forEach((item,index) => {
                  html+=viewTU(index+1,item.id,item.num_tranche,item.date_prevu,item.montant_prevu);
              });
              $('#ctranche').html(html);
            }else{
                toastr.error('Vous deviez ajouter les tranches de paiement pour cet année universitaire','OBLIGATION');
                return;
            }
        },'json')
      });
})