package com.alejandro.ecommerce.categoria;

import org.springframework.stereotype.Service;
import java.util.List;

@Service
public class CategoriaService {

    private final CategoriaRepository repository;

    public CategoriaService(CategoriaRepository repository) {
        this.repository = repository;
    }

    public List<Categoria> listarTodos() {
        return repository.findAll();
    }

    public List<Categoria> buscar(String q) {
        return repository.findByTipoContainingIgnoreCase(q);
    }

    public Categoria alterar(Long id, String novoTipo) {
        Categoria categoria = repository.findById(id).orElseThrow(() -> new RuntimeException("Categoria não encontrada"));
        categoria.setTipo(novoTipo);
        return repository.save(categoria);
    }
}
