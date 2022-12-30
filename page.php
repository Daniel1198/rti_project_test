<div class="d-flex justify-content-end mb-2">
    <button class="rounded-pill px-4 py-1" type="button" id="addData" data-bs-toggle="collapse" data-bs-target="#formulaire" aria-expanded="false" aria-controls="formulaire">Ajouter des données</button>
</div>
<div class="collapse mb-3" id="formulaire">
<form class="row pt-3 mb-3 px-4 mx-3" style="border: 1px solid rgba(206, 113, 0, 0.2);" id="form1" novalidate>

    <!-- conteneur d'affichage du resultat de la requête d'ajout de données -->
    <div id="result"></div>

    <!-- champ contenant le choix des libéllés -->
    <div class="form-group mb-3">
        <label for="" class="form-label">Libéllé</label>
        <select name="libelle" class="form-select form-select-sm" required>
            <option value="">--- Choisir le libéllé de l'emission ---</option>
            <option value="Debat politique">Debat politique</option>
            <option value="Debat sociétal">Debat sociétal</option>
        </select>
    </div>

    <div class="col-8">
        <div class="form-group mb-3">
            <label for="" class="form-label">Présentateur</label>
            <input type="text" name="presentateur" id="" class="form-control form-control-sm" required>
        </div>

        <div class="form-group mb-3">
            <label for="" class="form-label">Thème</label>
            <input type="text" name="theme" id="" class="form-control form-control-sm" required>
        </div>

        <div class="form-group mb-3">
            <label for="" class="form-label">Réalisateur</label>
            <input type="text" name="realisateur" id="" class="form-control form-control-sm" required>
        </div>
    </div>

    <div class="col-4 align-items-start">
        <div class="form-group mb-3">
            <label for="" class="form-label">Date</label>
            <input type="date" name="date" id="" class="form-control form-control-sm" required>
        </div>

        <div class="form-group mb-3">
            <label for="" class="form-label">Durée</label>
            <div class="d-flex">
                <div class="input-group">
                    <input type="number" name="heures" id="heure" min="0" max="23" placeholder="00" class="form-control form-control-sm">
                    <a class="btn btn-sm">H</a>
                </div>

                <div class="input-group">
                    <input type="number" name="minutes" id="minute" min="0" max="59" placeholder="00" class="form-control form-control-sm">
                    <a class="btn btn-sm">MIN</a>
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="" class="form-label">Diffusion directe</label>
            <div class="input-group">
                <input type="text" name="chaine" id="" class="form-control form-control-sm" value="RTI" readonly>
                <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addGuest" type="button"><i class="fas fa-users"></i> Invités</button>
            </div>
        </div>
    </div>
    
    <!-- conteneur d'affichage de la liste des invités -->
    <div id="guestList" class="mb-3"></div>

    <div class="mb-3 mt-1 justify-content-center d-flex">
        <input type="submit" value="Enregistrer" class="btn btn-success w-25 rounded-pill">
    </div>

    
</form>
</div>

<div class="d-flex align-items-center">
    <form id="formSearch" class="input-group d-flex align-items-center rounded-pill ps-3 py-1 mb-3 me-5" style="width: 500px; background-color: rgb(240, 240, 240);">
        <i class="fas fa-search me-2" style="font-size: small;"></i>
        <input type="search" name="search" id="search" placeholder="Rechercher thème, présentateur" style="background-color: rgb(240, 240, 240);">
    </form>

    <p style="font-size: small; font-weight: bold;">Filtrer <i class="fas fa-filter" style="color: rgb(206, 113, 0)"></i> :</p>
        
    <div class="input-group w-25 pb-3 ms-2">
        <input type="date" name="" id="date1" class="form-control form-control-sm">
        <input type="date" name="" id="date2" class="form-control form-control-sm">
    </div>

    <select id="filterByLib" class="form-select form-select-sm ms-2 mb-3" style="width: 150px;">
        <option value="">--- Choisir le débat ---</option>
        <option value="Debat politique">Débat politique</option>
        <option value="Debat sociétal">Débat sociétal</option>
    </select>
</div>

<!-- conteneur permettant l'affichage de la liste des enregistrements -->
<div class="p-3 small-shadow" id="listEmission"></div>

<button class="btn btn-outline-success btn-sm float-end me-3" id="displayAll">Tout afficher</button><br><br>