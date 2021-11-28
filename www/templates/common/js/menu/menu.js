
/**
 * Método responsável por adicionar uma nova linha de menu
 */
function addMenu(){
  let totalRows = $(".deleteRowMenu").length;
  let newLine = `
  <tr>
    <td>
      <input type="text" required  name="content[${totalRows+1}][title]" title="Titulo" class="form-control round" placeholder="Titulo">
    </td>
    <td>
      <input type="text"  name="content[${totalRows+1}][link]" title="Link" class="form-control round" placeholder="Link">
    </td>
    <td>
      <input type="text"id="icone" name="content[${totalRows+1}][icon]" class="form-control" placeholder="Icone">               
    </td>
    <td>
      <input type="number"  pattern="[0-9]+" name="content[${totalRows+1}][order]" title="Ordem" class="form-control round" placeholder="Ordem">
    </td>
    <td>
      <select class="form-control round" name="content[${totalRows+1}][target]" id="target">
        <option value="_self">_self</option>
        <option value="_blank">_blank</option>
      </select>
    </td>
    <td>
      <button type="button" title="Deletar" class="btn btn-danger text-white deleteRowMenu"><i class="fa fa-trash"></i></button>
    </td>
  </tr>
  `;

  $("#menuBody").append(newLine);
}


$(".table").on("click", ".deleteRowMenu", function() {
  $(this).closest("tr").remove();

  //VALIDAÇÃO PARA NÃO APAGAR TUDO
  let totalRows = $(".deleteRowMenu").length;

  if(totalRows == 0) addMenu();
});