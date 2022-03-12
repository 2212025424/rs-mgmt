
function mostrarMensajeOperacion(descripcion, cssClass) {
    let element = $('#mensaje_opercion');

    element.css('visibility', 'visible');
    element.addClass(cssClass);
    element.text(descripcion);

    setTimeout(function () {
        element.css('visibility', 'hidden');
        element.removeClass(cssClass);
        element.empty();
    }, 3000);
}

function mostrarMensajeOperacionBoton(descripcion, cssCont, descBoton, cssBtn,  ruta) {
    let element = $('#mensaje_opercion');

    element.css('visibility', 'visible');
    element.addClass(cssCont);
    element.text(descripcion);
    let htmlP = ` <a class="btn_sm ${cssBtn}" href="${ruta}">${descBoton}</a>`;
    element.append(htmlP);

    setTimeout(function () {
        element.css('visibility', 'hidden');
        element.removeClass(cssCont);
        element.empty();
    }, 10000);
}
