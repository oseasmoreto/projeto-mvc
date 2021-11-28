
/**
 * Método responsável por adicionar uma nova linha de rede social
 */
 function addSocialMedia(){
  let totalRows = $(".deleteRowSocialMedia").length;
  let newLine = `
  <tr>
    <td>
      <select class="form-control round" name="content[${totalRows+1}][social]" id="social">
        <option value="facebook">Facebook</option>
        <option value="instagram">Instagram</option>
        <option value="linkedin">Linkedin</option>
        <option value="email">E-mail</option>
        <option value="whatsapp">WhatsApp</option>
      </select>
    </td>
    <td>
      <input type="text" required  name="content[${totalRows+1}][title]" title="Título" class="form-control round" placeholder="Titulo">
    </td>
    <td>
      <input type="text"  name="content[${totalRows+1}][link]" title="Link" class="form-control round" placeholder="Link">
    </td>
    <td>
      <input type="number"  pattern="[0-9]+" name="content[${totalRows+1}][order]" title="Ordem" class="form-control round" placeholder="Ordem">
    </td>
    <td>
      <button type="button" title="Deletar" class="btn btn-danger text-white deleteRowSocialMedia"><i class="fa fa-trash"></i></button>
    </td>
  </tr>
  `;

  $("#socialMediaBody").append(newLine);
}


$(".table").on("click", ".deleteRowSocialMedia", function() {
  $(this).closest("tr").remove();

  //VALIDAÇÃO PARA NÃO APAGAR TUDO
  let totalRows = $(".deleteRowSocialMedia").length;

  if(totalRows == 0) addSocialMedia();
});