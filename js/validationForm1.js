$(document).ready(function(){
    // Code de validation de formulaire
    let fields = $('#form1 :required');

    fields.each(function(i, field){
        $(field).focus(function(){
            resetField($(this))
        });

        $(field).blur(function(){
            validateField(field);
        })
    })


    $('#form1').submit(function(event){
        event.preventDefault();
        fields.each(function(i, elt){
            resetField($(elt))
        })
        let valid = true;

        fields.each(function(i, field){
            if (!validateField(field)){
                valid = false;
            }
        })

        // code d'actualisation du div qui contient la liste des enregitrements
        let actualise = setInterval(refresh, 1000)
        
        // en cas de formulaire valide, transmettre les données du formulaire à la page addData.php
        if (valid){
            if ($('input[name=minutes]').val() || $('input[name=heures]').val()) {
                $.ajax ({
                    url: 'addData.php',
                    type: 'POST',
                    data: $('#form1, .modal-dialog').serialize(),
                    dataType: 'html',
                    success: function(guestList){
                        $('#result').html(guestList)
                        fields.each(function(i, elt){
                            resetField($(elt))
                        })
                    }
                })
                
                // Appel de la variable d'actualisation
                actualise
                
            }
            else {
                alert('Veuillez renseigner la durée svp');
            }
        }

        function refresh() {
            $.ajax ({
                url: 'list1.php',
                dataType: 'html',
                success: function(list){
                    $('#listEmission').html(list)
                    // arrêt de la fonction d'actualisation de la page
                    clearInterval(actualise)
                }
            })
        }

    })

    function validateField(field){
        if (field.checkValidity()){
            $(field).addClass('valid');
            return true;
        }
        else {
            $(field).addClass('invalid');
            $(`<span class="msg">${field.validationMessage}</span>`).insertAfter($(field))
            return false;
        }
    }

    function resetField(field){
        $(field).next().remove()
        $(field).removeClass('invalid')
        if ($(field).hasClass('valid')) {
            $(field).removeClass('valid')
        }
    }

    // fin du code de validation
})