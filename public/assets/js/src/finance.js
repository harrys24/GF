$(function(){
    $('#mode-paiement').prop('selectedIndex',-1);
    loadData('#form');
    $('#form').on('submit',function(e){
        e.preventDefault();
       loadData('#form');
    })
    date_now=$('#date-paiement').val();
    var ls=[],tarif=0;

    function loadData(form) {
        $('#result').html('');
        $.post('/Finance/CheckDate',{d:$(form).find('input[type=date]').val()},function(res){
            html='';
            count=[];i=0;
            $('#result').html('Nombre de ligne : '+res.length);
            res.forEach(item => {
                i++
                let c = item.contact.replace(/,+/g, ",");
                c = c.replace(/^,+|,+$/g, "");
                const contact = c.replace(/,/g, " , ");
                const nr=(item.num_reçu==null)?'?':item.num_reçu;
                const status=item.status==1?'text-success bi bi-check-circle-fill':'text-danger bi bi-x-circle-fill';
                html+='<tr id="row-'+i+'" data-nv='+item.idNIV+' data-gp='+item.idGP+' data-nm='+item.INSCR_num_matr+' data-fs='+item.idFS+' data-nt='+item.num_tranche+' data-nb='+item.nbT+' data-status="'+item.status+'" data-nr='+nr+' data-row='+i+'>'+
                    '<th>'+i+'</th>'+
                    '<td>'+item.nom_niv+' '+item.nom_gp+'</td>'+
                    '<td>'+item.nie+'</td>'+
                    '<td>'+item.nom+'</td>'+
                    '<td>'+item.prenom+'</td>'+
                    '<td>'+contact+'</td>'+
                    '<td class="text-center">'+item.num_tranche+'/'+item.nbT+'</td>'+
                    '<td class="text-center"><i id="status-'+i+'" class="'+status+'"></i></td>'+
                    '</tr>'
                ;

            });
            $('#tbody').html(html);
        },'json')
    }

    $('#tbody').on('dblclick','tr',function(){
        nv=$(this).data('nv');
        gp=$(this).data('gp');
        nm=$(this).data('nm');
        fs=$(this).data('fs');
        nt=$(this).data('nt');
        nbT=$(this).data('nb');
        nr=$(this).data('nr');
        row=$(this).data('row');
        state=$(this).data('status');
        console.log('o > status:'+state+' row:'+row+' nt: '+nt);
        $('#item-title').html('En cours ...');
        $('#item-modal').modal('show');
        niv='<span class="text-blue"> ('+$(this).find(':nth-child(2)').html()+')</span>';
        nie='<span class="text-blue"> '+$(this).find(':nth-child(3)').html()+'</span> ';
        v=nie+$(this).find(':nth-child(4)').html()+' '+$(this).find(':nth-child(5)').html()+niv;
        echeance=$(this).find(':nth-child(7)').text();
        $('#item-num').text(nr);
        $.post('/Finance/CheckDetail',{nv:nv,gp:gp,nm:nm,fs:fs},function(res){
            tarif=res[0],sm=0;
            let html='';
            let i=0;
            var options = {weekday: "short", year: "2-digit", month: "short", day: "2-digit"};
            res[1].forEach(item => {
                i++;
                let tr_style='',lign_status='',btn_style='';
                if (item.status==1) {
                    lign_status='bi bi-check-circle';
                    tr_style=' class="text-white bg-success"';
                    btn_style='btn-light';
                } else {
                    btn_style='btn-outline-gray';
                    lign_status='text-danger bi bi-x-circle-fill';
                }
                let montant='-';
                let m=0;
                if (item.montant!=null) {
                    m=parseFloat(item.montant)
                    sm+=m;
                    montant=item.montant;
                    ls.push()
                }
                ls.push(m);
                let num_reçu=(item.num_reçu==null)?'-':item.num_reçu;
                let date_prevu=(item.date_prevu==null)?'-':(new Date(item.date_prevu)).toLocaleDateString('fr-FR',options);
                let date_paiement=(item.date_paiement==null)?'-':(new Date(item.date_paiement)).toLocaleDateString('fr-FR',options);
                html+='<tr id="tr-'+i+'" '+tr_style+'>'+
                '<td class="font-italic">'+item.num_tranche+'/'+nbT+'</td>'+
                '<td>'+date_prevu+'</td>'+
                '<td>'+date_paiement+'</td>'+
                '<td>'+num_reçu+'</td>'+
                '<td>'+format(montant)+'</td>'+
                '<td class="text-center"><i class="'+lign_status+'"></i></td>'+
                '<td class="text-center"><button class="btn btn-sm '+btn_style+'" data-index='+i+' data-fs='+item.idFS+'><i class="bi bi-pen"></i></button></td>'+
                '</tr>';
            });
            let reste=tarif-sm;
            $('#item-tarif').html(format(tarif));
            $('#item-paye').html(format(sm));
            $('#item-reste').html(format(reste));
            $('#item-title').html(v);
            $('#modal-tbody').html(html);
            $('#item-echeance').data({row:row,status:state,cstatus:state,index:i,nm:nm,fs:fs,nt:nt}).html(echeance+' nm: '+nm+' fs: '+fs+' index:'+i);
        },'json')
        
    })
    function toDecimal(mt){
        if (mt!='-') {
            mt=mt.replace(/\s/g,'');
            mt=mt.replace(',','.');
            mt=parseFloat(mt);
            return mt;
        } else {
           return '';
        }
    }

    $('#modal-tbody').on('click','button',function(){
        var parent=$(this).parent().parent(),c=parent.find(':first-child()').text()
        nr=parent.find(':nth-child(4)').text(),fs=$(this).data('fs');
        var index=$(this).data('index'),nm=$('#item-echeance').data('nm');
        $('#item-echeance').data({fs:fs,index:index});
        var cfs=$('#item-echeance').data('fs'),mt=parent.find(':nth-child(5)').text();
        nr=(nr=='-'?'?':nr);
        mt=toDecimal(mt);
        $('#montant').val(mt);
        $('#item-num').text(nr);
        $('#item-echeance').html(c+' nm:'+nm+' fs:'+cfs+' index:'+index);
        
    })

    const format = num => { a=String(num).replace(/(?<!\..*)(\d)(?=(?:\d{3})+(?:\.|$))/g, '$1 '); return a.replace('.',','); };

    $('#modal-valider').on('click',function(){
        var options = {weekday: "short", year: "2-digit", month: "short", day: "2-digit"};
        var ech=$('#item-echeance'),
        index=ech.data('index'),nm=ech.data('nm'),fs=ech.data('fs'),nt=ech.data('nt'),
        ligne=$('#tr-'+index),dp=$('#date-paiement').val();
        var date_paiement=(dp==null)?'-':(new Date(dp)).toLocaleDateString('fr-FR',options);
        var montant=$('#montant').val(),num_reçu=$('#item-num').text();
        if (num_reçu=='?') {alert('Numéro réçu est vide !');return;}
        if (montant=='') {alert('Montant est vide !');return;}
        $.post('/Finance/UpdateFs',{fs:fs,nm:nm,nr:num_reçu,mt:montant,dp:dp},function(res){
            if (nt==index) {
                $('#item-echeance').data('cstatus',1);
            }
            ls[index-1]=parseFloat(montant);
            checkReste();
            ligne.addClass('bg-success text-white');
            ligne.find(':nth-child(3)').html(date_paiement);
            ligne.find(':nth-child(4)').html(num_reçu);
            ligne.find(':nth-child(5)').html(format(montant));
            ligne.find(':nth-child(6)').html('<i class="bi bi-check-circle"></i>');
            ligne.find(':nth-child(7) > button.btn').removeClass('btn-outline-gray').addClass('btn-light');
        },'json')
    })
    $('#modal-reset').on('click',function(){
        var ech=$('#item-echeance'),index=ech.data('index'),nm=ech.data('nm'),fs=ech.data('fs'),
        nt=ech.data('nt'),ligne=$('#tr-'+index);
        ls[index-1]=0;
        checkReste();
        $.post('/Finance/ResetFs',{fs:fs,nm:nm},function(res){
            if (nt==index) {
                $('#item-echeance').data('cstatus',0);
            }
            ligne.removeClass('bg-success text-white');
            ligne.find(':nth-child(3)').html('-');
            ligne.find(':nth-child(4)').html('-');
            ligne.find(':nth-child(5)').html('-');
            ligne.find(':nth-child(6)').html('<i class="text-danger bi bi-x-circle-fill"></i>');
            ligne.find(':nth-child(7) > button.btn').removeClass('btn-light').addClass('btn-outline-gray');
        },'json')
    })



    $('#mode-paiement').on('change',function(){
        var mode=$(this).find(":selected").val();
        if (mode!='') {
          checkNum({s:mode},'#item-num');
        }
      });

      function checkNum(params,id){
        $(id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $.post('/Finance/CheckNum',params,function(data){
          $('#item-num').html(data);
        //   $(id).html(content);
        })
      }

      function checkReste(){
          var s=0;
          ls.forEach(m => {
              s+=m;
          });
          var r=tarif-s;
          $('#item-paye').html(format(s));
          $('#item-reste').html(format(r));
      }

    $('#item-modal').on('hidden.bs.modal', function (event) {
        ls=[];tarif=0;
        var ech=$('#item-echeance'),
        status=ech.data('status'),
        cstatus=ech.data('cstatus'),
        row=ech.data('row'),
        nt=ech.data('nt');
        console.log('c > cstatus:'+cstatus);
        if (status!=cstatus) {
            if (cstatus==0) {
                $('#row-'+row).data('status',0);
                $('#status-'+row).removeClass().addClass('text-danger bi bi-x-circle');
            } else {
                $('#row-'+row).data('status',1);
                $('#status-'+row).removeClass().addClass('text-success bi bi-check-circle');
            }
        }
        $('#item-title').html('New modal');
        $('#modal-tbody').html('<tr><td class="text-center" colspan=7>VIDE</td></tr>');
        $('#item-echeance').removeData().html('?');
        console.log('status: '+$('#item-echeance').data('status')+' cstatus: '+$('#item-echeance').data('cstatus'));
        $('#item-tarif').html('?');
        $('#item-paye').html('?');
        $('#item-reste').html('?');
        $('#item-num').html('?');
        $('#montant').val('');
        $('#mode-paiement').prop('selectedIndex',-1);
        $('#date-paiement').val(date_now);
    })
})