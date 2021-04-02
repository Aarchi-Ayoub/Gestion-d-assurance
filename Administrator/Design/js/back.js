//Button supprimer
$('#delete').on('click',function(event){
    event.preventDefault();
    const href = $(this).attr('href');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result)=>{
        if(result.value){
            document.location.href = href;
        }
    });
});
//Button activer
$('#activate').on('click',function(event){
    event.preventDefault();
    const href = $(this).attr('href');
    Swal.fire(
        'Activate !',
        'This compte has been activate.',
        'success'
    ).then((result)=>{
        if(result.value){
            document.location.href = href;
        }
    });
});

//Annexe form Home (Show/Hide)
$('#annex-show').hide();
$(function(){
    $('#annexe-no').on('click',function(){
        $('#annex-show').hide();
        $('#annex-show input').removeAttr('required');
    });
    $('#annexe-oui').click(function(){
        $('#annex-show').show();
        $('#annex-show input').attr('required','true');
    });
});
//Securite form Home (Show/Hide)
$('#securite-show').hide();
$(function(){
    $('#securite-no').on('click',function(){
        $('#securite-show').hide();
        $('#securite-show input').removeAttr('required');
    });
    $('#securite-oui').click(function(){
        $('#securite-show').show();
        $('#securite-show input').attr('required','true');
    });
});
//Club form Hobbies
$('#club-nom').attr('disabled','true');
$(function(){
    $('#club-no').on('click',function(){
        $('#club-nom').attr('disabled','true');
    });
    $('#club-oui').click(function(){
        $('#club-nom').removeAttr('disabled');
        $('#club-nom').focus();
        $('#club-nom').attr('required','true');
    });
});