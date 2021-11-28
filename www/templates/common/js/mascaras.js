$('#reservation').daterangepicker({
  timePicker: false,
  locale: {
    format: 'DD/MM/YYYY'
  }
})
//Date range picker with time picker
$('#reservationtime').daterangepicker({
  timePicker: true,
  maxDays: 99999,
  timePickerIncrement: 30,
  locale: {
    format: 'DD/MM/YYYY HH:mm'
  }
})

//MASK
$(".money").maskMoney({
  prefix: "",
  decimal: ".",
  thousands: ""
});

$(document).ready(function ($) {
  $('input[name=cep]').mask('99999-999');
  $('input[name=docresponsavel]').mask('999.999.999-99');
  $('input[name=tempoEntrega]').mask("99-999");
});

function mask(o, f) {
  setTimeout(function () {
    var v = mphone(o.value);
    if (v != o.value) {
      o.value = v;
    }
  }, 1);
}

function mphone(v) {
  var r = v.replace(/\D/g, "");
  r = r.replace(/^0/, "");
  if (r.length > 10) {
    r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
  } else if (r.length > 5) {
    r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
  } else if (r.length > 2) {
    r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
  } else {
    r = r.replace(/^(\d*)/, "($1");
  }
  return r;
}

function mascaraMutuario(o, f) {
  v_obj = o
  v_fun = f
  setTimeout('execmascara()', 1)
}

function execmascara() {
  v_obj.value = v_fun(v_obj.value)
}

function cpfCnpj(v) {
  
  //Remove tudo o que não é dígito
  v = v.replace(/\D/g, "")
  
  if (v.length <= 14) { //CPF
    
    //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2")
    
    //Coloca um ponto entre o terceiro e o quarto dígitos
    //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d)/, "$1.$2")
    
    //Coloca um hífen entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    
  } else { //CNPJ
    
    //Coloca ponto entre o segundo e o terceiro dígitos
    v = v.replace(/^(\d{2})(\d)/, "$1.$2")
    
    //Coloca ponto entre o quinto e o sexto dígitos
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
    
    //Coloca uma barra entre o oitavo e o nono dígitos
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2")
    
    //Coloca um hífen depois do bloco de quatro dígitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2")
    
  }
  
  return v
  
}

function formatarCampo(campoTexto) {
  if (campoTexto.value.length <= 11) {
    campoTexto.value = mascaraCpf(campoTexto.value);
  } else {
    campoTexto.value = mascaraCnpj(campoTexto.value);
  }
}

function retirarFormatacao(campoTexto) {
  return campoTexto.value.replace(/(\.|\/|\-)/g, "");
}

function mascaraCpf(valor) {
  return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
}

function mascaraCnpj(valor) {
  return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g, "\$1.\$2.\$3\/\$4\-\$5");
}