$(function(){
    var TF="HH:mm";
    $.datetimepicker.setLocale('fr');
    $('.form_date').datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });

    $('.form_time').datetimepicker({
        datepicker:false,
        step:15,
        format:'H:i',
        minTime:'07:00',
        maxTime: '18:30'

    });
    setTB();

    function setTB(){
        $('#cei input[type=checkbox]').bootstrapToggle({
            on: 'Justifié',
            off: 'Non Justifié',
            onstyle:'primary',
            offstyle:'danger'
        });
    }

    function getView(index,ei){
        index++;
        return '<tr>'+
            '<th scope="row">'+index+'</th>'+
            '<td>'+ei.nie+'</td>'+
            '<td class="text-weight-bold">'+ei.nom+'</td>'+
            '<td>'+ei.prenom+'</td>'+
            '<td>'+ei.sexe+'</td>'+
            '<td>'+ei.matiere+'</td>'+
            '<td>'+ei.salle+'</td>'+
            '<th class="pr text-center"><input type="checkbox" ip="'+ei.ip+'" name="'+index+'"/></th>'+
        '</tr>';
    }

    $('#btn_verifier').click(function(){
        
        var dc=$('#dc').val(),type=$('#type :selected').val(),ne=$('#ne').val();
        if (ne=='') {
            $(this).set_alert({color:'danger',message:'veuillez-remplir les champs obligatoires !'});
            return;
        } 
        $('#th-action').text((type=='a'?'ABSENCE JUSTIFIÉ ?':'RETARD JUSTIFIÉ ?'));
        $('#icon-load').addClass("fa fa-spinner fa-spin mr-2");
        $.post('/ABS/check_ne',{token:$('#token').val(),dc:dc,type:type,ne:ne},function(res){
            var c='',data=res.data;
            $('#icon-load').removeClass("fa fa-spinner fa-spin mr-2");
            if (data!=undefined) {
                $('#inc').attr('tp',type).attr('nm',data[0].nm).attr('ne',data[0].nie);
                for(var i in data){
                    c+=getView(i,data[i]);
                }
                
            }
            $(this).set_alert(res);
            $('#cei').html(c);
            setTB();
            
        },'json');
    })

    $('#btnValider').click(function(){
        var ckc=$('#ckc').prop('checked'),fc=$('#inc'),nm=fc.attr('nm'),ne=fc.attr('ne');
        if(ckc && nm!='' && ne!=''){
            $('#cmodal').modal('show');
        }else{
            $(this).set_alert({color:'danger',message:'Remplissez les champs obligatoires et cochez pour confirmation !'});
        }
        
    });

    $('#btn_confirm').click(function(){
        $('#cmodal').modal('hide');
        var list=[],fc=$('#inc');
        $('#cei tr input:checked').each(function(){
            list.push({ip:$(this).attr('ip')});
        });
        if (list.length==0) {
            $(this).set_alert({color:'warning',message:'Aucun élément a été modifié !'});
            return;
        }
        var params={
        token:$('#token').val(),type:fc.attr('tp'),nm:fc.attr('nm'),ne:fc.attr('ne'),list:list};
        $.post('/ABS/updateList',params,function(res){
            $(this).set_alert(res);
        },'json')
    })

    $('#cmodal').on('hidden.bs.modal',function(e){
        $('#c_txt').html('');
    })

})