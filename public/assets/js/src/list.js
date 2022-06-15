$(function(){

  $.datetimepicker.setLocale('fr');
  $('#niv').on('change',function(){
    var au=$('#au option:selected').val();
    var niv=$(this).find("option:selected").val();
    if(au!=null && niv!=null){
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
    var opt='#'+name,copt='#ca_'+name,iname='i'+name,
    closename='x'+name,selclose='#'+closename;
    $(opt).on('change',function(){
      var txt=$(this).find('option:selected').val();
      if (txt=='-1') {
        $(copt).addClass('input-group form-group col-10 col-md-5 col-lg-3')
        .html(viewTfAutre(iname,closename));
        $(this).prop('disabled',true);
        $(selclose).on('click',function(){
          $(copt).removeClass('input-group form-group col-10 col-md-5 col-lg-3').html('');
          $(opt).prop('disabled',false).prop("selectedIndex", -1);
        })
      }
      
    })
  }
  
  function viewTfAutre(id,closename){
    return '<div class="input-group-prepend">'+
      '<span class="input-group-text" >Autre<em class="text-warning pl-1">*</em></span>'+
    '</div>'+
    '<input type="text" name="'+id+'" class="form-control" required>'+
    '<div class="input-group-append">'+
      '<span class="btn btn-outline-danger" id="'+closename+'">x</span>'+
    '</div>';
  }
  
  
  $('.form_date').datetimepicker({
    timepicker:false,
    format:'d/m/Y'
  });


})
