$(function(){
$('input[type=file]').change(function (e){
    $(this).next('.custom-file-label').text(e.target.files[0].name);
});
$('#upload-form').on('submit',function(e){
    e.preventDefault();
    var fd=new FormData(this);
    $.ajax({
        url:'/upload/abd_check',
        type:'post',
        data:fd,
        // dataType:'json',
        cache:false,
        contentType:false,
        processData:false,
        success:function(res){
            console.log(res);
            if (res=='ok') {
                toastr.success('Fichier uploadé !')
            } else {
                toastr.error('Erreur Fichier !')
            }
        }
    })
})


})