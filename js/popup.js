$(document).ready(function () {
    $(".showPopup").click(function () {
        action($(this).data("url"), $(this).data("user"));
    })

    function action(url, data) {
        var datas = {
            user: data
        };

        $.ajax({
            type: 'POST',
            url: url,
            data: datas,
            dataType: 'html',
            success: function (data) {
                var emplacementComposant = $("main");
                emplacementComposant.prepend(data); // Ajouter le contenu des données HTML

                $("#popup_close").on("click", function () {
                    $(".popup-main").remove();
                });
            },
            error: function () {
                console.log("Erreur");
            }
        });
    }
});