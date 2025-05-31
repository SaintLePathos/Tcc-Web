



window.addEventListener("load", function() {

    criabarra(); // Função do primeiro arquivo

});

function criabarra(){
    const divbarra = document.getElementById('header');
    divbarra.innerHTML=``;
    divbarra.innerHTML=`
            <nav class="nav container">
            <a href="index.html" class="nav__logo">
                <img src="assets/img/logo.png" alt="" class="img__logo"> 
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                       <a href="index.html" class="nav__link" id="index.html">Home</a>
                    </li> 
                    <li class="nav__item">
                        <a href="shop.html" class="nav__link" id="shop.html">Produtos</a>
                     </li> 
                     <li class="nav__item">
                        <a href="about.html" class="nav__link" id="about.html">Sobre</a>
                     </li> 
                   
                     <li class="nav__item">
                        <a href="faq.html" class="nav__link" id="faq.html">Faq's</a>
                     </li> 
                     <li class="nav__item">
                        <a href="contact.html" class="nav__link" id="contact.html">Contato</a>
                     </li> 
                </ul>
                <div class="nav__close" id="nav-close">
                    <i class="bx bx-x"></i>
                </div>
            </div>

            <div class="nav__btns">
                <div class="login__toggle" id="login-button">
                   <img src="assets/img/search-icon.png" alt="" class="user__tar">
                </div>
                <div class="nav__shop" id="cart-shop">
                    <img src="assets/img/produto.png" alt="" class="bolsa__tar">
                </div>
                <div class="nav__toggle" id="nav-toggle">
                    <i class="bx bx-grid-alt"></i>
                </div>
            </div>

        </nav>
    `;

    const currentPage = window.location.pathname.split("/").pop();
    if(currentPage == "index.html" || currentPage == "shop.html" || currentPage == "about.html" || currentPage == "faq.html" || currentPage == "contact.html" || currentPage == null){
        const idsect = document.getElementById(currentPage+"");
        idsect.className = "nav__link active-link";
    }


    const btnicuser = document.getElementById('login-button');
    btnicuser.addEventListener("click",function(){
        const areaus = document.getElementById('login')
        areaus.className = "login show-login";

        verificalogin();
    })


    const btnicmenu = document.getElementById('nav-toggle');
    btnicmenu.addEventListener("click",function(){
        const areamenu = document.getElementById('nav-menu')
        areamenu.className = "nav__menu show-menu";
    })
        const btnicmenuclose = document.getElementById('nav-close');
    btnicmenuclose.addEventListener("click",function(){
        const areamenu = document.getElementById('nav-menu')
        areamenu.className = "nav__menu";
    })
}

function verificalogin(){
    let num = "num";
    $.ajax({
        url  : 'assets/php/verificasession.php',
        type : 'POST',
        data : { 
            postjs : num
        },
        dataType: 'json',
        success: function(retorno){
           
            if(retorno.status == true){
                const { nome, email, img } = retorno.dados;
                const divlogin = document.getElementById("login");
             
           divlogin.innerHTML = `
            <i class="bx bx-x login__close" id="login-close"></i>
            <h2 class="login__title-center">Perfil</h2>
            <div class="login__form grid">
               
                    <div class="perfil__img-container">
    <img src="${img}" alt="Foto de Perfil" class="perfil__img">
</div>
             
                <div class="login__content">
                    <label class="login__label">Nome:</label>
                    <p>${nome}</p>
                </div>
                <div class="login__content">
                    <label class="login__label">Email:</label>
                    <p>${email}</p>
                </div>
                <div>
                    <a href="user-info.php" class="button">Ver mais</a>
                </div>
            </div>
        `;
        //Aqui voçe coloca o codigo html que vai apareçer caso tenha um login <---------------------------------
                    
            }else{
                
                const divlogin = document.getElementById("login");
                divlogin.innerHTML=``;
                divlogin.innerHTML= `
                    <i class="bx bx-x login__close" id="login-close"></i>
                    <h2 class="login__title-center">Login</h2>
                    <form action="login.php" class="login__form grid" method="post">
                    <div class="login__content">
                        <label for=""class="login__label">Email</label>
                        <input type="email" class="login__input" name="email">
                    </div>
                    <div class="login__content">
                        <label for=""class="login__label">Password</label>
                        <input type="password" class="login__input" name="senha">
                    </div>
                    <div>
                        <button type="submit" class="button">Sign in</button>
                    </div>
                    <div>
                        <p class="signup">Não tem um conta ? <a href="cadastro.html">Cadastre-se agora</a></p>
                       <p class="signup">Esquceu a senha ? <a href="assets/php/recuperarsenha.php">Clique aqui</a></p>
                    </div>
                    </form>
                `;
            }
                const btnicloginclose = document.getElementById('login-close');
                btnicloginclose.addEventListener("click",function(){
                    const areaus = document.getElementById('login')
                    areaus.className = "login";
                })
        },
        error: function(cod,textStatus,msg){
            alert("Houve um erro na comunicação com servidor \n"+cod+"\n"+textStatus+"\n"+msg);
            console.log("erro no ajax")
        }
    });
}