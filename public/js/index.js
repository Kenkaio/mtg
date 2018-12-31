var pass = document.getElementById('pass');
var confirmPass = document.getElementById('confirmPass');
var pseudoCheck = document.getElementById("pseudo");
var mail = document.getElementById("mail");

var sendPseudo = false;
var sendPass = false;
var sendMail = false;
var send = false;

confirmPass.addEventListener("input", function(e) {
    if (confirmPass.value.length > 0) {
        if (pass.value === confirmPass.value) {
            $("#returnConfirmPass").css({ "background-image": "url('public/images/valider.png')" });
            sendPass = true;
        }
        else{
            $("#returnConfirmPass").css({ "background-image": "url('public/images/croix.png')" });
            sendPass = false;
        }
    }
});

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

pseudoCheck.addEventListener('input',function () {
    if (pseudoCheck.value.length > 3) {
        $("#returnPseudo").text('Checking ...').fadeIn("slow");
        $.post("controllers/checks.php", { pseudo: $(this).val() }, function (data) {
            if (data == 'no') {
                $("#returnPseudo").show(function () {
                    $(this).html('Unavailable name').addClass('busy').fadeTo(900, 1);
                    $(this).css({ 'color': 'red' });
                    sendPseudo = false;
                });
            }
            else {
                $("#returnPseudo").show(function () {
                    $(this).html('Available name').addClass('dispo').fadeTo(900, 1);
                    $(this).css({ 'color': "green" });
                    sendPseudo = true;
                });
            }
        });
    }
    else{
        $("#returnPseudo").hide();
        sendPseudo = false;
    }
});

mail.addEventListener('input', function (){
    var reg = new RegExp("^[a-z0-9]+([_|.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|.|-]{1}[a-z0-9]+)*[.]{1}[a-z]{2,6}$", "i");
    if (reg.test(mail.value)){
        $("#returnMail").text('Checking ...').fadeIn("slow");
        $.post("controllers/checks.php", { mail: $(this).val() }, function (data) {
            if (data == 'no') {
                $("#returnMail").show(function () {
                    $(this).html('Unavailable mail').addClass('busy').fadeTo(900, 1);
                    $(this).css({ 'color': 'red' });
                    sendMail = false;
                });
            }
            else {
                $("#returnMail").show(function () {
                    $(this).html('Available mail').addClass('dispo').fadeTo(900, 1);
                    $(this).css({ 'color': "green" });
                    sendMail = true;
                });
            }
        });
    }
    else {
        $("#returnMail").hide();
        sendMail = false;
    }
});


setInterval(() => {
    if (sendMail && sendPass && sendPseudo) {
        $('#confirmSignUp').fadeIn(500);
    }
    else{
        $('#confirmSignUp').hide();
    }
}, 500);

