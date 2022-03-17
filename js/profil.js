$(document).ready(function () {

    console.log("test profil");
    var newImageUrl;

    //Envoyer le formulaire ajout module
    $(".btn-modify-avtar").on("change", function (e) {
        console.log("test");
        //Upload de l'image
        var file_data = $('.btn-modify-avtar').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            url: './php/uploadImg.php', // <-- point to server-side PHP script 
            dataType: 'text', // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (urlImage) {
                //Ajout 
                newImageUrl = urlImage;
                $(".imgProfile").attr("src", urlImage);
                console.log(urlImage);
                var data = {
                    infos: newImageUrl
                }
                console.log(data);
            }
        });
    })

    $("#btnValideNomPrenomProfile").on("submit", function (e) {
        console.log("submit");
        e.preventDefault();

        if (newImageUrl != null) {

            $.ajax({
                url: './php/usersManager.php',
                dataType: 'text',
                data: newImageUrl,
                type: 'post',
                success: function () {
                    //
                }
            });
        }

    });
});