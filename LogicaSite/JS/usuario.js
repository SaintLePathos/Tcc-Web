function vrclogin(){

    let usuario = document.getElementById("idusuario").value;
    let senha = document.getElementById("idsenha").value;

    if (usuario !='' && usuario != null) {
        $.ajax({
            url  : 'PHP/mtdLogin.php',//para onde enviara
            type : 'POST',//medoto de envio
            data : { //aqu esta o dado que sera reconhecido no php "postphp : variaveljs"
                usuariojs : usuario,
                senhajs : senha
            },
            datatype: 'json',//acho que e o tipo de arquivo
            success: function(volta){//caso sucesso executara este comando
                volta=JSON.parse(volta);
            if (volta == "usuario/senha_S"){
                alert("O login está cadastrado!!!");
            }
            else {
                let resultado = "LOGIN NAO CADASTRADO";
                alert(resultado);
            }
            },
            error: function(cod,textStatus,msg){//em caso de erro executara este comando
                alert("Houve um erro na comunicação com servidor \n"+cod+"\n"+textStatus+"\n"+msg);
            }
        }); 

    }
}

function cadastro(){
    usuario = document.getElementById("txtnome").value;
    email = document.getElementById("txtemail").value;
    senha = document.getElementById("txtsenha").value;
    if (usuario !='' && usuario != null) {
        $.ajax({
            url  : 'PHP/mtdCadastro.php',//para onde enviara
            type : 'POST',//medoto de envio
            data : { //aqu esta o dado que sera reconhecido no php "postphp : variaveljs"
                usuariojs : usuario,
                emailjs : email,
                senhajs : senha  },
            datatype: 'json',//acho que e o tipo de arquivo
            success: function(volta){//caso sucesso executara este comando
                volta=JSON.parse(volta);
                console.log(volta);
            if (volta == "CadastroS"){
                alert("Usuario Cadastrado com sucesso");
            }
            else {
                resultado = "Erro no cadastro ";
                alert(resultado + volta);
            }
            },
            error: function(cod,textStatus,msg){//em caso de erro executara este comando
                alert("Houve um erro na comunicação com servidor \n"+cod+"\n"+textStatus+"\n"+msg);
            }
        }); 
    }
}
