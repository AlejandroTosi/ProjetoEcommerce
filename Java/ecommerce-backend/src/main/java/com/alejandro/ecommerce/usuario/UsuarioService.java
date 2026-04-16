package com.alejandro.ecommerce.usuario;

import com.alejandro.ecommerce.tipodeconta.TipoDeConta;
import com.alejandro.ecommerce.tipodeconta.TipoDeContaRepository;
import com.alejandro.ecommerce.usuario.DTO.UsuarioDTO;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

@Service
public class UsuarioService {

    private final UsuarioRepository usuarioRepository;
    private final PasswordEncoder passwordEncoder;
    private final TipoDeContaRepository tipoDeContaRepository;
    private final TokenService tokenService;

    public UsuarioService(UsuarioRepository usuarioRepository,
                          TipoDeContaRepository tipoDeContaRepository,
                          PasswordEncoder passwordEncoder,
                          TokenService tokenService) {
        this.usuarioRepository = usuarioRepository;
        this.tipoDeContaRepository = tipoDeContaRepository;
        this.passwordEncoder = passwordEncoder;
        this.tokenService = tokenService;
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

        // Gerar JWT
        String token = tokenService.gerarToken(usuario);

        return new UsuarioDTO.LoginResponse(
                token,
                usuario.getId(),
                usuario.getNome()
        );
    }

    public UsuarioDTO.LoginResponse logaradmin(UsuarioDTO.LoginRequest request) {

        Usuario usuario = usuarioRepository
                .findByUsername(request.username())
                .orElseThrow(() -> new RuntimeException("Usuário ou senha inválidos"));

        if (!passwordEncoder.matches(request.senha(), usuario.getSenhaHash())) {
            throw new RuntimeException("Usuário ou senha inválidos");
        }

        if (!usuario.getTipoDeConta().getId().equals(1L)){ // 1 = ADMIN
            throw new RuntimeException("Acesso negado: usuário não é admin");
        }

        // Gerar JWT
        String token = tokenService.gerarToken(usuario);

        return new UsuarioDTO.LoginResponse(
                token,
                usuario.getId(),
                usuario.getNome()
        );
    }

    // =========================
    // PERFIL
    // =========================
    public UsuarioDTO.Dados perfil() {

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


        Usuario usuario = usuarioRepository.findById(1L)
                .orElseThrow();

        usuario.setNome(request.nome());
        usuario.setEmail(request.email());

        usuarioRepository.save(usuario);

        return toDados(usuario);
    }

    // =========================
    // PESQUISAR USUÁRIO
    // =========================
    public java.util.List<UsuarioDTO.Dados> pesquisar(String nome, String tipoDeConta) {
        java.util.List<Usuario> usuarios = usuarioRepository
                .pesquisar(nome, tipoDeConta);


        java.util.List<UsuarioDTO.Dados> resultados = new java.util.ArrayList<>();
        for (Usuario usuario : usuarios) {
            resultados.add(toDados(usuario));
        }
        return resultados;
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