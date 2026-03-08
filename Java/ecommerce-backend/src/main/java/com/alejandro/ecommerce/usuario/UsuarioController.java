package com.alejandro.ecommerce.usuario;


import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/usuarios")
public class UsuarioController {

    private final UsuarioService service;

    public UsuarioController(UsuarioService service) {
        this.service = service;
    }

    // LOGIN
    @PostMapping("/login")
    public UsuarioDTO.LoginResponse login(
            @RequestBody UsuarioDTO.LoginRequest request) {

        return service.logar(request);
    }

    // PERFIL
    @GetMapping("/perfil")
    public UsuarioDTO.Dados perfil() {
        return service.perfil();
    }

    // REGISTRO
    @PostMapping("/registrar")
    public UsuarioDTO.Dados registrar(
            @RequestBody UsuarioDTO.RegistroRequest request) {

        return service.registrar(request);
    }

    // ALTERAR
    @PutMapping
    public UsuarioDTO.Dados alterar(
            @RequestBody UsuarioDTO.UpdateRequest request) {

        return service.alterar(request);
    }
}