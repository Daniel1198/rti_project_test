$(document).ready(function(){
    $.ajax ({
        url: 'list1.php',
        dataType: 'html',
        success: function(list){
            $('#listEmission').html(list)
        }
    })
})