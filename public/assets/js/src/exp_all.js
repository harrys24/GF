$(function(){
    $('#cau button.dropdown-item').on('click',function(e){
        e.preventDefault();
        $('#au_ico').addClass("fa fa-spinner fa-spin mr-2 text-primary");
        $('#ceih').html('<i>Efféctifs : ?</i>');
        $('#cei').html('');
        var aui=$(this).attr('ai'),aut=$(this).text();
        $('#a').val(aui);
        $('#ddau').text(aut);
        $('#au_ico').removeClass("fa fa-spinner fa-spin mr-2 text-primary");
        
    })
    $('#cnp button.dropdown-item').on('click',function(e){
        e.preventDefault();
        var item=$(this),nivt=item.text(),n=item.attr('n');
        $('#n').val(n);
        $('#ddniv').text(nivt);
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

