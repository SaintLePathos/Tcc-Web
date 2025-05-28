
$(document).ready(function(){
    //mascara
    $('#cpf').mask('000.000.000-00');
    $('#celular').mask('(00) 00000-0000');
    //gerar evento 
     $('.breadcrumb__title').on('click', gerarLogin);
});

function gerarLogin(){
    let nomes  = ['Joao','Mario','Maria','Eduardo'];
    let  indice = Math.floor(Math.random() * nomes.length);
    
    let numero = Math.floor(Math.random() * 256);

    let cpf = '';
    for (let i = 0; i<11; i++){
             cpf += Math.floor(Math.random()* 10);
    }
    let celular = '';
    for (let i = 0; i <9; i++){
        celular += Math.floor(Math.random()* 10);
    }
    let celularCompleto = '11' + celular;
    let senhausuario =  nomes[indice]+"1234";
    let emailusuario = nomes[indice] + numero + "@gmail.com"; 

     $('#nome').val(nomes[indice]);
    $('#email').val(emailusuario);
    $('#senha').val(nomes[indice] + '1234');
    $('#confirma_senha').val(nomes[indice] + '1234');
$('#cpf').val(cpf).trigger('input'); // força máscara
    $('#celular').val(celularCompleto).trigger('input'); // força máscara


};



$(document).ready(function() {
    $('.toggle-password').on('click', function() {
        const input = $($(this).attr('toggle'));
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).toggleClass('bx-hide bx-show');
    });
});
