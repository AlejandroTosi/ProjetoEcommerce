package com.alejandro.ecommerce.usuario;

import com.alejandro.ecommerce.tipodeconta.TipoDeConta;
import com.alejandro.ecommerce.tipodeconta.TipoDeContaRepository;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

@Service
public class UsuarioService {

    private final UsuarioRepository usuarioRepository;
    private final PasswordEncoder passwordEncoder;
    private final TipoDeContaRepository tipoDeContaRepository;

    public UsuarioService(UsuarioRepository usuarioRepository,
                          TipoDeContaRepository tipoDeContaRepository,
                          PasswordEncoder passwordEncoder) {
        this.usuarioRepository = usuarioRepository;
        this.tipoDeContaRepository = tipoDeContaRepository;
        this.passwordEncoder = passwordEncoder;
    }

    // =========================
    // LOGIN
    // =========================
    public UsuarioDTO.LoginResponse logar(UsuarioDTO.LoginRequest request) {

        Usuario usuario = usuarioRepository
                .findByUsername(request.username())
                .orElseThrow(() -> new RuntimeException("Usuário ou senha inválidos"));

        if (!passwordEncoder.matches(request.senha(), usuario.getSenhaHash())) {
            throw new RuntimeException("Usuário ou senha inválidos");
        }

        // Adicionar JWT
        String tokenFake = "token-gerado-aqui";

        return new UsuarioDTO.LoginResponse(
                tokenFake,
                usuario.getId(),
                usuario.getNome()
        );
    }

    // =========================
    // PERFIL
    // =========================
    public UsuarioDTO.Dados perfil() {

        // depois você pegará o usuário autenticado pelo SecurityContext
        Usuario usuario = usuarioRepository.findById(1L)
                .orElseThrow();

        return toDados(usuario);
    }

    // =========================
    // REGISTRO
    // =========================
    public UsuarioDTO.Dados registrar(UsuarioDTO.RegistroRequest request) {

        Usuario usuario = new Usuario();
        usuario.setNome(request.nome());
        usuario.setUsername(request.username());
        usuario.setEmail(request.email());
        usuario.setSenhaHash(passwordEncoder.encode(request.senha()));

        // 🔥 BUSCAR TIPO PADRÃO (ex: CLIENTE id = 1)
        TipoDeConta tipoPadrao = tipoDeContaRepository
                .findById(1L)
                .orElseThrow(() -> new RuntimeException("Tipo de conta não encontrado"));

        usuario.setTipoDeConta(tipoPadrao);

        usuarioRepository.save(usuario);

        return toDados(usuario);
    }

    // =========================
    // ALTERAR
    // =========================
    public UsuarioDTO.Dados alterar(UsuarioDTO.UpdateRequest request) {

        // depois você pega do usuário logado
        Usuario usuario = usuarioRepository.findById(1L)
                .orElseThrow();

        usuario.setNome(request.nome());
        usuario.setEmail(request.email());

        usuarioRepository.save(usuario);

        return toDados(usuario);
    }

    // =========================
    // CONVERSOR
    // =========================
    private UsuarioDTO.Dados toDados(Usuario usuario) {
        return new UsuarioDTO.Dados(
                usuario.getId(),
                usuario.getNome(),
                usuario.getUsername(),
                usuario.getEmail(),
                usuario.getTipoDeConta().getDescricao()
        );
    }
}