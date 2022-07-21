$(function(){
  html_spinner='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
  $.datetimepicker.setLocale('fr');
  $('#niv').on('change',function(){
    var au=$('#au option:selected').val(),niv=$(this).find("option:selected").val();
    if(au!=null && niv!=null){
      $('#pr_niv').html(html_spinner);
      $.post('/inscription/niv_check',{iau:au,iniv:niv},function(data){
        var sgp='',sck='';
        var gp=data.gp,lsck=data.dossier;
        for(var i in gp){
          sgp+='<option value="'+gp[i].igp+'">'+gp[i].gp+'</option>';
        }
        
        for(var j in lsck){
          sck+='<div class="col-6 col-md-4 col-lg-3 custom-control custom-checkbox">'+
            '<input type="checkbox" value="'+lsck[j].idos+'" class="custom-control-input" id="ck'+lsck[j].idos+'">'+
            '<label class="custom-control-label" for="ck'+lsck[j].idos+'">'+lsck[j].vdos+'</label>'+
          '</div>';
        }
        $('#pr_niv').html('NIVEAU<em class="text-danger pl-1">*</em>');
        $('#gp').html(sgp);
        $('#ckdossier').html(sck);
      },'json');
    }else{
      $(this).set_alert({color:'warning',message:'Veuillez choisir l\'année universitaire puis le niveau !'});
    }
  
  });
  
  $('input[type=file]').change(function (e){
    $(this).next('.custom-file-label').text(e.target.files[0].name);
  });
  
  addAutre('nat');
  addAutre('sb');
  addAutre('do');
  
  $("input[name^='tel']").each(function(){
    $(this).keypress(function(e){
      var keyCode = (e.keyCode ? e.keyCode : e.which);
      if (keyCode < 48 || keyCode > 57) {
        return false;
      }
      var v=$(this).val(),
        ls=['032', '033','034', '039', '022'],ss=[3,6,10],
        _v=v.substring(0,3),nb=v.length;
      if(nb>12 || (nb==3 && ls.indexOf(_v)==-1)){
        return false;
      }
      
      if(ss.indexOf(nb)!=-1){
        v+=' ';
      }
      if(nb>13){
        v=v.substring(0, 13);
      }
      $(this).val(v);
    });
  })
  
  $("input[name$='DI']").each(function(){
    $(this).keypress(function(e){
      var keyCode = (e.keyCode ? e.keyCode : e.which);
      if ((keyCode < 48 && keyCode!=32) || keyCode > 57) {
        console.log(keyCode);
        return false;
      }
    });
    
  })
  
  function addAutre(name){
    var opt='#'+name,copt='#ca_'+name,
    closename='x'+name,selclose='#'+closename,lsClass='input-group form-group col-10 col-md-5 col-lg-4';
    $(opt).on('change',function(){
      var value=$(this).find('option:selected').val();
      if (value=='-1') {
        $(copt).addClass(lsClass).html(viewTfAutre(name,closename));
        $(this).prop('disabled',true);
        $(selclose).on('click',function(){
          $(copt).removeClass(lsClass).html('');
          $(opt).prop('disabled',false).prop("selectedIndex", -1);
        })
      }
      
    })
  }
  
  function viewTfAutre(sel,closename){
    return '<div class="input-group-prepend">'+
      '<span class="input-group-text" >Autre<em class="text-danger pl-1">*</em></span>'+
    '</div>'+
    '<input type="text" class="form-control" required>'+
    '<div class="input-group-append">'+
    '<button type="button" class="btn btn-primary btn_autres" data-sel="'+sel+'"><i class="bi bi-plus-circle"></i></button>'+
      '<button type="button" class="btn btn-danger" id="'+closename+'"><i class="bi bi-x"></i></button>'+
    '</div>';
  }
  
  $('.ca').on('click','.btn_autres',function(){
    var txt=$(this).parent().prev().val(),sel=$(this).data('sel');
    if (txt=='') {
      $('body').set_alert({color:'danger',message:'Veuillez remplir le champs autre!'});
      return;
    }
    var c = confirm('Veuillez confirmer si votre enregistrement ne pas listé!');
    if(c == true){
      $(this).html(html_spinner);
      $.post('/Inscription/checkOV',{tb:sel,txt:txt},function(res){
        if (res.data!==undefined) {
          var s='';
          res.data.forEach(n => {
            s+='<option value='+n.id+'>'+n.txt+'</option>';
          });
          s+='<option value=-1>Autre ...</option>';
          $('#'+sel).html(s);
        }
        $('#'+sel).prop('disabled',false);
        $('#ca_'+sel).removeClass('input-group form-group col-10 col-md-5 col-lg-4').html('');
        $('#'+sel+' option[value='+res.id+']').prop('selected',true);
      },'json')
    }
  })
  
  $('#cmp').on('click','#btn_addT',function(){
    var c='<div id="c_sd" class="input-group form-group col-10  col-md-4">'+
      '<div class="input-group-prepend">'+
      '<span class="input-group-text" >A partir du<em class="text-danger pl-1">*</em></span>'+
      '</div>'+
      '<input name="sd" id="sd" type="date" class="form-control" required>'+
      '<div class="input-group-append">'+
      '<span id="sd_close" class="btn btn-danger" ><i class="bi bi-x"></i></span>'+
      '</div>'+
    '</div>';
    $('#cbtn_addT').before(c).remove();
    $('.form_date').datetimepicker({
      timepicker:false,
      format:'d/m/Y'
    });
  });
  
  $('#cmp').on('change','#sd',function(){
    var sd=$('#sd').val(),nbt=$("#tranchefs :selected").text();
    if (sd!=null && nbt!=null) {
      get_date_prevu(sd,nbt);
    }
  })
  
  $('#cmp').on('click','#sd_close',function(){
    var btn='<div id="cbtn_addT" class="form-group ml-3">'+
    '<span id="btn_addT" class="btn btn-outline-primary">Ajouter Tranche de paiement</span>'+
      '</div>';
    $('#listPContainer').html('');
    $('#c_sd').before(btn).remove();
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

  $('#tranchefs').on('change',function(){
    var au=$('#au').val(),niv=$('#niv').val(),tranche=$('#tranchefs option:selected').val();
    if (!au || !niv) {
      $('body').danger('Vous deviez d\'abord choisir l\'année universitare et le niveau');return;
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
          $('body').danger('Vous deviez ajouter les tranches de paiement pour cet année universitaire');return;
        }
    },'json')
  });
  
  function get_date_prevu(sd,nbt){
    var DF='DD/MM/YYYY';
    var db=moment(sd,DF),
    nb=parseInt(nbt),
    items='',step=0;
    $('#nbTranche').val(nb);
    switch (nb) {
      case 1:
        step=10;
        break;
      case 3:
        step=3;
        break;
      case 5:
        step=2;
        break;
    
      default:
        step=1
        break;
    }
    
    for(var i=1;i<=nb;i++){
      items+=createDate(i,db.format(DF));
      db=db.add(step,'M');
    }
    $('#listPContainer').html('').append(items);
    $('.form_date').datetimepicker({
      timepicker:false,
      format:'d/m/Y'
    });
  
  }
  //janvier
  //10 01/02/03/... +1
  //5  01/03/05/07/09  +2
  //3  01/04/07 +3
  
  
  function createDate(numT,value=''){
    return '<div class="input-group form-group col-6  col-md-3 col-lg-2">'+
      '<div class="input-group-prepend">'+
        '<span class="input-group-text" >'+numT+'T</span>'+
      '</div>'+
      '<input name="'+numT+'T" size="16" type="text" class="form-control form_date text-center  font-italic" value="'+value+'" readonly >'+
    '</div>';
  }
  
  $('.form_date').datetimepicker({
    timepicker:false,
    format:'d/m/Y'
  });

  $('#formEtudiant').on('submit',function(e){
    e.preventDefault();
    if ($('input[name=sexe]:checked').val()==undefined) {
      $('body').set_alert({color:'danger',message:'Veuillez renseigner votre sexe !'});
      return;
    }
    if ($('#nat').val()==-1 || $('#sb').val()==-1 || $('#do').val()==-1 ) {
      $('body').set_alert({color:'danger',message:'Veuillez cliquer sur le bouton plus pour ajouter "autre valeur" !'});
      return;
    }
    var au_txt=$('#au').find(':selected').text(),
    niv_gp_txt=$('#niv').find(':selected').text()+$('#gp').find(':selected').text(),
    ls=[],nbt=$("#tranchefs :selected").text();
    $('#au_txt').val(au_txt);
    $('#niv_gp_txt').val(niv_gp_txt);
    $('#ckdossier input:checked').each(function(){
        ls.push($(this).attr('id'));
    })
    
    $('#nbTranche').val(nbt);
    $('#list_dossier').val(ls.join(','));
    var fd=new FormData(this);
    $.ajax({
        url:'/inscription/checkEtudiant',
        type:'post',
        data:fd,
        dataType:'json',
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
          if (res.status=='ok') {
            $('#iphoto').remove();
            $('#ckdossier').html('');
            $('#listPContainer').html('');
            $(this).reset_form();
          }
          $('body').set_alert(res);
        }
    })
        
  });

})
