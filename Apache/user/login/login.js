const container = document.querySelector(".container");
const loginBtn = document.querySelector(".login-button");
const registerBtn = document.querySelector(".register-button");

loginBtn.addEventListener("click", () =>
   container.classList.remove("toggle")
);

registerBtn.addEventListener("click", () =>
   container.classList.add("toggle")
);

//LOGIN
const temMaiuscula = /[A-Z]/;
const temMinuscula = /[a-z]/;
const temSimbolo = /[^A-Za-z0-9]/;


const loginForm = document.querySelector(".login-form form");
const logformnome = document.querySelector("#nome");
const logformsenha = document.querySelector("#senha");

loginForm.addEventListener("submit", (e) => {
   //user
   const loginuser = logformnome.value.trim();
   const loginsenha= logformsenha.value.trim();
   if(loginuser.length < 6){
      alert("Usuario deve ter no minimo 6 caracteres");
      e.preventDefault();
      return;
   }
   else if(loginuser.length > 12){
      alert("Usuario deve ter no maximo 12 caracteres");
      e.preventDefault();
      return;
   }
   else if(loginuser == ""){
      alert("Usuario não pode ser vazio");
      e.preventDefault();
      return;
   }
   
   //senha
   else if(loginsenha.length < 6){
      alert("Senha deve ter no minimo 6 caracteres");
      e.preventDefault();
      return;
   }
   else  if(loginsenha.length > 18){
      alert("Senha deve ter no maximo 18 caracteres");
      e.preventDefault();
      return;
   }
   else if(loginsenha == ""){
      alert("Senha não pode ser vazia");
      e.preventDefault();
      return;
   }
   else if (!temMaiuscula.test(loginsenha)) {
      alert("Senha deve conter pelo menos 1 letra maiúscula");
      e.preventDefault();
      return;
   }
   else if (!temMinuscula.test(loginsenha)) {
      alert("Senha deve conter pelo menos 1 letra minúscula");
      e.preventDefault();
      return;
   }
   else if (!temSimbolo.test(loginsenha)) {
      alert("Senha deve conter pelo menos 1 símbolo");
      e.preventDefault();
      return;
   }
         
});



//REGISTRO

const registerForm = document.querySelector(".register-form form");
const regformemail = document.querySelector("#email");
const regformusuario = document.querySelector("#usuario");
const regnformnome = document.querySelector("#nome_cad");
const regformsenha = document.querySelector("#senha_cad");
const regformidade = document.querySelector("#idade");


//REGISTRO

registerForm.addEventListener("submit", (e) => {

   const email = regformemail.value.trim();
   const usuario = regformusuario.value.trim();
   const nome = regnformnome.value.trim();
   const senha = regformsenha.value.trim();
   const idade = regformidade.value.trim();

   // EMAIL
   const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
   if (email === "") {
      alert("Email não pode ser vazio");
      e.preventDefault();
      return;
   }
   else if (!emailRegex.test(email)) {
      alert("Email inválido");
      e.preventDefault();
      return;
   }

   // USUÁRIO
   else if (usuario === "") {
      alert("Usuário não pode ser vazio");
      e.preventDefault();
      return;
   }
   else if (usuario.length < 6) {
      alert("Usuário deve ter no mínimo 6 caracteres");
      e.preventDefault();
      return;
   }
   else if (usuario.length > 12) {
      alert("Usuário deve ter no máximo 12 caracteres");
      e.preventDefault();
      return;
   }

   // NOME
   else if (nome === "") {
      alert("Nome não pode ser vazio");
      e.preventDefault();
      return;
   }
   else if (nome.length < 3) {
      alert("Nome deve ter pelo menos 3 caracteres");
      e.preventDefault();
      return;
   }

   // SENHA
   else if (senha === "") {
      alert("Senha não pode ser vazia");
      e.preventDefault();
      return;
   }
   else if (senha.length < 6) {
      alert("Senha deve ter no mínimo 6 caracteres");
      e.preventDefault();
      return;
   }
   else if (senha.length > 18) {
      alert("Senha deve ter no máximo 18 caracteres");
      e.preventDefault();
      return;
   }
   else if (!temMaiuscula.test(senha)) {
      alert("Senha deve conter pelo menos 1 letra maiúscula");
      e.preventDefault();
      return;
   }
   else if (!temMinuscula.test(senha)) {
      alert("Senha deve conter pelo menos 1 letra minúscula");
      e.preventDefault();
      return;
   }
   else if (!temSimbolo.test(senha)) {
      alert("Senha deve conter pelo menos 1 símbolo");
      e.preventDefault();
      return;
   }

   // IDADE
   else if (idade === "") {
      alert("Idade não pode ser vazia");
      e.preventDefault();
      return;
   }
   else if (isNaN(idade)) {
      alert("Idade deve ser um número");
      e.preventDefault();
      return;
   }
   else if (idade < 13) {
      alert("É necessário ter pelo menos 13 anos");
      e.preventDefault();
      return;
   }

});









