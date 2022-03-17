$(document).ready(function () {
  var currentBtn = null;

  setupButtons();
  function setupButtons() {

    $("button").each(function () {
      $(this).unbind();
      $(this).on("click", function(){ action($(this).data("action"), this); });
      
      switch ($(this).data("action")) {
        case 'bann':
          $(this).text("Bannir");
          break;
        case 'unbann':
          $(this).text("Débannir");
          break;
        case 'defCreateur':
          $(this).text("Définir comme créateur");
          break;
        case 'rmveCreateur':
          $(this).text("Retirer le rôle créateur");
          break;

          case 'refuserDemande':
            $(this).text("Refuser la demande");
            break;

            case 'accepterDemande':
            $(this).text("Accepter la demande");
            break;

            case 'bannirUSer':
            $(this).text("Bannir ce membre");
            break;
      }
    });
  }

  function action(type, btn)
  {
    console.log($(btn).data("user"));
    $.ajax({
      url: "./php/usersManager.php",
      method: "POST",
      data: {
        userId: $(btn).data("user"),
        action: type,
      },
      success: function () {
        switch (type) {
          case 'bann':
            console.log("test bann");
            $(btn).data("action", "unbann");
            break;
          case 'unbann':
            $(btn).data("action", "bann");

            break;
          case 'defCreateur':
            $(btn).data("action", "rmveCreateur");

            break;
          case 'rmveCreateur':
            $(btn).data("action", "defCreateur");

            break;

            case 'refuserDemande':
                console.log("Demande refusée");
              $(btn).data("action", "refuserDemande");
              location.reload();
              break;

            case 'accepterDemande':
                console.log("Demande acceptée");
              $(btn).data("action", "accepterDemande");
              location.reload();
              break;

            case 'bannirUSer':
                console.log("utilisateur bannis");
              $(btn).data("action", "bannirUSer");
              location.reload();
              break;
        }
        setupButtons();
      },
      error: function (data) {
        console.log("error : ");
        console.log(data);
      }
    });
  }
});