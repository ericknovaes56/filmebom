function gerarSeedAleatoria() {
    // Gera um número aleatório entre 1 e 1000 para usar como semente
    var seed = Math.floor(Math.random() * 1000) + 1;
    
    // Atualiza a imagem no elemento HTML com o ID "imagem-aleatoria"
    document.getElementById("img").src = "https://picsum.photos/seed/" + seed + "/1280/525";
    setTimeout(() => {
        document.querySelector('.img i').style.display='none'
    }, 1000);
}
gerarSeedAleatoria()