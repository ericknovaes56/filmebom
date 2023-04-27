document.getElementById("btn1").addEventListener("click", ()=>{
    document.querySelector(".criar").classList.add('show')
    document.querySelector(".entrar").classList.add('remove')
})
document.getElementById("btn2").addEventListener("click", ()=>{
    document.querySelector(".criar").classList.remove('show')
    document.querySelector(".entrar").classList.remove('remove')
})