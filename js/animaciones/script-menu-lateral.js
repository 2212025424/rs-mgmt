
//------------------------------------------------- Interacciones javascript para el menu lateral 

var li_items = document.querySelectorAll(".menu_lateral ul li");
var hamburger = document.querySelector(".barra_sup__hamburger");
var wrapper = document.querySelector(".cont_principal");

li_items.forEach((li_item) => {
    li_item.addEventListener("mouseenter", () => {
        if (wrapper.classList.contains("click_collapse")) {
            return;
        } else {
            li_item.closest(".cont_principal").classList.remove("hover_collapse");
        }
    });
});

li_items.forEach((li_item) => {
    li_item.addEventListener("mouseleave", () => {
        if (wrapper.classList.contains("click_collapse")) {
            return;
        } else {
            li_item.closest(".cont_principal").classList.add("hover_collapse");
        }
    });
});

hamburger.addEventListener("click", () => {
    hamburger.closest(".cont_principal").classList.toggle("click_collapse");
    hamburger.closest(".cont_principal").classList.toggle("hover_collapse");
});

$('.show_submenu').click(function () {
    let element = $(this)[0];
    let id = $(element).attr('data-show-submenu');
    let subelemento = document.getElementById(id);
    element.classList.toggle('activo_submenu');
    subelemento.classList.toggle('show-submenu');
});