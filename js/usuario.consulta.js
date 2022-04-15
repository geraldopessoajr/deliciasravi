var it_pagina = 10;
var pagina = 1;
            
$(document).ready(function() {
    listar_usuario(pagina, it_pagina);
})

function listar_usuario(pagina, it_pagina)
{
    $.post('../controller/usuario.controller.php', {acao:'recuperar_lista', it_pagina:it_pagina, pagina:pagina}, function(table){
        $("#tabela").html(table);
    })
}

function editar(id, nome, username, senha, perfil, pagina, it_pagina){
   
    $.post('../controller/usuario.controller.php', {acao:'editar', pagina:pagina, it_pagina:it_pagina, id:id, nome:nome, username:username, senha:senha, perfil:perfil}, function(form){
        $("#tabela").html(form);
    }) 
 }

 function remover(id){
    location.href = '../controller/usuario.controller.php?acao=remover&id='+id;
 }


