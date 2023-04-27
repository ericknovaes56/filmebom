document.getElementById("photo").addEventListener("change", function(event){
    var output = URL.createObjectURL(event.target.files[0]);
    document.querySelector("#foto").src = output
    document.getElementById("upload").click()
})