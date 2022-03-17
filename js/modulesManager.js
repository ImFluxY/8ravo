$(document).ready(function () {

  setupButtons();

  function setupButtons() {

    $("#category-delete").change(function () {
      action("search", $(this).val(), $("#name-delete"));
    });

    $("input[name='confirm-delete']").change(function () {
      if ($(this).is(':checked')) {
        $(this).attr('value', 'true');
      } else {
        $(this).attr('value', 'false');
      }
    });

    $(".btn-delete-select-module").click(function () {
      return;
      if ($("input[name='confirm-delete']").attr('value') == "true") {
        console.log("Supprimer : " + $("#name-delete").val());
        action("delete", $("#name-delete").val());
      } else {
        console.log("Il faut cocher pour supprimer");
      }
    });

    //Envoyer le formulaire ajout module
    $('#formAddModule').on('submit', function (e) {
      e.preventDefault();
      var inputFile = $("#formAddModule").find(".input-file");
      console.log(inputFile);
      if ($("select[name='category']").val() != "no") {
        //Upload de l'image
        var file_data = $(inputFile[0]).prop('files')[0];
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
            var infos = $('#formAddModule').serializeArray();
            infos[5] = urlImage;
            console.log(infos);
            action("addModule", infos);
          }
        });
      }
    });

    //Envoyer une étape
    $(".data-step").on('submit', function (e) {

      e.preventDefault();
      var form = $(this);
      var type = $(form).find(".inputCreate.type-choice").val();
      var files = [];
      var inputFile = $(form).find(".input-file");

      $(inputFile).each(function (index) {

        uploadFile($(inputFile[index]).attr("name"), inputFile[index]).then(function (value) {
          files[index] = value;

          console.log("Add file of type : " + $(inputFile[index]).attr("name"));
          console.log(files[index]);

          if (index == ($(inputFile).length - 1)) {
            var infos = $(form).serializeArray();
            infos.push(files);
            infos.push($("#module_global").data("module"));
            infos.push($(form).data("index"));
            console.log(infos);

            switch (type) {
              case 'image':
                action('addTextImageStep', infos);
                break;

              case 'video':
                action('addTextVideoStep', infos);
                break;

              case 'audio':
                action('addAudioImageStep', infos);
                break;
            }
          }
        });
      });

      if (type == 'quiz') {
        var formFields = $(form).serializeArray();
        var infos = {};

        $(formFields).each(function(index)
        {
          if($(formFields)[index]["name"] == "question")
          {
            infos[index] = { question: $(formFields)[index]["value"]}
          }
          
          
          if($(formFields)[index]["name"] == "reponse")
          {
            infos[index] = { reponse: $(formFields)[index]["value"]}
          }


          console.log($(formFields)[index]);
        });
        
        console.log(infos);
        action('addQuizStep', infos);
      }
    });


    //Afficher nouvelle catégorie
    $("select[name='category']").change(function () {
      if ($(this).val() == "new")
        $(".new-category").removeClass("disable");
      else
        $(".new-category").addClass("disable");
    });

    //Afficher les étapes
    $("select[name='type'").change(function () {
      if ($(this).val() != "") {
        action($(this).val(), null, $(this).parent().siblings(".form-type-contents"));
      }
    });
  }

  //Compteur textarea
  $(".counter").text("0 / " + $("textarea[maxlength]").attr('maxlength'));
  $("textarea[maxlength]").on("propertychange input", function () {
    $(".counter").text(this.value.length + " / " + $(this).attr('maxlength'));
  });

  async function uploadFile(type, inputFile) {
    var url = "";

    switch (type) {
      case 'image':
        url = './php/uploadImg.php';
        break;

      case 'video':
        url = './php/uploadVideo.php';
        break;

      case 'audio':
        url = './php/uploadAudio.php';
        break;
    }

    var file_data = $(inputFile).prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);

    var result = await $.ajax({
      url: url,
      dataType: 'text',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      async: true,
      type: 'post',
    });

    return result;
  }

  function action(type, infos, parent) {

    var url = "";

    switch (type) {
      case 'search':
        url = "./templates/searchModules.php";
        break;
      case 'deleteModule':
        url = "./php/modulesManager.php";
        break;
      case 'addModule':
        url = "./php/modulesManager.php";
        break;
      case 'addTextImageStep':
        url = "./php/modulesManager.php";
        break;
      case 'addTextVideoStep':
        url = "./php/modulesManager.php";
        break;
      case 'addAudioImageStep':
        url = "./php/modulesManager.php";
        break;
      case 'addQuizStep':
        url = "./php/modulesManager.php";
        break;
      case 'image':
        url = "./templates/create/textImage.html";
        break;
      case 'video':
        url = "./templates/create/textVideo.html";
        break;
      case 'audio':
        url = "./templates/create/textAudio.html";
        break;
      case 'quiz':
        url = "./templates/create/quiz.html";
        break;
    }

    $.ajax({
      url: url,
      method: "POST",
      data: {
        type: type,
        infos: infos,
      },
      dataType: 'html',
      success: function (data) {

        if (parent != null) {
          $(parent).empty();
          $(parent).append(data);
        }

        switch (type) {
          case 'deleteModule':
            action("search", $("#category-delete").val(), $("#name-delete"));
            break;
          case 'addModule':
            console.log("Module ajouté");
            $("#module_global").data("module", data);
            console.log($("#module_global").data("module"));
            $("#formAddModule").empty();
            break;
        }
      },
      error: function (data) {
        console.log("error : ");
        console.log(data);
      }
    });
  }
});