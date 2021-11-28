/*=========================================================================================
    File Name: wizard-steps.js
    Description: wizard steps page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Chameleon Admin - Modern Bootstrap 4 WebApp & Dashboard HTML Template + UI Kit
    Version: 1.2
    Author: ThemeSelection
    Author URL: https://themeselection.com/
==========================================================================================*/

// Wizard tabs with numbers setup
$(".number-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function (event, currentIndex) {
        alert("Form submitted.");
    }
});


// Wizard tabs with icons setup
$(".icons-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function (event, currentIndex) {
        alert("Form submitted.");
    }
});

// Vertical tabs form wizard setup
$(".vertical-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    stepsOrientation: "vertical",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function (event, currentIndex) {
        alert("Form submitted.");
    }
});

// form planning

// Show form
var form = $(".steps-validation").show();
var p1, p2, p3, p4;
$(".steps-validation").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Finalizar',
        next: 'Próximo <i class="fa fa-chevron-right"></i>',
        previous: '<i class="fa fa-chevron-left"></i> Anterior'
    },
    onStepChanging: function (event, currentIndex, newIndex) {
        
        //console.log(currentIndex)
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex ==1 ) {
            document.getElementById("pv1").value = $('#p1').val();
        }

        if (currentIndex == 2) {
            document.getElementById("pv2").value = $('#p2').val();
        }

        if (currentIndex == 3) {
            document.getElementById("pv3").value = $('#p3').val();
        }

        if (currentIndex == 4) {
            document.getElementById("pv4").value = $('#p4').val();
        }

        if (currentIndex == 5) {
            p1 = document.getElementById("pv1").value;
            p2 = document.getElementById("pv2").value;
            p3 = document.getElementById("pv3").value;
            p4 = document.getElementById("pv4").value;
            var returns = sendquests(p1, p2, p3, p4);

            if(returns == false){
                return false;
            }
        }

        
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex) {
        $("a[href='#previous']").hide();
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex) {
       //printerDiv('tableconteudo');
       window.print()
    }
});

function printerDiv(divID) {
    //Get the HTML of div

    var divElements = document.getElementById(divID).innerHTML;

    //Get the HTML of whole page
    var oldPage = document.body.innerHTML;

    //Reset the pages HTML with divs HTML only

    document.body.innerHTML =

        "<html><head><link rel = 'stylesheet' href = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'><title>Planning</title></head><body>" +
        divElements + "</body>";

    //Print Page
    window.print();
    //Restore orignal HTML
    document.body.innerHTML = oldPage;

}

function sendquests(p1, p2, p3, p4){
    var formdata = 'p1=' + p1 + '&p2=' + p2 + '&p3=' + p3 + '&p4=' + p4;
    $('#status_response').removeClass('d-none');
    $('#response').addClass('d-none');
    $.ajax({
        url: "/admin/planning/save",
        type: "GET",
        data: formdata,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (retorno) {
            var data = retorno.response.data;
            $('#response').load('/admin/planning/loadresult/' + data.idplanning, function () {
                $('#status_response').addClass('d-none');
                $('#response').removeClass('d-none');
            });
            return true;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#status_response').addClass('d-none');
            alertmsg('Ocorreu um erro inesperado, por favor tente mais tarde!', 'alert-danger');
            return false;
        }
    });
}

// Initialize validation
$(".steps-validation").validate({
    ignore: 'input[type=hidden]', // ignore hidden fields
    errorClass: 'danger',
    successClass: 'success',
    highlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass);
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element);
    },
    rules: {
        email: {
            email: true
        }
    }
});


// Initialize plugins
// ------------------------------

// Date & Time Range
$('.datetime').daterangepicker({
    timePicker: true,
    timePickerIncrement: 30,
    locale: {
        format: 'MM/DD/YYYY h:mm A'
    }
});