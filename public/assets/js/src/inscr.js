$(function(){
  $("#au").prop("selectedIndex", -1);
  $("#niv").prop("selectedIndex", -1);
  $("#gp").prop("selectedIndex", -1);
  $("#nie_saison").prop("selectedIndex", -1);
  $("#nat").prop("selectedIndex", -1);
  $("#tranchefs").prop("selectedIndex", -1);
  $("#ab").prop("selectedIndex", -1);
  $("#sb").prop("selectedIndex", -1);
  $("#mb").prop("selectedIndex", -1);
  $("#do").prop("selectedIndex", -1);
  $("#recruteur").prop("selectedIndex", -1);

  $('#au').on('change',function(){
    $('#niv').prop('selectedIndex',-1);
    $('#gp').html('');
    var saison=$('#nie_saison').find(":selected").text(),
    annee=$(this).find(":selected").text();
    annee=annee.substring(0,4), sau='AU<em class="text-warning pl-1">*</em>';
    $('#nie_annee').val(annee);
    if (saison!='' && annee!='') {
      checkNie({s:saison+annee},'#pr_au',sau);
    }
    $(this).set_alert({color:'warning',message:'Veuillez remplir le NIE et choisissez le niveau et parcours pour cet étudiant !'})
  });

  $('#nie_saison').on('change',function(){
    var saison=$(this).find(":selected").val(),
    annee=$('#nie_annee').val(), snie='NIE<em class="text-warning pl-1">*</em>';
    if (saison!='' && annee!='') {
      checkNie({s:saison+annee},'#pr_nie',snie);
    }
  });

  $('#maj_nie').on('click',function(){
    var saison=$('#nie_saison').find(":selected").val(), annee=$('#nie_annee').val(),sbtn='MAJ';
    if (saison!='' && annee!='') {
      checkNie({s:saison+annee},'#maj_nie',sbtn);
    }
  })

  function checkNie(params,id,content){
    $(id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    $.post('/inscription/checknie',params,function(data){
      $('#nie_num').val(data);
      $(id).html(content);
    })
  }

//------------------------------frm


  

  
})