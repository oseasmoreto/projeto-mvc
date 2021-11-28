$('.summernote').summernote({
    placeholder: 'Insira seu texto aqui',
    tabsize: 2,
    height: 300
});

/**
 * Método responsável por filtrar e retornar a listagem dos itens
 * @param string url 
 * @return void
 */
function buscarListagem(url) {
    let busca = '';
    var table = $('#tableList').DataTable();
    

    preloaderOn();
   
    $.post(url+"/buscar", {busca: busca}, function(data) {
        table.destroy();
        $('#tableList').empty(); // empty in case the columns change

        let records = [];
        let json    = JSON.parse(data);

        $.each(json.records, function(i, item) {
            item.acao = `
                <a onclick="${item.actionUrl.update}" class="text-info" href="#."><i class="fa fa-eye" /></i></a>
                <a title="Deletar" href="#." onclick="${item.actionUrl.delete}" class="text-danger ml-2"><i class="fa fa-trash"></i></a>
            `;
        })
 
        table = $('#tableList').DataTable( {
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                },
            "data" : json.records,
            "columns" : json.headers,
            "order": [[ 1, "asc" ]]
        } );    
        $('#modalListagem').modal('show');
        preloaderOff();
    });
}

/**
 * Método responsável por filtrar e retornar a listagem dos itens
 * @param string url 
 * @param integer id
 * @return void
 */
function carregarRegistro(url, id) {
    preloaderOn();
    $.post(url+"/form", {id: id}, function(data) {
        $( "#loadForm" ).html( data );
        if(id != 'reset') $('#modalListagem').modal('toggle');
        preloaderOff();
    });
}

/**
 * Método responsável por redirecionar URL's
 * @param string url 
 */
function redirect(url){
    window.location = url;
    return false;
}