package com.alejandro.ecommerce.estoque;

import org.springframework.stereotype.Service;


@Service
public class EstoqueService {
    private final EstoqueRepository repository;

    public EstoqueService(EstoqueRepository repository) {
        this.repository = repository;
    }


    public EstoqueDTO alterar(Long id, Integer quantidade) {
        Estoque estoque = repository.findById(id)
                .orElseThrow(() -> new RuntimeException("Estoque não encontrado"));


        Integer novaQuantidade = estoque.getQuantidade() + quantidade;

            estoque.setQuantidade(novaQuantidade);
        Estoque estoqueAtualizado = repository.save(estoque);

        return new EstoqueDTO(
                estoqueAtualizado.getId(),
                estoqueAtualizado.getQuantidade()
        );
    }
}
