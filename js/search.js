$(document).ready(function(){

    // transmettre le contenu du champ de recherche à la page search.php lorsque lors de la 
    // saisie dans le champ la touche du clavier est relâchée puis affichage du contenu
    // dans le div ayant pour id listEmission
    $('#search').keyup(function(){
        $.ajax ({
            url: 'search.php',
            type: 'POST',
            data: {
                search: $('#search').val(),
                libelle: $('#filterByLib').val(),
                date1: $('#date1').val(),
                date2: $('#date2').val(),
            },
            dataType: 'html',
            success: function(guestList){
                $('#listEmission').html(guestList)
            }
        })
    })

    $('#filterByLib').change(function(){
        $.ajax ({
            url: 'search.php',
            type: 'POST',
            data: {
                libelle: $('#filterByLib').val(),
                search: $('#search').val(),
                date1: $('#date1').val(),
                date2: $('#date2').val(),
            },
            dataType: 'html',
            success: function(guestList){
                $('#listEmission').html(guestList)
            }
        })
    })

    $('#date1').change(function(){
        $.ajax ({
            url: 'search.php',
            type: 'POST',
            data: {
                libelle: $('#filterByLib').val(),
                search: $('#search').val(),
                date1: $('#date1').val(),
                date2: $('#date2').val(),
            },
            dataType: 'html',
            success: function(guestList){
                $('#listEmission').html(guestList)
            }
        })
    })

    $('#date2').change(function(){
        $.ajax ({
            url: 'search.php',
            type: 'POST',
            data: {
                libelle: $('#filterByLib').val(),
                search: $('#search').val(),
                date1: $('#date1').val(),
                date2: $('#date2').val(),
            },
            dataType: 'html',
            success: function(guestList){
                $('#listEmission').html(guestList)
            }
        })
    })
})