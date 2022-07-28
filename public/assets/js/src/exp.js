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
    $('#cnp').on('click','.dropdown-menu button.dropdown-item',function(e){
        e.preventDefault();
        var item=$(this),nivt=item.text(),n=item.attr('n'),p=item.attr('p');
        $('#n').val(n);
        $('#p').val(p);
        $('#ddniv').text(nivt);
    })
    $('#cau button.dropdown-item').on('click',function(e){
        e.preventDefault();
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
                        v+='<button type="button" class="dropdown-item " n='+el.ni+' p='+el.pi+'>'+el.niv+' '+el.gp+'</button>';
                    }
                }else{
                    v+='<button class="dropdown-item" >vide</button>';
                }
                s+=v+'</div></div>';
            }
            $('#a').val(aui);
            $('#ddau').text(aut);
            $('#au_ico').removeClass("fa fa-spinner fa-spin mr-2 text-primary");
            $('#cnp').html(s);
        },'json')
    })
    $('#abandon').bootstrapToggle({
        on: 'ABD',
        off: 'Non ABD',
        onstyle:'danger',
        offstyle:'primary',
        width: 100
    });
    $('#btn-export').click(function(e){
        e.preventDefault();
        $('#cmodal').modal('show');
    })
    $('#btn_confirm').click(function(e){
        e.preventDefault();
        $('#cmodal').modal('hide');
        var txt=$('#ddau').text()+' '+$('#ddniv').text();
        $('#anp').val(txt);
        $('#form-export').submit();
    })
    $('#cmodal').on('hidden.bs.modal',function(e){
        $('#c_txt').html('');
    })
    $('#fm').select2();
    $('#abandon').change(function(){
        $('#abd').val($(this).prop('checked'));
    })




})

