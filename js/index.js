let pw = document.getElementById('password');
let pw2 = document.getElementById('passwordCheck');
let pwCheck = document.getElementById('passCheck');


pwCheck.addEventListener('change', function() {
    if(pwCheck.checked) {
        pw.setAttribute('type', 'text');
        pw2.setAttribute('type', 'text');
    } else {
        pw.setAttribute('type', 'password');
        pw2.setAttribute('type', 'password');
    }
}, false);

function CheckPassword(){
    let input1 = $("#password").val();
    let input2 = $("#passwordCheck").val();

    if(input1 != input2){
        alert ('パスワードが一致していません。再度入力お願いします');
        $("#passwordCheck").val("");
        return false;
    }else{
        return true;
    }
}