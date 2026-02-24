package com.alejandro.ecommerce.estoque;

import org.springframework.stereotype.Service;

import java.util.List;


@Service
public class EstoqueService {
    private final EstoqueRepository repository;

    public EstoqueService(EstoqueRepository repository) {
        this.repository = repository;
    }


    public List<Estoque> findAll() {
        return repository.findAll();
    }

    public Estoque findById(Long id){
        return repository.findById(id)
                .orElseThrow(() -> new RuntimeException("Erro ao procurar"));

    }

    public Estoque alterar(Long id, Integer quantidade) {
        Estoque estoque = repository.findById(id)
                .orElseThrow(() -> new RuntimeException("Erro"));

            estoque.setQuantidade(quantidade);
        return repository.save(estoque);




    }
}
