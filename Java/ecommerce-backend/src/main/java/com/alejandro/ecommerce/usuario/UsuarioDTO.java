package com.alejandro.ecommerce.usuario;

public class UsuarioDTO {

    public record LoginRequest(
            String username,
            String senha
    ) {}

    public record LoginResponse(
            String token,
            Long id,
            String nome
    ) {}

    public record RegistroRequest(
            String nome,
            String username,
            String email,
            String senha
    ) {}

    public record UpdateRequest(
            String nome,
            String email
    ) {}

    public record Dados(
            Long id,
            String nome,
            String username,
            String email,
            String tipoDeConta
    ) {}
}