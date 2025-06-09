function enviarID(id) {
    localStorage.setItem("pId", id);
    window.location.href = "details.html";
}
let quantidade;
function carregamento() {
    let id = localStorage.getItem("pId");
    console.log("ID do produto:", id);

    $.ajax({
        url: 'assets/php/detalhes.php',
        type: 'POST',
        data: { produto: id },
        dataType: 'json',
        success: function(retorno) {
            console.log(retorno);

            let quantidade = parseInt(retorno.quantidade);
            let estoque = quantidade === 0 ? 'Esgotado' : 'Em Estoque';
            let desconto = parseFloat(retorno.desconto);
            let valor = parseFloat(retorno.valor);
            let valorFinal = valor - (valor * desconto / 100);

            const imagens = retorno.imagens || [];
            const img1 = imagens[0] || 'assets/img/imgcinza.png';
            const img2 = imagens[1] || 'assets/img/imgcinza.png';
            const img3 = imagens[2] || 'assets/img/imgcinza.png';
            const img4 = imagens[3] || 'assets/img/imgcinza.png';

            const divSelecionada = document.getElementById("detalhesgrid");

            divSelecionada.innerHTML = `
                <div class="product__images grid">
                    <div class="product__img">
                        <div class="details__img-tag">${estoque}</div>
                        <img src="${img1}" alt="">
                    </div>
                    <div class="product__img">
                        <img src="${img2}" alt="">
                    </div>
                    <div class="product__img">
                        <img src="${img3}" alt="">
                    </div>
                    <div class="product__img">
                        <img src="${img4}" alt="">
                    </div>
                </div>

                <div class="product__info">
                    <p class="details__subtitle">${retorno.nome}, Tamanho ${retorno.tamanho}, ${retorno.tecido}, ${retorno.cor}</p>
                    <h3 class="details__title">${retorno.nome}</h3>


                    <div class="details__prices">
                        <span class="details__price">R$${valor.toFixed(2).replace('.', ',')}</span>
                        <span class="details__discount">R$${valorFinal.toFixed(2).replace('.', ',')}</span>
                        <span class="discount__percentage">${desconto.toFixed(0)}% OFF</span>
                    </div>

                    <div class="details__description">
                        <h3 class="description__title">Disponível: ${quantidade}</h3>
                        <div class="description__details">
                            <p>${retorno.descricao}</p>
                        </div>
                    </div>

                    <div class="cart__amount">
                        <div class="cart__amount-content">
                            <span class="cart__amount-box" onclick="diminuir()">
                                <i class="bx bx-minus"></i>
                            </span>

                            <span class="cart__amount-number" id="idContador">0</span>

                            <span class="cart__amount-box" onclick="aumentar()">
                                <i class="bx bx-plus"></i>
                            </span>
                        </div>
                        <i class="bx bx-heart cart__amount-heart"></i>
                    </div>

                    
                </div>
            `;
            initLightbox();
        },
        error: function(cod, textStatus, msg) {
            alert("Houve um erro na comunicação com o servidor:\n" + cod + "\n" + textStatus + "\n" + msg);
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


  function initLightbox() {
    const productItems = document.querySelectorAll(".product__img"),
          totalProductItems = productItems.length,
          lightbox = document.querySelector(".lightbox"),
          lightboxImg = lightbox.querySelector(".lightbox__img"),
          lightboxClose = lightbox.querySelector(".lightbox__close"),
          lightboxCounter = lightbox.querySelector(".caption__counter");

    let itemIndex = 0;

    for (let i = 0; i < totalProductItems; i++) {
      productItems[i].addEventListener("click", function () {
        itemIndex = i;
        changeItem();
        toggleLightbox();
      });
    }

    function nextItem() {
      itemIndex = (itemIndex + 1) % totalProductItems;
      changeItem();
    }

    function prevItem() {
      itemIndex = (itemIndex - 1 + totalProductItems) % totalProductItems;
      changeItem();
    }

    function toggleLightbox() {
      lightbox.classList.toggle("open");
    }

    function changeItem() {
      let imgSrc = productItems[itemIndex].querySelector("img").getAttribute("src");
      lightboxImg.src = imgSrc;
      lightboxCounter.innerHTML = (itemIndex + 1) + " of " + totalProductItems;
    }

    lightbox.addEventListener("click", function (e) {
      if (e.target === lightboxClose || e.target === lightbox) {
        toggleLightbox();
      }
    });

    window.nextItem = nextItem;
    window.prevItem = prevItem;
  }




