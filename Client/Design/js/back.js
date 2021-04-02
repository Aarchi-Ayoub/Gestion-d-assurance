/* Login page */
$(function(){
    $('.ins').hide();
    $('.body-page h1 span.text-primary').click(function(){
        $('.ins').hide();
        $('.cnx').show();
    })
    $('.body-page h1 span.text-success').click(function(){
        $('.cnx').hide();
        $('.ins').show();
    })
});
/* Login page */
