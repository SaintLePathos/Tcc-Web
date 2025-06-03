

function Carregamento(){
    CarregaProdutos();
    CarregaFiltros('Tamanho');
    CarregaFiltros('Cor');
    CarregaFiltros('Tecido');
}

function CarregaFiltros(fltDeclarado){
    $.ajax({
        url  : 'assets/php/carregaflt.php',//para onde enviara
        type : 'POST',//medoto de envio
        data : { filtrojs : fltDeclarado },
        dataType: 'json',//acho que e o tipo de arquivo
        success: function(retorno){//caso sucesso executara este comando
            console.log(retorno);
            let filtroTamanho = document.getElementById('divFiltro'+fltDeclarado);
            filtroTamanho.innerHTML = "";
            let h3fltTam = document.createElement('h3');
            h3fltTam.classList.add('filter__subtitle');
            h3fltTam.innerText = fltDeclarado;
            filtroTamanho.appendChild(h3fltTam)
            retorno.forEach(item => {
                let divfltTam = document.createElement('div');
                divfltTam.classList.add('filter');
                divfltTam.innerHTML = `    
                    <input type="checkbox" name="ckb${fltDeclarado}_name" id="ckb${item.filtro}_id" value="${item.filtro}" onclick="CarregaProdutos()">
                    <p><label for="ckb${item.filtro}_id">${item.filtro}</label></p> <span>(${item.quantidade})</span> 
                `;
                filtroTamanho.appendChild(divfltTam);
            });
            
        },
        error: function(cod,textStatus,msg){//em caso de erro executara este comando
            console.log("Houve um erro na comunicação com servidor \n"+cod+"\n"+textStatus+"\n"+msg);
        }
    });
}
let ordemSelecionada = "";
function VerificaRdo(){
    const radios = document.getElementsByName("ordem");
    for (const radio of radios) {
        if (radio.checked) {
            ordemSelecionada = radio.value;
            break;
        }
    }
    //console.log(ordemSelecionada);
}

let filtroTamanho = [];
let filtroCor = [];
let filtroTecido = [];
function getCheckedValues(name) {
    let checkboxes = document.querySelectorAll(`input[type="checkbox"][name="${name}"]:checked`);
    return checkboxes.length ? Array.from(checkboxes).map(cb => cb.value) : ["vazio"];
}

function VerificaCkb() {
    filtroTamanho = getCheckedValues("ckbTamanho_name");
    filtroCor = getCheckedValues("ckbCor_name");
    filtroTecido = getCheckedValues("ckbTecido_name");

    //console.log(filtroTamanho, filtroCor, filtroTecido);
}

let numpagina = 1;
let nummax = 0;
let paginaexecucao = false;
function CarregaProdutos(){
    VerificaRdo();
    VerificaCkb();
    $.ajax({
        url  : 'assets/php/produto.php',
        type : 'POST',
        data : { 
            ordemjs : ordemSelecionada,
            fltTamanhojs : filtroTamanho,
            fltCorjs : filtroCor,
            fltTecidojs : filtroTecido
        },
        dataType: 'json',
        success: function(retorno){
            //console.log(retorno);
            let shopItemsContainer = document.getElementById('divProdutos');
            shopItemsContainer.innerHTML = "";
            let numlinhas = 6;
            nummax = Math.max(0, Math.floor(retorno.length / numlinhas)) + 1;
            let posicao = (numpagina - 1) * numlinhas;
            let final = numpagina * numlinhas;
            let estoque = '';
            for (let i = posicao; i < final && i < retorno.length; i++) {
                if(retorno[i].quantidade == "0"){
                    estoque = 'Esgotado';
                }else{
                    estoque = 'Em Estoque';
                }
                const divProduto = document.createElement('div');
                divProduto.classList.add('shop__content');
                divProduto.onclick = function() {
                    enviarID(retorno[i].id); // Passando uma string como parâmetro
                };;
                let desconto = retorno[i].desconto;
                let valor = retorno[i].valor;
                let valorfinal = valor/(1-(desconto/100));
                divProduto.innerHTML = `
                    <div class="shop__tag">${estoque}</div>
                    <img  src="${retorno[i].img}" alt="" class="shop__img">
                    <h3  class="shop__title">${retorno[i].nome}</h3>
                    <span class="shop__subtitle">Tamanho ${retorno[i].tamanho}, ${retorno[i].tecido}, ${retorno[i].cor}</span>

                    <div class="shop__prices">
                        <span class="shop__price">R$${retorno[i].valor}</span>
                        <span class="shop__discounts">${valorfinal.toFixed(2)}</span>
                    </div>

                    <a href="#" class="button shop__button">
                        <i class="bx bx-cart-alt shop__icon"></i>
                    </a>
                `;
                shopItemsContainer.appendChild(divProduto);
                
            }
            if(!paginaexecucao){
                CarregaPaginas()
                paginaexecucao = true;
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", xhr, textStatus, errorThrown);
        }
        
    });
}
function ClickPagina(numpag){
    numpagina = numpag;
    CarregaProdutos();
    MarcaPagina();
}
function MarcaPagina(){
    let spnlistpag = document.querySelectorAll('span[name="spnpag_name"]');
    spnlistpag.forEach(spn => {
        spn.className = "";
    });

    let spnpag = document.getElementById("spn"+numpagina+"_id");
    spnpag.classList.add("current");
}
function CarregaPaginas(){
    let divPaginas = document.getElementById('divPaginaProduto');
    divPaginas.innerHTML = "";
    let paginacao = ``;
    //if (nummax <= 20){
        for(let i = 1; i <= nummax; i++){
            paginacao += `<span id="spn${i}_id" name="spnpag_name" onclick="ClickPagina(${i})">${i}</span>`;
        }
    //}
    divPaginas.innerHTML = `
    <i class="bx bx-chevron-left pagination__icon" onclick="retrocede()"></i>
    ${paginacao}
    <i class="bx bx-chevron-right pagination__icon" onclick="avanca()"></i>`;
    MarcaPagina()
}
function retrocede(){
    
    if(numpagina>1){
        numpagina--;
        CarregaProdutos();
        MarcaPagina()
    }
}
function avanca(){
    if(numpagina < nummax){
        numpagina++;
        CarregaProdutos();
        MarcaPagina()
    }
}
