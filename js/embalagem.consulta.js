var it_pagina = 10;
var pagina = 1;

$(document).ready(function() {
    listar_embalagem(pagina, it_pagina);
})

function listar_embalagem(pagina, it_pagina)
{
    $.post('../controller/embalagem.controller.php', {acao:'recuperar_lista', it_pagina:it_pagina, pagina:pagina}, function(table){
        $("#tabela").html(table);
    })
}

function editar(id, descricao, qtde, pagina, it_pagina){
    
    $.post('../controller/embalagem.controller.php', {acao:'editar', pagina:pagina, it_pagina:it_pagina, id:id, descricao:descricao, qtde:qtde}, function(form){
        $("#tabela").html(form);
    })
 }

 function remover(id){
    location.href = '../controller/embalagem.controller.php?acao=remover&id='+id;
 }


