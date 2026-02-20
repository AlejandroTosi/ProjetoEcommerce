// mostrar formulario novo produto

const abrirTelaBtn = document.getElementById('abrirTelaAdicionarProduto');
const fecharTelaBtn = document.getElementById('fecharTelaAdicionarProduto');

const telaPesquisa = document.getElementById('telaPesquisaProduto');
const telaAdicionar = document.getElementById('telaAdicionarProduto');


abrirTelaBtn.addEventListener("click", function(){
    telaAdicionar.style.display = "block";
    telaPesquisa.style.display = "none";
    abrirTelaBtn.style.display = "none";
});

fecharTelaBtn.addEventListener("click", function(){
    telaAdicionar.style.display = "none";
    telaPesquisa.style.display = "block";
    abrirTelaBtn.style.display = "block";
});
