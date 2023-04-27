var menus = document.querySelectorAll(".menu")
setTimeout(() => {
    menus.forEach(element => {
        element.classList.add('showmenu')
    });
}, 1);

var animes = document.querySelectorAll(".anime")
setTimeout(() => {
    animes.forEach(element => {
        element.classList.add('showall')
    });
}, 1);

var box = document.querySelectorAll('.n')

box.forEach(element => {
    element.addEventListener('mouseenter', ()=>{
        var iframe = element.title
        var iframec = document.createElement("iframe")
        iframec.src=iframe+'?autoplay=1'
        iframec.setAttribute('frameborder', 0)
        iframec.setAttribute('allow', 'autoplay')
        iframec.classList.add('if')
        element.appendChild(iframec)
    })
    element.addEventListener('mouseleave', ()=>{
        var i = element.querySelectorAll('iframe')
        i.forEach(element => {
            element.remove()
        });
        i.classList.remove('show')
    })
});

var bgeral = document.getElementById("bgeral")
var bfilme = document.getElementById("bfilmes")
var bserie = document.getElementById("bserie")

bgeral.addEventListener("click",()=>{

    bgeral.classList.add('active')
    bfilme.classList.remove('active')
    bserie.classList.remove('active')
    var f = document.querySelectorAll("#filmes")
    f.forEach(element => {
        element.classList.add('aparece')
    });
    var s = document.querySelectorAll("#series")
    s.forEach(element => {
        element.classList.add('aparece')
    });
})

bfilme.addEventListener("click",()=>{
    bgeral.classList.remove('active')
    bfilme.classList.add('active')
    bserie.classList.remove('active')
    var f = document.querySelectorAll("#filmes")
    f.forEach(element => {
        element.classList.add('aparece')
    });
    var s = document.querySelectorAll("#series")
    s.forEach(element => {
        element.classList.remove('aparece')
    });
})
bserie.addEventListener("click",()=>{
    bgeral.classList.remove('active')
    bfilme.classList.remove('active')
    bserie.classList.add('active')
    var f = document.querySelectorAll("#filmes")
    f.forEach(element => {
        element.classList.remove('aparece')
    });
    var s = document.querySelectorAll("#series")
    s.forEach(element => {
        element.classList.add('aparece')
    });
})
