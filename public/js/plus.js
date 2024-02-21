let count = document.getElementsByClassName("count")[0];
let count_form = document.getElementsByClassName("count")[1];
let count_form_cart = document.getElementsByClassName("count")[2];
let total = document.getElementsByClassName("total");
let count_total = document.getElementsByClassName("count_total");
let minus = document.getElementsByClassName("minus")[0];
let plus = document.getElementsByClassName("plus")[0];
let disabled_tag = document.getElementsByClassName("disabled_tag");
let get_price = document.getElementsByClassName("price")[0];
let count_value = count.textContent;
let count_a = Number(count_value);
let price = parseFloat(get_price.innerText.replace(/\D/g, ''));
let plus_price = parseFloat(price.toFixed(2));
const ormmk = get_price.innerText.match(/[A-Z$]+/)[0];
if (count_a < 1 || count_a === 1) {
    minus.style.cursor = "no-drop";
    minus.style.opacity = "0.3";
}

if ($("#item_count").val() == 0 || $("#item_count").val() == 1) {
    for (let i = 0; i < disabled_tag.length; i++) {
        disabled_tag[i].disabled = true;
        disabled_tag[i].style.cursor = "no-drop";
        disabled_tag[i].style.opacity = "0.3";
    }

    plus.disabled = true;
    plus.style.cursor = "no-drop";
    plus.style.opacity = "0.3";
}


minus.onclick = () => {

    if (count_a > 1) {
        plus.style.cursor = "";
        plus.style.opacity = "";
        count_a--;
        count.innerHTML = count_a;
        count_form.value = count_a;
        if (count_form_cart) {
            count_form_cart.value = count_a;
        }
        if (count_total) {
            for (let i = 0; i < count_total.length; i++) {
                count_total[i].innerHTML = count_a;
            }

        }
        price -= plus_price;
        // get_price.innerHTML = ormmk + parseInt(price.toFixed(2));
        if (total) {
            for (let i = 0; i < total.length; i++) {
                total[i].innerHTML = ormmk + parseInt(price.toFixed(2));
            }
        }
        if (count_a === 1) {
            minus.style.cursor = "no-drop";
            minus.style.opacity = "0.3";
        }
    }
};

plus.onclick = () => {
    if ($("#item_count").val() === count_a.toString()) {
        return;
    }
    count_a++;
    count.innerHTML = count_a;
    count_form.value =count_a;
    if (count_form_cart) {
        count_form_cart.value = count_a;
    }

    if (count_total) {
        for (let i = 0; i < count_total.length; i++) {
            count_total[i].innerHTML = count_a;
        }
    } else{
        console.log("oskdv")
    }

    minus.style.cursor = "";
    minus.style.opacity = "";

    price += plus_price;
    // get_price.innerHTML = ormmk + parseInt(price.toFixed(2));
    if (total) {
        for (let i = 0; i < total.length; i++) {
            total[i].innerHTML = ormmk + parseInt(price.toFixed(2));
        }
    }
    if ($("#item_count").val() === count_a.toString()) {
        plus.style.cursor = "no-drop";
        plus.style.opacity = "0.3";
        return
    }

};


document.addEventListener('DOMContentLoaded', function() {
    var editemail = document.getElementById('edit-email');
    var emailInput = document.getElementById('email-input');
    var editphone = document.getElementById('edit-phone');
    var phoneInput = document.getElementById('phone-input');

    if (editemail && emailInput) {
        editemail.addEventListener('click', function() {
        emailInput.disabled = !emailInput.disabled;
        emailInput.focus();
      });

    }

    if (editphone && phoneInput) {
        editphone.addEventListener('click', function() {
        phoneInput.disabled = !phoneInput.disabled;
        phoneInput.focus();
      });
    }
  });

  $("#em_verify_btn").click(function() {
     sessionStorage.setItem('check_add_or_not', true);
     sessionStorage.setItem('item_id', $("#item_id").val());
  });

