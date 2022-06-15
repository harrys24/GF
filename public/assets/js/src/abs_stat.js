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
    const list={
        'p':'Presence',
        'a':'Absence Non Justifiée',
        'aj':'Absence Justifié',
        'r':'Retard Non Justifié',
        'rj':'Retard Justifié',
    }
    function getView(index,ei){
        index++;
        return '<tr>'+
            '<th scope="row">'+index+'</th>'+
            '<td>'+list[ei.status]+'</td>'+
            '<td class="text-weight-bold">'+ei.somme+'</td>'+
            '<td>'+ei.pourcentage+'%</td>'+
        '</tr>';
    }

    $('#btn_verifier').click(function(){
        var sd=$('#sd').val(),ed=$('#ed').val();
        $('#icon-load').addClass("fa fa-spinner fa-spin mr-2");
        $.post('/ABS/getStat',{token:$('#token').val(),sd:sd,ed:ed},function(res){
            
            var c='',data=res.data;
            $('#icon-load').removeClass("fa fa-spinner fa-spin mr-2");
            if (data!=undefined) {
                for(var i in data){
                    c+=getView(i,data[i]);
                }
                
            }
            $(this).set_alert(res);
            $('#cei').html(c);
            
        },'json');
    })

})