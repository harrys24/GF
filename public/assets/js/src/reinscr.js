$(function(){
  $("#au").prop("selectedIndex", -1);
  $("#niv").prop("selectedIndex", -1);
  $("#gp").prop("selectedIndex", -1);
  $("#tranchefs").prop("selectedIndex", -1);
  $("#do").prop("selectedIndex", -1);
  html_spinner='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
  $.datetimepicker.setLocale('fr');
	$('[data-toggle="tooltip"]').tooltip();
	// $('[data-toggle="popover"]').tooltip();
	// $('#btnTeste').on('click',function(){
	//   $(this).popover('show');
	// });

	function reset_form () {
		$(':input')
		.not(':button :submit :reset :hidden')
		.val('')
		.prop('checked', false)
		.prop('selected', false);
	}

	$('#au').change(function(){
		$('#niv').prop('selectedIndex',-1);
		$('#gp').html('');
	})


	$('#niv').on('change',function(){
		var au=$('#au option:selected').val();
		var niv=$(this).find("option:selected").val();
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
						'<input type="checkbox" value="'+lsck[j].idos+'" name="'+j+'" class="custom-control-input" id="'+j+'">'+
						'<label class="custom-control-label" for="'+j+'">'+lsck[j].vdos+'</label>'+
					'</div>';
				}
				$('#pr_niv').html('NIVEAU<em class="text-warning pl-1">*</em>');
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
		  '<span class="input-group-text" >Autre<em class="text-warning pl-1">*</em></span>'+
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
		if ($('#nat').val()==-1 || $('#sb').val()==-1 || $('#do').val()==-1 ) {
			$('body').set_alert({color:'danger',message:'Veuillez cliquer sur le bouton plus pour ajouter "autre valeur" !'});
			return;
		}
		var frm=$('form')[0];
		var fd=new FormData(frm);
		$.ajax({
			url:'/Reinscription/check',
			type:'post',
			data:fd,
			dataType:'json',
			cache:false,
			contentType:false,
			processData:false,
			success:function(res){
				$(this).set_alert(res);
				if (res.color!='warning') {
					$(':input').not(':button :submit').val('').prop('selectedIndex',-1).prop('checked',false);
					$('#iphoto').remove();
				}
				console.log(res);
			}
		})
		// $(this).dropfile();
		
		
		
	});


  
})