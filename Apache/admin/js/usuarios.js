const select = document.querySelector(".categoria-pesquisa");

const formPesquisaNome = document.getElementById("formPesquisarUsuarios");
const formPesquisaFuncao = document.getElementById("formPesquisarFuncao");
const formAdicionar = document.getElementById("formAdicionarUsuarios");
const formAlterar = document.getElementById("formAlterarUsuarios");

function esconderTodos(){
    formPesquisaNome.style.display = "none";
    formPesquisaFuncao.style.display = "none";
    formAdicionar.style.display = "none";
    formAlterar.style.display = "none";
}

select.addEventListener("change", function(){

    esconderTodos();

    if(this.value === "1"){
        formPesquisaNome.style.display = "block";
    }

    if(this.value === "2"){
        formPesquisaFuncao.style.display = "block";
    }

    if(this.value === "3"){
        formAdicionar.style.display = "block";
    }

    if(this.value === "4"){
        formAlterar.style.display = "block";
    }

});

function atualizar(){
    esconderTodos();

    if(select.value === "1") formPesquisaNome.style.display = "block";
    if(select.value === "2") formPesquisaFuncao.style.display = "block";
    if(select.value === "3") formAdicionar.style.display = "block";
    if(select.value === "4") formAlterar.style.display = "block";
}

select.addEventListener("change", atualizar);

// mostra o correto ao carregar
atualizar();

document.addEventListener("DOMContentLoaded", () => {
    formPesquisaNome.style.display = "block";
});