var currentModule;
var currentStep = 0;

$(document).ready(function () {
    currentModule = $("#module-step").data("module");
    getCurrentStep();
    getStepContent();
    addingListenerBtns();
});

function addingListenerBtns() {
    $("#button-next").data("nextstep", Number(currentStep) + 1);
    $("#button-next").click(changeStep);

    $("#button-previous").data("nextstep", Number(currentStep) - 1);
    $("#button-previous").click(changeStep);

    $("#button-restart").data("nextstep", 0);
    $("#button-restart").click(function () {
        moduleInfos({
            type: "resetUserQuiz",
            infos: {
                module: currentModule
            }
        });
    });
    $("#button-restart").click(changeStep);

    $("#button-verify").click(quizVerify);

    $(".fill-progress").click(changeStep)
}

function getInfos(data) {

    var returnData;

    $.ajax({
        url: "./php/getInfos.php",
        method: "POST",
        async: false,
        data: data,
        dataType: "JSON",
        success: function (data) {
            returnData = data;
        },
        error: function (data) {
            console.log("error : ");
            console.log(data);
        }
    });

    return returnData;
}

function moduleInfos(data) {
    $.ajax({
        url: "./php/modulesManager.php",
        type: 'POST',
        data: data,
        success: function () {
            //
        },
        error: function (data) {
            console.log("Erreur");
            console.log(data);
        }
    });
}

function quizVerify() {
    var questions = [];
    $(".question-index").each(function () {
        questions.push($(this).data("question"));
    });

    var userAnswers = [];
    $(questions).each(function (index, value) {
        $("input:radio[name=" + value + "]").each(function () {
            if ($(this).is(':checked')) {
                userAnswers.push($(this).data("answer"));
            }
        });
    });

    if (userAnswers.length == questions.length) {
        $.ajax({
            url: "./php/getInfos.php",
            method: "POST",
            async: false,
            data: {
                type: "getCorrectAnswers",
                module: currentModule,
                questions: questions
            },
            dataType: "JSON",
            success: function (data) {
                var userCorrectAnswersCount = 0;

                $(data).each(function (indexData, valueData) {

                    if (valueData == userAnswers[indexData]) {
                        userCorrectAnswersCount++;
                    }
                });

                $("#button-verify").remove();
                $(".button-quiz-zone").append("<button id='button-next' class='button-text'>Continuer</button>");
                $("input:radio").prop("disabled", true);

                moduleInfos({
                    type: "userQuiz",
                    infos: {
                        quiz: $(".quiz").data("quiz"),
                        note: userCorrectAnswersCount
                    }
                });
                addingListenerBtns();
            },
            error: function (data) {
                console.log("error : ");
                console.log(data);
            }
        });
    } else {
        console.log("Vous devez répondre à toutes les questions");
    }
}

function changeStep() {
    currentStep = $(this).data("nextstep");
    getStepContent();
}

function getCurrentStep() {

    currentStep = getInfos({
        type: "getStep",
        module: currentModule,
    })['userCompleted'];
}

function getStepContent() {

    $.ajax({
        url: "./php/switchStep.php",
        method: "POST",
        data: {
            module: currentModule,
            step: currentStep
        },
        dataType: "JSON",
        success: function (data) {
            loadStep(data);
        },
        error: function (data) {
            console.log("error : ");
            console.log(data);
        }
    });
}

function loadStep(data) {
    var emplacementComposant = $("#module-step"); // Assignation du composant
    emplacementComposant.empty(); // Vider l'emplacement du composant

    var url;
    if (currentStep < 1) {
        url = "./templates/steps/start.php";
    } else if (currentStep > 8) {
        var infos = getInfos({
            type: "getUserQuizzesNote",
            module: currentModule
        });

        data['note'] = infos[0]['note'] + " / " + infos[1]['questions'];

        url = "./templates/steps/end.php";
    } else {

        if (data['idTextImage'] != null) {
            url = "./templates/steps/textImage.php";
        }
        if (data['idTextVideo'] != null) {
            url = "./templates/steps/textVideo.php";
        }
        if (data['idAudioImage'] != null) {
            url = "./templates/steps/audioImage.php";
        }
        if (data['infos'] != null) {
            url = "./templates/steps/quiz.php";
        }

        //Barres de progression
        emplacementComposant.append($("<div class='progress'></div>"));
        var progress = $(".progress");
        for (var i = 1; i <= 8; i++) {
            if (i <= currentStep) {
                progress.append("<span class='fill-progress' data-nextstep='" + i + "'></span>");
            } else {
                progress.append("<span></span>");
            }
        }
    }

    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        success: function (dataStep) {

            emplacementComposant.append(dataStep); // Ajouter le contenu des données HTML

            if (data['infos'] != null) {
                var infos = getInfos({
                    type: "getUserQuiz",
                    quiz: $(".quiz").data("quiz")
                });

                if (infos != null) {
                    $("#button-verify").remove();
                    $(".button-quiz-zone").append("<button id='button-next' class='button-text'>Continuer</button>");
                    $("input:radio").prop("disabled", true);
                }
            }

            addingListenerBtns();
        },
        error: function () {
            console.log("Erreur");
        }
    });
}