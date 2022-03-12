

$(document).on('click', '.js_open_modal', function () {
    let element = $(this)[0];
    let modal = $(element).attr('modal');
    document.getElementById(modal).style.display = "flex";
});

$(document).on('click', '.js_close_modal', function () {
    let element = $(this)[0];
    let modal = $(element).attr('modal');
    document.getElementById(modal).style.display = "none";
});

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function openModal(modalId) {
    document.getElementById(modalId).style.display = "flex";
}
