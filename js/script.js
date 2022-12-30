$(document).ready(function(){

    // Ajouter un nombre de champs de saisie correspondant à la valeur définie par l'utilisateur
    // lorsqu'il souhaite enregistrer un ou plusieurs invités
    $('#guestNumber').change(function(){
        $(this).parent().nextAll().remove()
        for (let i=$(this).val(); i>=1; i--){
                $(`<div class="form-group">
                <label for="" class="form-label">Invité ${i}</label>
                <input type="text" class="form-control form-control-sm" name="invite${i}" required>
            </div>`).insertAfter($(this).parent())
        }
    });

    // <div class="d-flex align-items-center input-group">
    //                 <input type="text" class="form-control form-control-sm" name="invite${i}" required>
    //                 <a href="#" id="remove"><i class="fas fa-window-close link-danger rounded-pill ms-2"></i></a>
    //             </div>

    // transmettre le contenu de chaque champs de saisies créés à la page addGuest.php
    // puis retourner le contenu de cette page dans le div ayant pour id guestList
    $('#ad').click(function(){
        $.ajax ({
            url: 'addGuest.php',
            type: 'POST',
            data: $('.modal-dialog').serialize(),
            dataType: 'html',
            success: function(guestList){
                $('#guestList').html(guestList)
            }
        })
    })

    // if ($('.modal').show()){
    //     $('#remove').click(function(){
    //         $(this).parent().parent().remove();
    //     })
    // }
})