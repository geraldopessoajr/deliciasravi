var it_pagina = 10;
var pagina = 1;

$(document).ready(function() {
    listar_produto(pagina, it_pagina);
})

function listar_produto(pagina, it_pagina)
{
    $.post('../controller/produto.controller.php', {acao:'recuperar_lista', it_pagina:it_pagina, pagina:pagina}, function(table){
        $("#tabela").html(table);
    })
}

function formatarMoeda() {
        
    $(this).mask('#.##0,00', {reverse: true});
}

function editar(id, descricao, sabor, preco, emb_id, pagina, it_pagina){
       
    $.post('../controller/produto.controller.php', {acao:'editar', id:id, descricao:descricao, sabor:sabor, preco:preco, emb_id, it_pagina:it_pagina, pagina:pagina}, function(table){
        $("#tabela").html(table);
    })
 }

 function remover(id){
    location.href = '../controller/produto.controller.php?acao=remover&id='+id;
 }
    
    