function enviarID(id) {
    localStorage.setItem("pId", id);
    window.location.href = "details.html";
}
let quantidade;
function carregamento(){

    let id = localStorage.getItem("pId");
    console.log(id);
    $.ajax({
        url  : 'assets/php/detalhes.php',
        type : 'POST',
        data : { 
            produto : id
        },
        dataType: 'json',
        success: function(retorno){
            quantidade = retorno.quantidade;
            console.log(retorno);
            let estoque = '';
            if(retorno.quantidade == "0"){
                estoque = 'Esgotado';
            }else{
                estoque = 'Em Estoque';
            }
            let descontado = retorno.desconto / 100;
            let valordescontado = retorno.valor * descontado;
            let valorfinal = retorno.valor - valordescontado;
            let dscnt = retorno.desconto * 1.00;
            const divselecionada = document.getElementById("detalhesgrid");
            divselecionada.innerHTML = '';
            divselecionada.innerHTML = `
                    <div class="product__images grid">
                    <div class="product__img">
                        <div class="details__img-tag">${estoque}</div>
                        <img src="assets/img/${retorno.img}" alt="">
                    </div>
                    
                    <div class="product__img">
                        <img src="assets/img/${retorno.img}" alt="">
                    </div>
                    <div class="product__img">
                        <img src="assets/img/${retorno.img}" alt="">
                    </div>
                    <div class="product__img">
                        <img src="assets/img/${retorno.img}" alt="">
                    </div>
                </div>
                <div class="product__info">
                    <p class="details__subtitle">${retorno.nome}, Tamanho ${retorno.tamanho}, ${retorno.tecido}, ${retorno.cor}</p>
                    <h3 class="details__title">${retorno.nome}</h3>
                    <div class="rating">
                        <div class="stars">
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bx-star"></i>
                        </div>
                        <span class="reviews__count">40 + Reviews</span>
                    </div>

                    <div class="details__prices">
                        <span class="details__price">${valorfinal.toFixed(2)}</span>
                        <span class="details__discount">${retorno.valor}</span>
                        <span class="discount__percentage">${dscnt.toFixed(0)}% OFF</span>
                    </div>

                    <div class="details__description">
                        <h3 class="description__title">Disponivel: ${retorno.quantidade}</h3>
                        <div class="description__details">
                            <p>${retorno.descricao}</p>
                        </div>
                    </div>

                    <div class="cart__amount">
                        <div class="cart__amount-content">
                            <span class ="cart__amount-box" onclick="diminuir()">
                                <i class="bx bx-minus"></i>
                            </span>
  
                            <span class="cart__amount-number" id="idContador">0</span>
  
                            <span class="cart__amount-box" onclick="aumentar()">
                                <i class="bx bx-plus"></i>
                            </span>
                        </div>
                        <i class="bx bx-heart cart__amount-heart"></i>
                    </div>
                    <a href="#" class="button" onclick="aumentar()">Adicionar ao Carrinho</a>
                </div>`;
        },
        error: function(cod,textStatus,msg){
            alert("Houve um erro na comunicação com servidor \n"+cod+"\n"+textStatus+"\n"+msg);
        }
    });
}

let contador = 0;
function aumentar(){
    if(contador < quantidade){
        contador = contador + 1;
    }
    const contagem = document.getElementById("idContador");
    contagem.innerText = contador;
    console.log(contador);
}
function diminuir(){
    if(contador > 0){
        contador = contador - 1;
    }
    const contagem = document.getElementById("idContador");
    contagem.innerText = contador;
    console.log(contador);
}