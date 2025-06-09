
window.addEventListener("load",function(){

    carregarProdutosNovos();


});


function carregarProdutosNovos() {
  $.ajax({
    url: 'assets/php/novosProdutos.php',
    method: 'POST',
    dataType: 'json',
    data: {},
    success: function (data) {
   const container = $('.new-swiper .swiper-wrapper');
      container.empty();
     data.forEach(produto => {
  const card = $(`
    <div class="new__content swiper-slide">
        <div class="new__tag">Novos</div>
        <img src="${produto.imagem}" alt="" class="new__img">
        <h3 class="new__title">${produto.nome}</h3>
        <span class="new__subtitle">${produto.tecido}</span>
        <div class="new__prices">
            <span class="new__price">R$${produto.valor.replace('.', ',')}</span>
            <span class="new__discount">R$${produto.valor_original.replace('.', ',')}</span>
        </div>
        <a href="#" class="button new_button">
            <p class="new__icon">Ver mais</p>
        </a>
    </div>
  `);

  // Evento de clique para chamar enviarID
  card.on('click', function () {
    enviarID(produto.id);
  });

  container.append(card);
});

    },
    error: function (err) {
      console.error("Erro ao carregar produtos:", err);
    }
  });
}