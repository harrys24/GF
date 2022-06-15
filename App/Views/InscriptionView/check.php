<div class="container">
<div id="ckdossier" class="row mt-4">
<input type="checkbox" name="ckitem" class="m-3" value="orange" id="">
<input type="checkbox" name="ckitem" class="m-3" value="bleu" id="">
<input type="checkbox" name="ckitem" class="m-3" value="vert" id="">
<input type="checkbox" name="ckitem" class="m-3" value="rouge" id="">
</div>
<button id='btnv' class="btn btn-primary">tester</button>
</div>
<script>

$('#btnv').click(function(){
    var ls=[];
    $('#ckdossier input:checked').each(function(){
        ls.push($(this).val());
    })
    console.log(ls.join(','));
    
});
</script>