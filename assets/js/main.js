

/*============== SHOW MENU ===============*/
const navMenu= document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close')

/*===== MENU SHOW =====*/
/* Validate if constant exists */

if(navToggle) {
    navToggle.addEventListener("click",()=> {
        navMenu.classList.add('show-menu')
    })
}
/*===== MENU HIDDEN =====*/
/* Validate if constant exists */

if(navClose) {
    navClose.addEventListener("click",()=> {
        navMenu.classList.remove('show-menu')
    })
}



/*=============== SHOW LOGIN ===============*/
const login= document.getElementById('login'),
      loginButton = document.getElementById('login-button'),
      loginClose = document.getElementById('login-close')

/*===== LOGIN SHOW =====*/
/* Validate if constant exists */
if(loginButton) {
    loginButton.addEventListener("click",()=> {
        login.classList.add('show-login')
    })
}

/*===== LOGIN HIDDEN =====*/
/* Validate if constant exists */

if(loginClose) {
    loginClose.addEventListener("click",()=> {
        login.classList.remove('show-login')
    })
}
/*=============== HOME SWIPER ===============*/

var homeSwiper = new Swiper(".home-swiper",{
    spaceBetween: 30,
    Loop: 'true',
    
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    }
})

/*=============== CHANGE BACKGROUND HEADER ===============*/
function scrollHeader() {
    const header = document.getElementById('header');
    //when the scroll is greater than 50 viewport height, add the scroll-header class to the header tag
    if(this.Scrolly >= 50) header.classList.add('scroll-header'); else header.classList.remove('scroll-header');

}
window.addEventListener('scroll',scrollHeader);
/*=============== NEW SWIPER ===============*/

var newSwiper = new Swiper(".new-swiper",{
    spaceBetween: 16,
    centeredSlides: true,
    slidesPerView: "auto",
    loop: 'true',  
    
})
/*=============== SHOW SCROLL UP ===============*/ 
function scrollUp() {
    const scrollUp = document.getElementById('scroll-up');
    //when the scroll is higher than 350 viewport height, add the show-scroll class to a tag with the scroll-top 
  if(this.scrollY >= 350) scrollUp.classList.add('show-scroll'); else scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll',scrollUp)
/*=============== LIGHT BOX ===============*/


/*=============== QUESTIONS ACCORDION ===============*/

const accordionItem = document.querySelectorAll('.questions__item')

accordionItem.forEach((item) => {
    const accordionHeader = item.querySelector('.questions__header')

    accordionHeader.addEventListener('click',() => {
        const openItem = document.querySelector('.accordion-open')

        toggleItem(item)

        if(openItem && openItem !== item){
            toggleItem(openItem)
        }
    })
})


const toggleItem = (item) => {
    const accordionContent = item.querySelector('.questions__content')

    if(item.classList.contains('accordion-open')) {
        accordionContent.removeAttribute('style')
        item.classList.remove('accordion-open')
    }
    else{
    accordionContent.style.height = accordionContent.scrollHeight + 'px'
    item.classList.add('accordion-open')
    }
}
