const container = document.querySelector(".container");
const loginBtn = document.querySelector(".login-button");
const registerBtn = document.querySelector(".register-button");

loginBtn.addEventListener("click", () => {
   container.classList.remove("toggle");
   loginBtn.classList.add("active");
   registerBtn.classList.remove("active");
});

registerBtn.addEventListener("click", () => {
   container.classList.add("toggle");
   registerBtn.classList.add("active");
   loginBtn.classList.remove("active");
});

// Regex reutilizáveis
const temMaiuscula = /[A-Z]/;
const temMinuscula = /[a-z]/;
const temSimbolo = /[^A-Za-z0-9]/;
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/* ================= LOGIN ================= */

const loginForm = document.querySelector(".login-form form");

loginForm.addEventListener("submit", (e) => {

   const usuario = document.querySelector("#nome").value.trim();
   const senha = document.querySelector("#senha").value.trim();

   // Usuário
   if (usuario.length < 6 || usuario.length > 12) {
      alert("Usuário deve ter entre 6 e 12 caracteres");
      e.preventDefault();
      return;
   }

   // Senha
   if (senha.length < 6 || senha.length > 18) {
      alert("Senha deve ter entre 6 e 18 caracteres");
      e.preventDefault();
      return;
   }

   if (!temMaiuscula.test(senha)) {
      alert("Senha deve conter pelo menos 1 letra maiúscula");
      e.preventDefault();
      return;
   }

   if (!temMinuscula.test(senha)) {
      alert("Senha deve conter pelo menos 1 letra minúscula");
      e.preventDefault();
      return;
   }

   if (!temSimbolo.test(senha)) {
      alert("Senha deve conter pelo menos 1 símbolo");
      e.preventDefault();
      return;
   }
});

/* ================= REGISTRO ================= */

const registerForm = document.querySelector(".register-form form");

registerForm.addEventListener("submit", (e) => {

   const email = document.querySelector("#email").value.trim();
   const usuario = document.querySelector("#usuario").value.trim();
   const nome = document.querySelector("#nome_cad").value.trim();
   const senha = document.querySelector("#senha_cad").value.trim();
   const idade = Number(document.querySelector("#idade").value.trim());

   // EMAIL
   if (!emailRegex.test(email)) {
      alert("Email inválido");
      e.preventDefault();
      return;
   }

   // USUÁRIO
   if (usuario.length < 6 || usuario.length > 12) {
      alert("Usuário deve ter entre 6 e 12 caracteres");
      e.preventDefault();
      return;
   }

   // NOME
   if (nome.length < 3) {
      alert("Nome deve ter pelo menos 3 caracteres");
      e.preventDefault();
      return;
   }

   // SENHA
   if (senha.length < 6 || senha.length > 18) {
      alert("Senha deve ter entre 6 e 18 caracteres");
      e.preventDefault();
      return;
   }

   if (!temMaiuscula.test(senha)) {
      alert("Senha deve conter pelo menos 1 letra maiúscula");
      e.preventDefault();
      return;
   }

   if (!temMinuscula.test(senha)) {
      alert("Senha deve conter pelo menos 1 letra minúscula");
      e.preventDefault();
      return;
   }

   if (!temSimbolo.test(senha)) {
      alert("Senha deve conter pelo menos 1 símbolo");
      e.preventDefault();
      return;
   }

   // IDADE
   if (isNaN(idade) || idade < 13) {
      alert("É necessário ter pelo menos 13 anos");
      e.preventDefault();
      return;
   }
});