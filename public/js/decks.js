const card = {

    id: '',
    name: '',
    cost: '',
    colors: '',
    type: '',
    text: '',
    atk: '',
    toug: '',
    commander: false

}


var search = document.getElementById("newList");
search.addEventListener('input', function () {
    var list = document.getElementById("returnList");
    var tableList = document.getElementById("listDetail");
    var arrayCard = [];
    var type = $("#listTitle").attr('class');
    $("#returnList").css({ display: "none" });

    if (search.value.length > 2) {
        $("#checking").text('Checking ...').fadeIn("slow");
        $.getJSON("../public/assets/json/AllCards.json", function (donnees) {
            var valueUpper = search.value.toUpperCase();
            var data = new RegExp(valueUpper);

            var lignReturn = new RegExp('\n');

            $.each(donnees, function (i, field) {
                if (data.exec(field.name.toUpperCase())) {
                    if(field.manaCost != undefined){
                        if (field.legalities.duel == "Legal" || field.legalities.duel == "Restricted") {

                            const newCard = Object.create(card);
                            if (type == "Duel" && field.type.substr(0, 18) == "Legendary Creature") {
                                newCard.commander = true;
                                newCard.commander.innerHTML = "field.name";
                            }
                            newCard.id = "card" + i;
                            newCard.name = field.name;
                            newCard.colors = field.colorIdentity;
                            newCard.type = field.type;

                            for (let index = 0; index < 1; index++) {
                                /([0-9]+)/.exec(field.manaCost);
                                var num = RegExp.$1;
                                field.manaCost = field.manaCost.replace("{" + num + "}", "<img src='../public/images/mana/" + num + ".png'/>");
                            }
                            for (let index = 0; index < 10; index++) {
                                /([0-9]+)/.exec(field.text);
                                var num = RegExp.$1;
                                field.text = field.text.replace("{" + num + "}", "<img src='../public/images/mana/" + num + ".png'' width='20px'/>");
                            }
                            for (let index = 0; index < 10; index++) {
                              regex = /[A-Z][\/][A-Z]/g;
                              var newRegex = regex.exec(field.manaCost);
                                if(newRegex != null){
                                    field.manaCost = field.manaCost.replace("{" + newRegex[0] + "}", "<img src='../public/images/mana/" + newRegex[0][0] + "" + newRegex[0][2] + ".png'' width='20px'/>");
                                }
                            }
                            for (let index = 0; index < 10; index++) {
                                regex = /[A-Z][\/][A-Z]*/g;
                                var newRegex = regex.exec(field.text);
                                if (newRegex != null) {
                                    field.text = field.text.replace("{" + newRegex[0] + "}", "<img src='../public/images/mana/" + newRegex[0][0] + "" + newRegex[0][2] + ".png'' width='20px'/>");
                                }
                            }
                            for (let index = 0; index < 10; index++) {
                                regex = /{[A-Z]}/g;
                                var newRegex = regex.exec(field.text);
                                if (newRegex != null) {
                                    field.text = field.text.replace(newRegex[0], "<img src='../public/images/mana/" + newRegex[0][1]+".png'' width='20px'/>");
                                    field.manaCost = field.manaCost.replace(newRegex[0], "<img src='../public/images/mana/" + newRegex[0][1] + ".png'/>");
                                }
                            }
                            for (let index = 0; index < 10; index++) {
                                regex = /{[A-Z]}/g;
                                var newRegex = regex.exec(field.manaCost);
                                if (newRegex != null) {
                                    field.manaCost = field.manaCost.replace(newRegex[0], "<img src='../public/images/mana/" + newRegex[0][1] + ".png'/>");
                                }
                            }

                            var newText = field.text.replace(lignReturn, '<br />');
                            newCard.text = newText;
                            if (field.power == undefined) {
                                newCard.atk = ' ';
                                newCard.toug = ' ';
                            }
                            else{
                                newCard.atk = field.power;
                                newCard.toug = "/ " + field.toughness;
                            }
                            newCard.cost = field.manaCost;
                            arrayCard.push(newCard);
                        }
                    }
                }
            });

            list.innerHTML = '';
            tableList.innerHTML = "";
            for (let index = 0; index < 10 && index < arrayCard.length; index++) {
                list.innerHTML += '<li class="cardList" id="' + arrayCard[index].name + '">' + arrayCard[index].name + '</li>';
                tableList.innerHTML +=
                    '<div id="li' + arrayCard[index].name + '"><div id="nameCard"><div id="titleCard">' + arrayCard[index].name + '</div><div id="manaImg">' + arrayCard[index].cost + '</div></div><div><div id="cardType">' + arrayCard[index].type + '</div></div><div><div>' + arrayCard[index].text + '</div></div><div><div id="atkToug">' + arrayCard[index].atk +' '+ arrayCard[index].toug +'</div></div></div>';
            }
            $("#checking").text("").fadeOut();
            $("#returnList").css({ display: "block" });

            if (arrayCard.length == 0) {
                $("#returnList").css({ display: "none" });
            }
        });
    }
});


var test = document.getElementById("returnList");
test.addEventListener("mouseover", function (event) {
    // met en surbrillance la cible de mouseover
    if (event.target.className == "cardList"){
        $("#listDetail").show();
        var div = document.getElementById("li" + event.target.id);
        $(div).css({
            'display' : 'block'
        });
    }

}, false);

test.addEventListener("mouseout", function (event) {
    // met en surbrillance la cible de mouseover
    if (event.target.className == "cardList") {
        $("#listDetail").hide();
        var div = document.getElementById("li" + event.target.id);
        $(div).css({
            'display': 'none'
        });
    }
}, false);

search.value = "Card name";
search.style.color = "grey";
search.style.fontStyle = "italic";
search.addEventListener("focus", function () {
    if (this.value == "Card name") {
        search.value = "";
        search.style.color = "black";
        search.style.fontStyle = "normal";
    }
});
search.addEventListener("blur", function () {
    if (this.value == '') {
        search.value = "Card name";
        search.style.color = "grey";
        search.style.fontStyle = "italic";
    }
});
