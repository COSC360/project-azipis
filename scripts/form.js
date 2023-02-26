function confirmPassword() {
    const password = document.getElementById("pw")
    const confirm = document.getElementById("cpw")
    if (confirm.value === password.value) {
        confirm.setCustomValidity('');
    } else {
        confirm.setCustomValidity('Passwords do not match');
    }
}

function fileInput(){
    document.getElementById("imgWrapper").classList.remove("invalid")
}

function previewFile(event) {
    fileInput()
    var preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.onload = function () {
        URL.revokeObjectURL(preview.src) // free memory
    }
}

function submitAttempt(){
    const img = document.getElementById("img")
    const wrap = document.getElementById("imgWrapper")
    if(img.files.length === 0){
        wrap.classList.add("invalid")
    }
}