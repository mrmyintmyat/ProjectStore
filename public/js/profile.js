var editprofile = document.getElementById('edit-profile');
var emailInput = document.getElementById('email-input');
var nameinput = document.getElementById('name-input');
var btn_mt = document.getElementById('btn_mt');
var post_edit = document.getElementById('post_edit');
var pf_form = document.getElementById('pf_form');
var user_id = document.getElementById('user_id').value;

if (editprofile && emailInput) {
    editprofile.addEventListener('click', function() {
    btn_mt.style.display = "none";
    post_edit.style.display = "block";
    pf_form.action = '/profile/'+ user_id;
    var methodInput = document.createElement('input');
    methodInput.setAttribute('type', 'hidden');
    methodInput.setAttribute('name', '_method');
    methodInput.setAttribute('value', 'PUT');
    pf_form.appendChild(methodInput);
    emailInput.disabled = !emailInput.disabled;
    nameinput.disabled = !nameinput.disabled;
    nameinput.focus();
  });
}
