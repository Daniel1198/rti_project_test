<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icon/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/background.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title>RTI Bilan</title>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/validationForm1.js"></script>
    <script src="js/validationForm2.js"></script>
    <script src="js/load.js"></script>
    <script src="js/search.js"></script>
    <script>
        $(document).ready(function(){
            // rechargement de la page lorsqu'on clique sur le bouton tout afficher
            $('#displayAll').click(function(){
                location.reload()
            })
        })
    </script>

    <style>
        /* masquer la barre de défilement */
        ::-webkit-scrollbar {
            display: none;
        }

        tbody {
            font-size: small;
        }

        tbody tr {
            transition: 0.3s;
        }
        tbody tr:hover {
            transform: scale(1.03);
            box-shadow: 0px 1px 1px grey;
        }
    </style>
</head>
<body style="font-family: Ubuntu;">
    <div class="container-fluid row g-0">
        <div class="col-2 align-items-center d-flex justify-content-center" style="height: 100vh;">

        <!-- div de background en slide -->
            <div class="bg"></div>
            <div class="bg bg2"></div>
            <div class="bg bg3"></div>

            <div class="">
                <center><img src="icon/icon.png" alt="" width="80"></center>
                <p class="text-white mt-2" style="font-family: Righteous; font-size:10px">Radiodiffusion Télévision Ivoirienne</p>
                <div class="mt-5">
                    <a href="savetopdf.php" class="d-block w-100 btn-sm rounded-pill mb-3 d-none" style="font-size: small;">Exporter au format PDF</a>
                    <a href="savetoxlsx.php" class="d-block w-100 btn-sm rounded-pill" style="font-size: small;">Exporter au format XLSX</a>
                </div>
            </div>
        </div>
        <div class="col-10 p-3 overflow-auto bg-white disable-scrollbars" style="height: 100vh;">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active link-success" id="nav-deb1-tab" data-bs-toggle="tab" data-bs-target="#nav-debat1" type="button" role="tab" aria-controls="nav-debat1" aria-selected="true" style="font-family: Righteous;">ACCUEIL</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade show active pt-3" id="nav-debat1" role="tabpanel" aria-labelledby="nav-deb1-tab">  
                    <?php include('page.php'); ?>  
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addGuest" tabindex="-1" aria-labelledby="addGuest">
        <form class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="" class="form-label">Nombre d'invités</label>
                    <input type="number" value="1" min="1" id="guestNumber" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Invité 1</label>
                    <input type="text" class="form-control form-control-sm" name="invite1" required>
                </div>
            </div>

            <div class="modal-footer border-0">
                <input type="button" id="ad" value="Ajouter" data-bs-dismiss="modal" class="btn btn-success btn-sm">
            </div>
        </form>
    </div>
</body>
</html>