const UserId = document.getElementById('Id');
const password = document.getElementById('pass1')
const confirm = document.getElementById('pass2')

function show() {
    const imgEye = document.getElementById('eye')
    if (password.type==="password", confirm.type==="password") {
        password.type="text"
        confirm.type="text"
        imgEye.setAttribute('src','visible.png')
    }
    else if (password.type==="text", confirm.type==="text") {
        password.type="password"
        confirm.type="password"
        imgEye.setAttribute('src','hide.png')
    }

}

function checkUserId() {
    //checking for letters
    const lower = /[a-z]/g;
    const upper = /[A-Z]/g;
    const number = /[0-9]/g;
    const period = /[.]/g;

    if (!UserId.value.match(lower) & !UserId.value.match(upper) & !UserId.value.match(number) & !UserId.value.match(period)) {
        document.getElementById('Id').value = "";
        alert("You caan only use letters, numbers and periods in your user id");
    }
}