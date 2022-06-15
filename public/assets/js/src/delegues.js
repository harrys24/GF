$(function(){
    $("#au").prop("selectedIndex", -1);
    $("input[type=file]").change(function (e){$(this).next('.custom-file-label').text(e.target.files[0].name);});
    $('#cei').on('click','.btn-edit',function(){
        var parent=$(this).parent().parent(),
        cell=parent[0].cells;
        $('#nie').val(cell[3].innerText);
        $('#nom').val(cell[4].innerText);
        $('#prenom').val(cell[5].innerText);
        $('#email').val(cell[6].innerText);

        $('#username').val(cell[1].innerText);
        $('#password').val(cell[2].innerText);
        $('#cpassword').val(cell[2].innerText);
        $('#opk').val(cell[1].innerText);
        $('#form_type').val('edit');
    })
    $('#cei').on('click','.btn-del',function(){
        var parent=$(this).parent().parent(),
        cell=parent[0].cells,
        username=cell[1].innerText,
        nom=cell[4].innerText,
        prenom= cell[5].innerText;
        $('#btn_confirm').attr('data-id',username);
        var c='<b>SUPPRESSION DU DÉLÉGUÉ</b></br>'+
        'Nom d\'utilisateur : '+'<em>'+username+'</em></br>'+
        'Nom et prénom(s) : <b>'+nom+'</b> '+prenom;
        $('#c_txt').html(c);
        $('#cmodal').modal('show');
    })
    $('#cmodal').on('hidden.bs.modal',function(e){
        $('#c_txt').html('');
        $('#ouser').val('');
        $('#btn_confirm').removeAttr('data-type');
    })
    $('#btn_confirm').click(function(){
        $('#cmodal').modal('hide');
        $.post('/delegues/delete',{id:$(this).attr('data-id'),token:$('#token').val()},
            function(res){
                var c='',data=res.data;
                for(var i in data){
                    c+=getView(i,data[i]);
                }
                $('#cei').html(c);
                $(this).set_alert(res);
        },'json');
        
    })

    function getView(index,ei){
        index++;
        return '<tr>'+
        '<th scope="row" ni="'+ei.INSCR_num_matr+'">'+index+'</th>'+
        '<td>'+ei.username+'</td>'+
        '<td>'+ei.password+'</td>'+
        '<td>'+ei.nie+'</td>'+
        '<td>'+ei.nom+'</td>'+
        '<td>'+ei.prenom+'</td>'+
        '<td>'+ei.email+'</td>'+
        '<td>'+ei.nom_niv+' '+ei.nom_gp+'</td>'+
        '<td><button class="btn btn-sm btn-outline-warning btn-edit"><i class="fal fa-user-edit"></i></button></td>'+
        '<td><button class="btn btn-sm btn-outline-danger btn-del"><i class="fal fa-user-times"></i></button></td>'+
        '</tr>';
    }
    $('#register').on('submit',function(e){
        e.preventDefault();
        var pwd=$('#password').val(),
            cpwd=$('#cpassword').val();
        if(pwd==cpwd){
            var frm=$('form')[0],fd=new FormData(frm);
            $.ajax({
                url:'/delegues/check',
                type:'post',
                data:fd,
                dataType:'json',
                cache:false,
                contentType:false,
                processData:false,
                success:function(res){
                    var c='',data=res.data;
                    for(var i in data){
                        c+=getView(i,data[i]);
                    }
                    $('#cei').html(c);
                    $(this).set_alert(res);
                    init_form();
                    
                }
               
            })
           
        }else{
            $(this).set_alert({color:'warning',message:'mot de passe incorrect !'});
        }
		
		
		
    });

    function init_form(){
        $('input').not(':hidden').val('');
        $('#type_user').prop('selectedIndex',-1);
        $('#form_type').val('insert');
        $('#opk').val('');
    }

    $('#btn-insert').on('click',function(){init_form();});
    
    $('#btn-aff').on('click',function(){
        var mm="Masquer MDP",am="Afficher MDP";
        if ($(this).text()==am) {
            $(this).text(mm).removeClass('btn-outline-warning').addClass('btn-outline-danger');
            $('#password').attr('type','text');
            $('#cpassword').attr('type','text');
        } else {
            $(this).text(am).removeClass('btn-outline-danger').addClass('btn-outline-warning');
            $('#password').attr('type','password');
            $('#cpassword').attr('type','password');
            
        }
    })

})

