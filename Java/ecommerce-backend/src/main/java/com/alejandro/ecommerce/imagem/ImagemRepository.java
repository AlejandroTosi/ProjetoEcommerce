package com.alejandro.ecommerce.imagem;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.Optional;

public interface ImagemRepository extends JpaRepository<Imagem, Long> {
    Optional<Imagem> findFirstByProdutoIdAndTipo(Long produtoId, ImagemTipo tipo);

}
