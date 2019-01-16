// création liste deck
if (document.getElementById("newList") != null) {
    var search = document.getElementById("newList");
    var list = document.getElementById("returnList");

    // affiche la liste des cartes valides
    search.addEventListener('input', function () {
        $("#checking").text('Checking ...').fadeIn("slow");
        $.post("../controllers/list.php", { cardList: $(this).val() }, function (data) {
            $("#returnList").fadeIn(function() {
            list.innerHTML = data;
            });
        });
        $("#checking").text("").fadeOut();
    });

    // affiche le détail de la carte
    list.addEventListener("mouseover", function (event) {
        // met en surbrillance la cible de mouseover
        if (event.target.className == "cardList") {
            var div = document.getElementById("li" + event.target.id);
            $(div).css({
                'display': 'block'
            });
        }

    }, false);

    // enlève le détail de la carte
    list.addEventListener("mouseout", function (event) {
        // met en surbrillance la cible de mouseover
        if (event.target.className == "cardList") {
            var div = document.getElementById("li" + event.target.id);
            $(div).css({
                'display': 'none'
            });
        }
    }, false);

    /*------- xml en fonction des navigateurs -------*/
    function getXhr() {
        var xhr = null;
        if (window.XMLHttpRequest) // Firefox et autres
            xhr = new XMLHttpRequest();
        else if (window.ActiveXObject) { // Internet Explorer
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
        else { // XMLHttpRequest non supporté par le navigateur
            alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
            xhr = false;
        }
        return xhr;
    }

    var xhr = getXhr();
    var xhrNumbers = getXhr();

    xhrNumbers.onreadystatechange = function () {
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if (xhrNumbers.readyState == 4 && xhrNumbers.status == 200) {
            var response = JSON.parse(xhrNumbers.responseText);
            for (var key in response) {
                var value = response[key];
                var div = document.getElementById(key + "sNumber");
                console.log(div);
                div.innerHTML = ' ('+ value +')';

                $("#" + key + "sNumber").fadeIn();
            }
        }
    }

    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function () {
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            for (var key in response) {
                var value = response[key];
                var div = document.getElementById(key + "sCards");
                div.innerHTML = "<h1>" + key.toUpperCase() + "<span id='" + key +"sNumber' class='numbersSpan'></span></h1>";
                for (let index = 0; index < value.length; index++) {
                    cardListDetail = document.createElement("li");
                    if (value[index].indexOf("Island(Number") == 0 || value[index].indexOf("Swamp(Number") == 0 || value[index].indexOf("Mountain(Number") == 0 || value[index].indexOf("Forest(Number") == 0 || value[index].indexOf("Plains(Number") == 0) {
                        var words = value[index].split("(");
                        var numberSplit = value[index].split("Number");
                        var number = numberSplit[1].split(")");
                        cardListDetail.innerHTML = words[0] + ' x <input id="number' + words[0] + '" type="number" value="' + number[0] + '" min="1" max="99" class="inputNumberCards" onchange="inputNumber(this)" ></input>';
                        cardListDetail.id = "detail" + words[0];
                    } else {
                        cardListDetail.innerHTML = value[index];
                        cardListDetail.id = "detail" + value[index];
                    }

                    div.appendChild(cardListDetail);
                }

                $("#" + key + "sCards").fadeIn();
            }
            xhrNumbers.open("GET", "../public/assets/json/numbersCards.json", true);
            xhrNumbers.send(null);
        }
    }

    // ajoute la carte
    $("#returnList").on("click", function (event){
        if(event.target.className == 'cardList'){
            $.post("../controllers/checks.php", { addCardToList: event.target.id }, function (data) {
                if (data === "added"){
                    li = document.getElementById("detail" + event.target.id);
                    li.style.color = "red";
                    li.style.transition = "1s";
                    setTimeout(() => {
                      li.style.color = "white";
                      li.style.transition = "1s";
                    }, 1000);
                }else{
                    xhr.open("GET", "../public/assets/json/list.json", true);
                    xhr.send(null);
                }
            });
        }
    });
}

// comme précédent mais pour le commander
if (document.getElementById("selectCommander") != null) {

    var commander = document.getElementById("selectCommander");

    commander.addEventListener('input', function () {
        $("#checkingCommander").text('Checking ...').fadeIn("slow");
        $.post("../controllers/checks.php", { selectCommander: $(this).val() }, function (data) {
            $("#returnCommander").fadeIn(function() {
                document.getElementById("returnCommander").innerHTML = data;
            });
        });
        $("#checkingCommander").text("").fadeOut();
    });

    $("#returnCommander").on("click", function (event) {
        if (event.target.className == 'commanderList') {
            $.post("../controllers/checks.php", { addCommander: event.target.id }, function (data) {

            });
            window.location.reload();
        }
    });
}

// confirme la liste
if (document.getElementById("confirmList") != null) {

    var confirm = document.getElementById("confirmList");
    $("#confirmList").on("click", function () {
        $.post("../controllers/checks.php", { confirmList: "confirm list" }, function (data) {

        });
        window.location.reload();
    });
}


// affiche la liste
function seeDiv(data) {
    for (var key in data) {
        var value = data[key];
        var div = document.getElementById(key + "sCards");
        div.innerHTML = "<h1>" + key.toUpperCase() + "<span id='" + key + "sNumber' class='numbersSpan'></span></h1>";
        for (let index = 0; index < value.length; index++) {
            cardListDetail = document.createElement("li");
            if (value[index].indexOf("Island(Number") == 0 || value[index].indexOf("Swamp(Number") == 0 || value[index].indexOf("Mountain(Number") == 0 || value[index].indexOf("Forest(Number") == 0 || value[index].indexOf("Plains(Number") == 0) {
                var words = value[index].split("(");
                var numberSplit = value[index].split("Number");
                var number = numberSplit[1].split(")");
                cardListDetail.innerHTML = words[0] + ' x <input id="number' + words[0] + '" type="number" value="' + number[0] + '" min="1" max="99" class="inputNumberCards" onchange="inputNumber(this)" ></input>';
                cardListDetail.id = "detail" + words[0];
            } else {
                cardListDetail.innerHTML = value[index];
                cardListDetail.id = "detail" + value[index];
            }

            div.appendChild(cardListDetail);
        }

        $("#" + key + "sCards").fadeIn();
    }
}

function seeHistoric(date, id){
    historicList = document.createElement('li');
    historicList.id = "date" + id;
    historicList.innerHTML = date;
    historicList.onclick = function (event) {
        $.post("../controllers/checks.php", { oldList: event.target.id }, function (data) {
            $("#commandersCards").html("");
            $("#landsCards").html("");
            $("#creaturesCards").html("");
            $("#artifactsCards").html("");
            $("#enchantmentsCards").html("");
            $("#spellsCards").html("");
            var response = JSON.parse(data);
            for (var key in response) {
                var value = response[key];
                var div = document.getElementById(key + "sCards");
                div.innerHTML = "<h1>" + key.toUpperCase() + "<span id='" + key + "sNumber' class='numbersSpan'></span></h1>";
                for (let index = 0; index < value.length; index++) {
                    cardListDetail = document.createElement("li");
                    if (value[index].indexOf("Island(Number") == 0 || value[index].indexOf("Swamp(Number") == 0 || value[index].indexOf("Mountain(Number") == 0 || value[index].indexOf("Forest(Number") == 0 || value[index].indexOf("Plains(Number") == 0) {
                        var words = value[index].split("(");
                        var numberSplit = value[index].split("Number");
                        var number = numberSplit[1].split(")");
                        cardListDetail.innerHTML = words[0] + ' x <input id="number' + words[0] + '" type="number" value="' + number[0] + '" min="1" max="99" class="inputNumberCards" onchange="inputNumber(this)" ></input>';
                        cardListDetail.id = "detail" + words[0];
                    } else {
                        cardListDetail.innerHTML = value[index];
                        cardListDetail.id = "detail" + value[index];
                    }

                    div.appendChild(cardListDetail);
                }

                $("#" + key + "sCards").fadeIn();
            }
        });
    };
    xhrNumbers.open("GET", "../public/assets/json/numbersCards.json", true);
    xhrNumbers.send(null);
    document.getElementById("historic").appendChild(historicList);
}

function inputNumber(event){
    number = event.value;
    $.post("../controllers/checks.php", { changeNumber: number, numberId: event.id }, function (data) {
        xhrNumbers.open("GET", "../public/assets/json/numbersCards.json", true);
        xhrNumbers.send(null);
    });
}


