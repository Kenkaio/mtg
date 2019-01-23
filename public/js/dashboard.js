//retourne la liste des membres connectés en ajax
$.post("index.php?action=membersList", { members: "" }, function(data) {
    $("#membersConnected").html(data);
});

if (document.getElementById("selectDate") != null) {
    valueMatches = document.getElementById("selectDate").value;

    //répète l'opération toute les 5"
    setInterval(() => {
        $.post("index.php?action=membersList", { members: "" }, function(data) {
            $("#membersConnected").html(data);
        });
    }, 5000);

    var date = [];
    var pointsUser = [];
    var pointsOpponent = [];
    var backgroundColorUser = [];
    var backgroundColorOpponent = [];

    // déclaration html request en fonction du navigateur
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
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function () {
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if (xhr.readyState == 4 && xhr.status == 200) {
            objectMatches = JSON.parse(xhr.response);

            date = [];
            pointsUser = [];
            pointsOpponent = [];
            for (let index = 0; index < objectMatches.length; index++) {
                i = objectMatches[index].date[5] + objectMatches[index].date[6];

                if (pointsUser[i-1] == null) {
                    pointsUser.push(parseInt(objectMatches[index].pointsUser));
                }
                else{
                    pointsUser[i - 1] += parseInt(objectMatches[index].pointsUser);
                }
                if (pointsOpponent[i - 1] == null) {
                    pointsOpponent.push(parseInt(objectMatches[index].pointsOpponent));
                }
                else {
                    pointsOpponent[i - 1] += parseInt(objectMatches[index].pointsOpponent);
                }
                switch (i - 1) {
                    case 0: if (date.indexOf("January") == -1) { date.push("January"); }
                        break;
                    case 1: if (date.indexOf("February") == -1) { date.push("February"); }
                        break;
                    case 2: if (date.indexOf("March") == -1) { date.push("March"); }
                        break;
                    case 3: if (date.indexOf("April") == -1) { date.push("April"); }
                        break;
                    case 4: if (date.indexOf("May") == -1) { date.push("May"); }
                        break;
                    case 5: if (date.indexOf("June") == -1) { date.push("June"); }
                        break;
                    case 6: if (date.indexOf("July") == -1) { date.push("July"); }
                        break;
                    case 7: if (date.indexOf("August") == -1) { date.push("August"); }
                        break;
                    case 8: if (date.indexOf("September") == -1) { date.push("September"); }
                        break;
                    case 9: if (date.indexOf("October") == -1) { date.push("October"); }
                        break;
                    case 10: if (date.indexOf("November") == -1) { date.push("November"); }
                        break;
                    case 11: if (date.indexOf("December") == -1) { date.push("December"); }
                        break;
                }
                backgroundColorUser.push("rgb(255, 255, 255)");
                backgroundColorOpponent.push("rgb(255, 0, 0)");
            }
        }
    }

    xhr.open("GET", "public/assets/json/arrayMatches.json", true);
    xhr.send(null);

    // affiche un graphique des matche de l'utilisateur, par années
    function myChart(){
        var ctx = document.getElementById("myChart").getContext('2d');
        window.char = new Chart(ctx, {
        type: "bar",
        data: {
            labels: date,
            datasets: [
            {
                label: 'Victories',
                data: pointsUser,
                backgroundColor: backgroundColorUser
            },
            {
                label: 'Defeats',
                data: pointsOpponent,
                backgroundColor: backgroundColorOpponent
            }
            ]
        },
        options: {
            legend: {
                labels: {
                    fontSize: 16,
                    fontColor: 'white'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            responsive: true
        }
        });
    }

    window.onload = function(){
        myChart();
    }

    // affiche les 5 derniers matchs de l'utilisateur
    document.getElementById("selectDate").onchange = function() {
        char.destroy();
        $.post("index.php?action=matchesByYear", { matches: this.value }, function () {});
        setTimeout(() => {
            xhr.open("GET", "public/assets/json/arrayMatches.json", true);
            xhr.send(null);
        }, 500);
        setTimeout(() => {
            myChart();
        }, 1000);
    };
}

function addActive(id){
    $("#menuDashboard li").removeClass("active");
    $(id).addClass("active");
}

