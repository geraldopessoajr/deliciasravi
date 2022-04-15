var it_pagina = 10;
var pagina = 1;

$(document).ready(function() {
    listar_cliente(pagina, it_pagina);
})

function listar_cliente(pagina, it_pagina)
{
    $.post('../controller/cliente.controller.php', {acao:'recuperar_lista', it_pagina:it_pagina, pagina:pagina}, function(table){
        $("#tabela").html(table);
    })
}

function editar(id, nome, contato, endereco, referencia, pagina, it_pagina){
   
    $.post('../controller/cliente.controller.php', {acao:'editar', id:id, nome:nome, contato:contato, endereco:endereco, referencia:referencia, it_pagina:it_pagina, pagina:pagina}, function(table){
        $("#tabela").html(table);
    })
 }

 function remover(id){
     location.href = '../controller/cliente.controller.php?acao=remover&id='+id
 }


