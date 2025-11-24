const tooltip = document.querySelector('.password_tooltip');
const input = document.querySelector('#form_password');

input.addEventListener('focus', () => {
    // console.log('Le champ input est actif');
    tooltip.style.display = "flex";
});

input.addEventListener('blur', () => {
    // console.log('Le champ input n\'est plus actif');
    tooltip.style.display = "none";
});

input.addEventListener('input', function () {
    // console.log('La valeur du champ input a été modifiée');

    let regex_maj = /[A-Z]/;
    const row_maj = tooltip.querySelector('.maj');
    if (regex_maj.test(this.value)) {
        row_maj.style.color = "DarkSeaGreen";
    }
    else {
        row_maj.style.color = "Tomato";
    }

    let regex_min = /[a-z]/;
    const row_min = tooltip.querySelector('.min');
    if (regex_min.test(this.value)) {
        row_min.style.color = "DarkSeaGreen";
    }
    else {
        row_min.style.color = "Tomato";
    }

    let regex_num = /[0-9]/;
    const row_num = tooltip.querySelector('.num');
    if (regex_num.test(this.value)) {
        row_num.style.color = "DarkSeaGreen";
    }
    else {
        row_num.style.color = "Tomato";
    }

    let regex_spe = /[^a-zA-Z0-9]/;
    const row_spe = tooltip.querySelector('.spe');
    if (regex_spe.test(this.value)) {
        row_spe.style.color = "DarkSeaGreen";
    }
    else {
        row_spe.style.color = "Tomato";
    }

    const row_num8 = tooltip.querySelector('.num8');
    if (this.value.length >= 8) {
        row_num8.style.color = "DarkSeaGreen";
    }
    else {
        row_num8.style.color = "Tomato";
    }

});
