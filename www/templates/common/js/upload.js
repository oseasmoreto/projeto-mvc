// Evento Submit do formulário
function upload(form) {
    // Captura os dados do formulário
    var formulario = document.getElementById(form);

    // Instância o FormData passando como parâmetro o formulário
    var formData = new FormData(formulario);
    $('#status_response').removeClass('d-none');
    // Envia O FormData através da requisição AJAX
    $.ajax({
        url: $('#urlpage').val() + "/uploads",
        type: "POST",
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (retorno) {
            $('#status_response').addClass('d-none');
            var r = retorno.response;
            if (r.status == '1') {
                $('#imgload').val(r.image);
                $('#previewimg').attr('src', r.image);
            }
            //alertmsg(retorno.mensagem, retorno.class);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#status_response').addClass('d-none');
            alertmsg('Ocorreu um erro inesperado, por favor tente mais tarde!', 'alert-danger');
            return false;
        }
    });

    return false;
}

function uploadmulti(form, parameters, idreturn) {
    // Captura os dados do formulário
    var formulario = document.getElementById(form);

    var formURL = $('#' + form).attr("action");

    // Instância o FormData passando como parâmetro o formulário
    var formData = new FormData(formulario);
    $('#status_response').removeClass('d-none');
    // Envia O FormData através da requisição AJAX
    $.ajax({
        url: formURL + "" + parameters,
        type: "POST",
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (retorno) {
            $('#status_response').addClass('d-none');
            var r = retorno.response;
            /* if (r.status == '1') {
              $(idreturn).append('<span><img src="' + r.image + '" style="width: 100px"></span>');
            } else {
              alertmsg(r.mensagem, r.classe);
            } */
            //alertmsg(retorno.mensagem, retorno.class);
            window.location.replace(r.redirect);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#status_response').addClass('d-none');
            alertmsg('Ocorreu um erro inesperado, por favor tente mais tarde!', 'alert-danger');
            return false;
        }
    });

    return false;
}

function uploadgeneric(form, reference, formURL, input = '') {
    // Captura os dados do formulário
    var formulario = document.getElementById(form);
    // Instância o FormData passando como parâmetro o formulário
    var formData = new FormData(formulario);
    $('#status_response').removeClass('d-none');
    // Envia O FormData através da requisição AJAX
    $.ajax({
        url: formURL + "?inputFile=" + reference,
        type: "POST",
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (retorno) {
            $('#status_response').addClass('d-none');
            var r = retorno.response;
            if (r.status == '1') {
                $('#' + reference).val(r.image);
                $('#preview' + reference).attr('src', r.image);
            }
            if (input != '') {
                $('#inputimagempreview').val(r.image);
            }
            //alertmsg(retorno.mensagem, retorno.class);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#status_response').addClass('d-none');
            alertmsg('Ocorreu um erro inesperado, por favor tente mais tarde!', 'alert-danger');
            return false;
        }
    });

    return false;
}

function deleteimage(image, t) {
    var r = confirm("Tem certeza que deseja deletar está imagem?");
    if (r == true) {
        $('#status_response').removeClass('d-none');
        $.ajax({
            type: "POST",
            url: $('#urlpage').val() + "/deleteimage",
            data: 'image=' + image,
            dataType: 'json',
            success: function (data) {
                var r = data.response;
                alertmsg(r.mensagem, r.classe);
                $(t).remove();
            }
        });
    } else {
        return false;
    }
}