$(function(){
    $('div.dropdown').on('click','.dropdown-menu button.dropdown-toggle', function(e) {
        if (!$(this).next().hasClass('show')) {
          $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        $(this).next(".dropdown-menu").toggleClass('show');
        $('div.dropdown.show').on('hidden.bs.dropdown', function(e) {
          $('.dropdown-submenus .show').removeClass("show");
        });
        return false;
    });

    function getView(index,ei){
        index++;
        return '<tr>'+
            '<th scope="row">'+index+'</th>'+
            '<td>'+ei.nie+'</td>'+
            '<td class="text-weight-bold">'+ei.nom+'</td>'+
            '<td>'+ei.prenom+'</td>'+
            '<td>'+ei.sexe+'</td>'+
            '<th class="text-center"><input type="radio" name="'+index+'" ck="p" checked/></th>'+
            '<th class="text-center"><input type="radio" name="'+index+'" ck="a"/></th>'+
            '<th class="text-center"><input type="radio" name="'+index+'" ck="r"/></th>';
        '</tr>';
    }

    function getOPT(v){
        return '<option n='+v.ni+' p='+v.pi+'>'+v.niv+' '+v.gp+'</option>';
    }

    $('#cau button.dropdown-item').on('click',function(){
        $('#au_ico').addClass("fa fa-spinner fa-spin mr-2 text-primary");
        $('#ceih').html('<i>Efféctifs : ?</i>');
        $('#cei').html('');
        var aui=$(this).attr('ai'),aut=$(this).text();
        $.post('/etudiant/check_niv',{id:aui},function(res){
            var s='';
            for (const i in res) {
                const item=res[i];
                s+='<div class="dropdown-submenus">'+
                '<button class="dropdown-item dropdown-toggle">'+i+'</button>'+
                    '<div class="dropdown-menu">';
                var v='';
                if (item.length>0) {
                    for(const j in item){
                        const el=item[j];
                        v+='<button class="dropdown-item " n='+el.ni+' p='+el.pi+'>'+el.niv+' '+el.gp+'</button>';
                    }
                }else{
                    v+='<button class="dropdown-item" >vide</button>';
                }
                s+=v+'</div></div>';
            }
            $('#cau').attr('sau',aui);
            $('#ddau').text(aut);
            $('#au_ico').removeClass("fa fa-spinner fa-spin mr-2 text-primary");
            $('#cmigrate').html(s);
            $('#cnp').html(s);
        },'json')
    })

    $('#cnp').on('click','.dropdown-menu button.dropdown-item',function(e){
        e.preventDefault();
        var item=$(this),nivt=item.text(),n=item.attr('n'),p=item.attr('p'),
        au=$('#cau').attr('sau');
        var params={
            au:au,
            niv:n,
            gp:p
        };

        $('#cei').html('<p class="text-center"><i class="fas fa-spinner fa-pulse"></i></p>');
        $.post('/Emargements/getLsEm', params,
            function(data) {
                var res='';
                for(var i in data){
                    res+=getView(i,data[i]);
                }
                // alert(data);
            $('#cei').html(res);
            $('#ddniv').text(nivt); 
        },"json");
        
    })


})