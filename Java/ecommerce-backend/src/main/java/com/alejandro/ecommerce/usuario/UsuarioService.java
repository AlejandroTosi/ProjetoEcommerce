package com.alejandro.ecommerce.usuario;


import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class UsuarioService {


    private final UsuarioRepository usuarioRepository;

    public UsuarioService(UsuarioRepository usuarioaRepository) {
        this.usuarioRepository = usuarioaRepository;
    }

    public Usuario salvar(Usuario usuario) {
        return usuarioRepository.save(usuario);
    }

    public List<Usuario> listarTodos() {
        return usuarioRepository.findAll();
    }

    public List<Usuario> buscar(
            String nome,
            String username,
            String email,
            Long TipoDeConta,
            String q){
        if(q !=null && q.isBlank()){q = null;}

      return usuarioRepository.pesquisa(q, TipoDeConta);

    }
}

