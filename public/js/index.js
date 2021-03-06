var pass = document.getElementById('pass');
var confirmPass = document.getElementById('confirmPass');
var pseudoCheck = document.getElementById("pseudo");
var mail = document.getElementById("mail");

// vérifie les deux mots de passes saisis
confirmPass.addEventListener("input", function(e) {
    if (confirmPass.value.length > 0) {
        if (pass.value === confirmPass.value) {
            $("#returnConfirmPass").css({ "background-image": "url('public/images/valider.png')" });
        }
        else{
            $("#returnConfirmPass").css({ "background-image": "url('public/images/croix.png')" });
        }
    }
});

// vérifie la longueur du mdp
pass.addEventListener("input", function (e) {
    if (pass.value.length >= 8) {
        msg = "Sufficient";
        msgColor = "green";
    } else if (pass.value.length >= 5) {
        msg = "Average";
        msgColor = "orange";
    }else{
        msg = "Low";
        msgColor = "red";
    }
    var returnPass = document.getElementById("returnPass");
    returnPass.textContent = msg + " length";
    returnPass.style.color = msgColor;
});

// vérifie si pseudo dispo ou déjà présent dans bdd
pseudoCheck.addEventListener('input',function () {
    if (pseudoCheck.value.length > 3) {
        $("#returnPseudo").text('Checking ...').fadeIn("slow");
        $.post("index.php?action=checkPseudo", { pseudo: $(this).val() }, function (data) {
            if (data == 'no') {
                $("#returnPseudo").show(function () {
                    $(this).html('Unavailable name').addClass('busy').fadeTo(900, 1);
                    $(this).css({ 'color': 'red' });
                });
            }
            else {
                $("#returnPseudo").show(function () {
                    $(this).html('Available name').addClass('dispo').fadeTo(900, 1);
                    $(this).css({ 'color': "green" });
                });
            }
        });
    }
    else{
        $("#returnPseudo").hide();
    }
});

// idem pour le mail
mail.addEventListener('input', function (){
    var reg = new RegExp("^[a-z0-9]+([_|.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|.|-]{1}[a-z0-9]+)*[.]{1}[a-z]{2,6}$", "i");
    if (reg.test(mail.value)){
        $("#returnMail").text('Checking ...').fadeIn("slow");
        $.post("index.php?action=checkMail", { mail: $(this).val() }, function (data) {
            if (data == 'no') {
                $("#returnMail").show(function () {
                    $(this).html('Unavailable mail').addClass('busy').fadeTo(900, 1);
                    $(this).css({ 'color': 'red' });
                });
            }
            else {
                $("#returnMail").show(function () {
                    $(this).html('Available mail').addClass('dispo').fadeTo(900, 1);
                    $(this).css({ 'color': "green" });
                });
            }
        });
    }
    else {
        $("#returnMail").hide();
    }
});

// si php retourne une erreur alors affiche incorrect
function errorCo(){
    var error = document.getElementById('returnCoError');
    error.innerHTML = "Incorrect informations";
}

