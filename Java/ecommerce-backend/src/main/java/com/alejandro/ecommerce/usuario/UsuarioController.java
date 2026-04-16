package com.alejandro.ecommerce.usuario;


import com.alejandro.ecommerce.usuario.DTO.UsuarioDTO;
import org.springframework.web.bind.annotation.*;

import java.util.List;

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
    @PostMapping("/loginadmin")
    public UsuarioDTO.LoginResponse loginAdmin(
            @RequestBody UsuarioDTO.LoginRequest request) {
        return service.logaradmin(request);
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

    // PESQUISAR USUÁRIO
    @GetMapping("/pesquisar")
    public List<UsuarioDTO.Dados> pesquisar(
            @RequestParam (required = false) String nome,
            @RequestParam (required = false) String tipoDeConta) {
        return service.pesquisar(nome, tipoDeConta);
    }
}