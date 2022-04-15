//let produtos = new Array();
let itens = new Array();

function verificaData(){
    
    var data = new Date();
    var dia = String(data.getDate()+1).padStart(2, '0');
    var mes = String(data.getMonth() + 1).padStart(2, '0');
    var ano = data.getFullYear();
    dataAtual = ano +  '-'+ mes + '-' + dia;

    if(this.value < dataAtual)
      this.value = dataAtual;
}

function adiciona_produto(){
    atualiza_produto(1);
}

function exclui_produto(){
    atualiza_produto(2);
}

function preenche_produto()
{
    atualiza_produto(2);
}


function atualiza_produto(tipo){
    
   let prod_id = document.getElementById("prod_id");
   let qtde = document.getElementById("qtde");
   
   if((prod_id.value != '' && qtde.value > 0) || (tipo == 2))
   {
        var emb_qtde = 0;
        var preco = 0;
        
        for(var i=0; i<produtos[0].length;i++)
        {
            if(produtos[0][i] == prod_id.value)
            {
                emb_qtde = produtos[2][i];
                preco = produtos[3][i];
            }
        }
     
        if(tipo == 1)
        {
            var indice = -1;
            var qtde_atual = 0;
            for(var i=0;i<itens.length;i++)
            {
                if(itens[i].id == prod_id.value)
                {
                    indice = i;
                    qtde_atual = itens[i].qtde;
                    emb_qtde = parseInt(emb_qtde)// + parseInt(qtde_atual);
                }
            }
            if(emb_qtde != '' && emb_qtde < parseInt(qtde.value))
            {
               alert('Não há embalagens em estoque para esse Produto!');
               prod_id.value = '';
               qtde.value = '';
            }
            else
            {
                if(indice == -1)
                {
                    var item = new Object();
                    item.item_id = 0;
                    item.id = prod_id.value;
                    item.produto = prod_id.children[prod_id.selectedIndex].textContent;
                    item.qtde = qtde.value;
                    item.preco = preco;

                    itens.push(item);
                }
                else
                {
                    itens[indice].qtde = qtde.value;
                }

                prod_id.value = '';
                prod_id.required = false;
                qtde.value = '';
                qtde.required = false;
            }
        }
        
        
        let divtb = document.getElementById("divtabela");
        
        if(itens.length > 0)
        {
            let inputs = new Array();


            let divtb = document.getElementById("divtabela");
            divtb.style.display = "block";

            let tb = document.createElement("table");
            tb.className = "table table-striped table_bordered"

            let theader = document.createElement('thead')
            tb.appendChild(theader);

            let th1 = document.createElement('th')
            th1.textContent = "Produto";
            theader.appendChild(th1);

            let th2 = document.createElement('th')
            th2.textContent = "Quantidade";
            theader.appendChild(th2);

            let th3 = document.createElement('th')
            th3.textContent = "Preço";
            theader.appendChild(th3);
            
            let th4 = document.createElement('th')
            th4.textContent = "";
            theader.appendChild(th4);

            let tbody = document.createElement('tbody');
            tb.appendChild(tbody);

            var total = 0;
            for(var i=0; i<itens.length;i++)
            {
                let tr = document.createElement('tr');
                tbody.appendChild(tr);
                let td1 = document.createElement('td');
                td1.textContent = itens[i].produto;
                
                let input0 = document.createElement('input')
                input0.type = 'hidden'
                input0.name = 'item_'+i
                input0.value = itens[i].item_id;
                inputs.push(input0);

                let input1 = document.createElement('input')
                input1.type = 'hidden'
                input1.name = 'produto_'+i
                input1.value = itens[i].id
                inputs.push(input1);

                tr.appendChild(td1); 
                
                let td2 = document.createElement('td');
                td2.textContent = itens[i].qtde;
                tr.appendChild(td2);
                
                total = total + (itens[i].qtde * itens[i].preco);  
                let td3 = document.createElement('td');
                td3.textContent = (itens[i].qtde * itens[i].preco).toLocaleString('pt-br', {minimumFractionDigits: 2});
                tr.appendChild(td3);

                let td4 = document.createElement('td');
                tr.appendChild(td4);

                let div_icone = document.createElement('div');
                div_icone.className = "col-sm-3 mt-2 d-flex justify-content-between"
                td4.appendChild(div_icone);

                let icone = document.createElement('i');
                icone.className= "fas fa-trash-alt fa-lg text-danger";
                icone.id = itens[i].id;
                icone.addEventListener("click", function(){

                    let prod_id = this.id;
                    let index = -1;

                    itens.forEach(function(item, i, itens){
                        if(prod_id == item.id)
                        {
                            index = i;
                        }
                    });
                    if(index != -1)
                    {
                        itens.splice(index, 1);
                        atualiza_produto(2);
                    }

                })
                div_icone.appendChild(icone);

                let input2 = document.createElement('input')
                input2.type = 'hidden'
                input2.name = 'qtde_'+i
                input2.value = itens[i].qtde;
                inputs.push(input2);
                
                let input3 = document.createElement('input')
                input3.type = 'hidden'
                input3.name = 'preco_'+i
                input3.value = itens[i].preco;
                inputs.push(input3);
            }

            let input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'qtde_produto'
            input.value = itens.length
            
            let tfoot = document.createElement('tfoot');
            tb.appendChild(tfoot);
            
            let tr = document.createElement('tr');
            tfoot.appendChild(tr);
            
            let td1 = document.createElement('td');
            td1.textContent = "Total";
            tr.appendChild(td1); 
                
            let td2 = document.createElement('td');
            td2.textContent = "";
            tr.appendChild(td2);
                
            let td3 = document.createElement('td');
            td3.textContent = total.toLocaleString('pt-br', {minimumFractionDigits: 2});
            tr.appendChild(td3);
            
            let td4 = document.createElement('td');
            td4.textContent = "";
            tr.appendChild(td4);
            
            divtb.innerHTML = ''
            divtb.insertBefore(tb, divtb[0]);
        
            for(var i=0;i<inputs.length;i++)
            {
                divtb.insertBefore(inputs[i], divtb[0])
            }

            divtb.insertBefore(input, divtb[0])

        }
        else
        {
        
           divtb.innerHTML = "";
           prod_id.required = true;
        }
        
   }


}
function editar(id, nome, data_entrega, hora_entrega, tipo){
    
    document.getElementById("pesquisa").style.display = "none";
    
    let form1 = document.getElementById('form_temp');
    if(form1 != null)
    {
        let pedido = form1.parentNode;
        pedido.innerHTML = '';
    }
    
    let url = recuperaUrl();
    let form = document.createElement('form')
    form.action = 'pedido_controller.php'+url+'acao=atualizar'
    form.method = 'post'
    form.id = 'form_temp' 
    
    let br1 = document.createElement('br')
    let br2 = document.createElement('br')
    let br3 = document.createElement('br')

    let selectCliente = document.createElement('input')
    selectCliente.disabled = true
    selectCliente.name = 'cli_id'
    selectCliente.className = 'form-select'
    selectCliente.value = nome;
    
    let divEntrega = document.createElement('div')
    divEntrega.className = 'input-group';
    
    let inputData = document.createElement('input')
    inputData.id = 'data_entrega'
    inputData.type = 'date'
    inputData.name = 'data_entrega'
    inputData.className = 'form-control'
    inputData.required = true;
    inputData.value = data_entrega;
    inputData.addEventListener("change", verificaData);
    
    divEntrega.appendChild(inputData);
    
    let inputHora = document.createElement('input')
    inputHora.type = 'time'
    inputHora.name = 'hora_entrega'
    inputHora.className = 'form-control'
    inputHora.required = true;
    inputHora.placeholder = 'Horário'
    inputHora.value = hora_entrega;
    
    divEntrega.appendChild(inputHora);
    
    let divProduto = document.createElement('div');
    divProduto.id = "produtos"
    
    let divProd = document.createElement('div');
    divProd.className = 'input-group';
    
    divProduto.appendChild(divProd);     
    
    let inputPId = document.createElement('select')
    inputPId.className = 'form-select'
    inputPId.id = 'prod_id'
    inputPId.name = 'prod_id'
    inputPId.required = false;
    
    let option = document.createElement('option');
        option.value = "";
        option.text = 'Produtos';
        option.selected = true;
        inputPId.appendChild(option);  
    
    for (var i = 0; i < produtos[0].length; i++) {
        option = document.createElement('option');
        option.value = produtos[0][i];
        option.text = produtos[1][i];
        //if(produtos[0][i] == prod_id)
          //  option.selected = true;
        inputPId.appendChild(option);
    }
    
    divProd.appendChild(inputPId);
    
    let inputQtde = document.createElement('input')
    inputQtde.id ='qtde';
    inputQtde.className = 'form-control';
    inputQtde.type = 'number';
    inputQtde.name = 'qtde';
    inputQtde.min = 1;
    inputQtde.placeholder = 'Quantidade';
    inputQtde.required = false;

    divProd.appendChild(inputQtde);
    
    let buttonadd = document.createElement('button');
    buttonadd.id = 'button_add'
    buttonadd.className = 'btn btn-outline-success'
    buttonadd.type = 'button';
    buttonadd.innerHTML = 'Adicionar';
    buttonadd.addEventListener("click", adiciona_produto)
    
    divProd.appendChild(buttonadd);
    
    let divTabela = document.createElement('div');
    divTabela.id = "divtabela";
    divTabela.className = 'table-responsive';
    
    
    
    let inputId = document.createElement('input')
    inputId.type = 'hidden'
    inputId.name = 'id'
    inputId.value = id

    let button = document.createElement('button')
    button.type = 'submit'
    button.className = 'btn btn-info'
    button.innerHTML = 'Atualizar'
        
    let buttonC = document.createElement('button')
    buttonC.type = 'button'
    buttonC.className = 'btn btn-danger'
    buttonC.innerHTML = 'Cancelar'
    buttonC.addEventListener("click", function(){
    
    let pedido = document.getElementById('pedido_'+id)
    document.getElementById("pesquisa").style.display = "block";
    pedido.innerHTML = ''})

    form.appendChild(selectCliente)
    form.appendChild(divEntrega)
    form.appendChild(divProduto);
    form.appendChild(divTabela);
    form.appendChild(inputId);
    form.appendChild(button)
    form.appendChild(buttonC)

    let pedido = document.getElementById('pedido_'+id)
    
    
    pedido.innerHTML = ''

    pedido.insertBefore(form, pedido[0]);
    selectCliente.parentNode.insertBefore(br1, selectCliente.nextSibling);
    divEntrega.parentNode.insertBefore(br2, divEntrega.nextSibling);  
    divProduto.parentNode.insertBefore(br3, divProduto.nextSibling);
    preenche_produto();

 }

 function remover(id){
    if(confirm("Deseja excluir esse pedido?"))
    {
       location.href = '../controller/pedido.consulta.php'+recuperaUrl()+'acao=remover&id='+id;
    }
 }
 
 function pedidoentregue(id){
     location.href = '../controller/pedido.controller.php?acao=entregar&id='+id;
 }
 
 function pesquisar(){
    
    let controle = 0;
    let url = '';
    let nome = document.getElementById("nome").value;
    let status = document.getElementById("status").value;
    let data_inicial = document.getElementById("data_entrega_inicial").value;
    let data_final = document.getElementById("data_entrega_final").value;
    let hora_inicial = document.getElementById("hora_entrega_inicial").value;
    let hora_final = document.getElementById("hora_entrega_final").value;
    
    if(nome != '')
    {
        url = url+'?nome='+nome;
        controle++;
    }
    if(status == 1 || status == 2)
    {
        if(controle == 0)
        {
            url = url+'?status='+status;
            controle++;
        }
        else
        {
           url = url+'&status='+status; 
        }
    }
    if(data_inicial != '')
    {
        if(controle == 0)
        {
            url = url+'?data_inicial='+data_inicial;
            controle++;
        }
        else
        {
           url = url+'&data_inicial='+data_inicial; 
        }
    }
    if(data_final != '')
    {
        if(controle == 0)
        {
            url = url+'?data_final='+data_final;
            controle++;
        }
        else
        {
           url = url+'&data_final='+data_final; 
        }
    }
    if(hora_inicial != '')
    {
        if(controle == 0)
        {
            url = url+'?hora_inicial='+hora_inicial;
            controle++;
        }
        else
        {
           url = url+'&hora_inicial='+hora_inicial; 
        }
    }
    if(hora_final != '')
    {
        if(controle == 0)
        {
            url = url+'?hora_final='+hora_final;
            controle++;
        }
        else
        {
           url = url+'&hora_final='+hora_final; 
        }
    }
    
    location.href = 'consultar_pedido.php'+url;
        
    
 }
 
 function recuperaUrl()
 {
    var url = window.location.href;
    var indice = url.indexOf('?');
    if(indice != -1)
        url = url.substring(indice);
    else
        url = '?';

    url = url.split('pagina', 1);
    url = url[0];
    if(url != '?')
        if(url[url.length-1] != '&')
           url = url +'&';
  
    return url;
 }

 