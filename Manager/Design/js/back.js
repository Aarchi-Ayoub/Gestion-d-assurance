$(function(){
    'use strict';
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
});

