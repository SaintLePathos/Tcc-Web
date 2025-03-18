function carregaproduto3(){
    $.ajax({
        url  : 'PHP/mtdProduto.php',//para onde enviara
        type : 'POST',//medoto de envio
        data : { valor : "value" },//aqu esta o dado que sera reconhecido no php "novologin"
        dataType: 'json',//acho que e o tipo de arquivo
        success: function(retorno){//caso sucesso executara este comando

            let tbl = document.getElementById("tblProdutos").getElementsByTagName("tbody")[0];// pegando tbody para manipulalo

            for (let i = 0; i < 5; i++) {

                let novaLinha = tbl.insertRow();//fazendo um nova linha

                let colunaNome = novaLinha.insertCell(0);//inserindo posicao da coluna na novalinha
                let colunaTipo = novaLinha.insertCell(1);
                let colunaQuantidade = novaLinha.insertCell(2);
                let colunaDescricao = novaLinha.insertCell(3);
                let colunaValor = novaLinha.insertCell(4);
                let colunaPeso = novaLinha.insertCell(5);

                colunaNome.innerText = retorno[i].nome;
                colunaTipo.innerText = retorno[i].tipo;
                colunaQuantidade.innerText = retorno[i].quantidade;
                colunaDescricao.innerText = retorno[i].descricao;
                colunaValor.innerText = retorno[i].valor;
                colunaPeso.innerText = retorno[i].peso;

            }
        },
        error: function(cod,textStatus,msg){//em caso de erro executara este comando
            alert("Houve um erro na comunicação com servidor \n"+cod+"\n"+textStatus+"\n"+msg);
        }
    });
}

function carregaprodutoall(){
    $.ajax({
        url  : 'PHP/mtdProduto.php',//para onde enviara
        type : 'POST',//medoto de envio
        data : { valor : "value" },//aqu esta o dado que sera reconhecido no php "novologin"
        dataType: 'json',//acho que e o tipo de arquivo
        success: function(retorno){//caso sucesso executara este comando

            let tbl = document.getElementById("tblProdutos").getElementsByTagName("tbody")[0];// pegando tbody para manipulalo


            for (let i in retorno) {
                let novaLinha = tbl.insertRow();//fazendo um nova linha

                let colunaNome = novaLinha.insertCell(0);//inserindo posicao da coluna na novalinha
                let colunaTipo = novaLinha.insertCell(1);
                let colunaQuantidade = novaLinha.insertCell(2);
                let colunaDescricao = novaLinha.insertCell(3);
                let colunaValor = novaLinha.insertCell(4);
                let colunaPeso = novaLinha.insertCell(5);

                colunaNome.innerText = retorno[i].nome;//inserindo text com a sua variavel
                colunaTipo.innerText = retorno[i].tipo;
                colunaQuantidade.innerText = retorno[i].quantidade;
                colunaDescricao.innerText = retorno[i].descricao;
                colunaValor.innerText = retorno[i].valor;
                colunaPeso.innerText = retorno[i].peso;
            }
        },
        error: function(cod,textStatus,msg){//em caso de erro executara este comando
            alert("Houve um erro na comunicação com servidor \n"+cod+"\n"+textStatus+"\n"+msg);
        }
    });
}
