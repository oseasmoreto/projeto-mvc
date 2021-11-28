//REPLACE NO ALERTA PADRÃO PARA ALGO MAIS BONITO
window.alert = function(message) {
    alertify.alert(message).set({title:"OM System"});
}

$('form .form-control[required]').change(function () {
    if ($(this).val()) {
        $(this).removeClass('is-invalid');
    }
});

$(document).ready(function($) {
    preloaderOn();
});

$(window).on('load', function () {
    preloaderOff();
});

function trocaicone(icone) {
    $('#mostraicone').removeClass();
    $('#mostraicone').addClass(icone);
}

function loadregistercombobox(t, id, url) {
    let dropdown = $(id);
    let label = dropdown.attr('data-label');

    if (label == undefined || label == '' || label == null) label = 'Selecione';

    dropdown.empty();
    dropdown.removeAttr('disabled');

    dropdown.append('<option value="" selected="true">' + label + '</option>');
    dropdown.prop('selectedIndex', 0);

    $.getJSON(url + '/' + t.value, function (data) {
        $.each(data, function (key, entry) {
            let selected = entry.selected ? 'selected' : '';
            dropdown.append($('<option ' + selected + '></option>').attr('value', entry.id).text(entry.title));
        })
    });
}


function block(url, nome) {
    var r = confirm("Tem certeza que deseja bloquear " + nome + "?");
    if (r == true) {
        var formURL = url;
        $.ajax({
            type: "GET",
            url: formURL,
            dataType: 'json',
            success: function (data) {
                if (data == true) {
                    location.reload();
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alertmsg('Ocorreu um erro inesperado, por favor tente mais tarde!', 'alert-danger');
                return false;
            }
        });
    } else {
        return false;
    }
}

function trocarStatus(url, nome) {
    var r = confirm("Tem certeza que deseja alterar o status de " + nome + "?");
    if (r == true) {
        var formURL = url;
        $.ajax({
            type: "GET",
            url: formURL,
            dataType: 'json',
            success: function (data) {
                if (data.success == true) {
                    location.reload();
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alertmsg('Ocorreu um erro inesperado, por favor tente mais tarde!', 'alert-danger');
                return false;
            }
        });
    } else {
        return false;
    }
}

/**
 * Método responsável por filtrar e retornar a listagem dos itens
 * @param string url 
 * @param integer id
 * @return void
 */
function buscarPorCodigo(url, id) {
    preloaderOn();
    $.post(url+"/form", {id: id}, function(data) {
        $( "#loadForm" ).html( data );
        preloaderOff();
    });
}

function register(form) {
    var postData = $(form).serializeArray();
    var formURL = $(form).attr("action");
    var validate = 0;

    $('form' + form + ' button').attr('disabled', 'true');

    $('form' + form + ' .form-control[required]').each(function () {
        if (!$(this).val()) {
            alertmsg('O campo ' + $(this).attr('title') + ' é obrigatório!', 'alert-danger');
            $(this).addClass('is-invalid');
            validate++;
            $('form' + form + ' button').removeAttr('disabled');
            return false;
        }
    });

    if (validate > 0) return false

    $.ajax({
        type: "POST",
        url: formURL,
        data: postData,
        dataType: 'json',
        success: function (data) {
            var response = data['response'];
            alertmsg(response['mensagem'], response['classe'])

            if (response['result'] == 'error') {
                $('.validate-input').each(function () {
                    if ($(this).val() == '') {
                        $(this).addClass('is-invalid');
                    }
                });
            } 
            
            if(data.route.length && response.result == 'success') window.location.replace(data.route);

            $('form' + form + ' button').removeAttr('disabled');
            return true;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('XMLHttpRequest',XMLHttpRequest);
            console.log('textStatus',textStatus);
            console.log('errorThrown',errorThrown);
            alertmsg('Ocorreu um erro inesperado, por favor tente mais tarde!', 'alert-danger');
            $('form' + form + ' button').removeAttr('disabled');
            return false;
        }
    });
}

function alertmsg(msg, classe = '') {
    switch (classe) {
        case 'alert-danger':
            alertify.error(msg);
        break;
        case 'alert-success':
            alertify.success(msg);
        break;
        case 'alert-warning':
            alertify.warning(msg);
        break;
        default:
            alertify.message(msg);
        break;
    }
}

function login(form) {
    var postData = $(form).serializeArray();
    var formURL = $(form).attr("action");
    var validate = 0;
    
    $('form' + form + ' .form-control[required]').each(function () {
        if (!$(this).val()) {
            alertmsg('O campo ' + $(this).attr('title') + ' é obrigatório!', 'alert-danger');
            $(this).addClass('is-invalid');
            validate++;
            return false;
        }
    });

    if (validate == 0) {
        $.ajax({
            type: "POST",
            url: formURL,
            data: postData,
            dataType: 'json',
            success: function (data) {
                var response = data['response'];
                alertmsg(response['mensagem'], response['classe'])

                if (response['result'] == 'error') {
                    $('.validate-input').each(function () {
                        if ($(this).val() == '') {
                            $(this).addClass('is-invalid');
                        }
                    });
                    return false;
                } else {
                    window.location.replace(response['redirect']);
                }
            }
        });
    }
}

function enviarsenha(form) {
    var postData = $(form).serializeArray();
    var formURL = $(form).attr("action");
    $.ajax({
        type: "POST",
        url: formURL,
        data: postData,
        dataType: 'json',
        success: function (data) {
            var response = data['response'];
            $('#responsepass').html('<div class="alert-dismissible fade show p-2" role="alert">' + response['mensagem'] + '</div>');
            $('#responsepass').removeClass('alert alert-danger');
            $('#responsepass').removeClass('alert alert-success');
            $('#responsepass').addClass('alert ' + response['classe']);


            if (response['result'] == 'error') {
                $('.validate-input').each(function () {
                    if ($(this).val() == '') {

                        $(this).addClass('alert-validate');
                    }
                });
                return false;
            } else {
                window.location.replace(response['redirect']);
            }
        }
    });
}

function deletar(url, nome, redirect = '') {
    alertify.confirm("Tem certeza que deseja deletar " + nome + "?",function(e){
        if (e) {
            var formURL = url;
            $.ajax({
                type: "GET",
                url: formURL,
                dataType: 'json',
                success: function (data) {
                    if (redirect == '') {
                        location.reload();
                    } else {
                        window.location.href = redirect;
                    }
                }
            });
        } else {
            return false;
        }

    }).set({title:"OM System"}).set({labels:{ok:'Ok', cancel: 'Cancelar'}});;
}