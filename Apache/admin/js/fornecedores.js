const select = document.querySelector(".categoria-pesquisa");

const formPesquisa = document.getElementById("formPesquisafornecedores");
const formAdicionar = document.getElementById("formAdicionarfornecedores");
const formAlterar = document.getElementById("formAlterarfornecedores");

function esconderTodos(){
    formPesquisa.style.display = "none";
    formAdicionar.style.display = "none";
    formAlterar.style.display = "none";
}

select.addEventListener("change", function(){

    esconderTodos();

    if(this.value === "1"){
        formPesquisa.style.display = "block";
    }

    if(this.value === "2"){
        formAdicionar.style.display = "block";
    }

    if(this.value === "3"){
        formAlterar.style.display = "block";
    }

});

function atualizar(){
    esconderTodos();

    if(select.value === "1") formPesquisa.style.display="block";
    if(select.value === "2") formAdicionar.style.display="block";
    if(select.value === "3") formAlterar.style.display="block";
}

select.addEventListener("change", atualizar);

// mostra o correto ao carregar
atualizar();

document.addEventListener("DOMContentLoaded", () => {
    formPesquisa.style.display = "block";});


