$.post("checks.php", { members: "" }, function (data) {
    $('#membersConnected').html(data);
});

setInterval(() => {
    $.post("checks.php", { members: "" }, function (data) {
            $('#membersConnected').html(data);
    });
}, 5000);
