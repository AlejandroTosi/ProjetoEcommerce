package com.alejandro.ecommerce.carrinho;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;

import java.util.List;
import java.util.Optional;

public interface CarrinhoRepository extends JpaRepository<Carrinho, Long> {

    List<Carrinho> findByUsuarioId(Long usuarioId);

    Optional<Carrinho> findByUsuarioIdAndProdutoId(Long usuarioId, Long produtoId);

    @Modifying
    @Query("DELETE FROM Carrinho c WHERE c.id = :id AND c.usuario.id = :usuarioId")
    int deleteByIdAndUsuarioId(Long id, Long usuarioId);
}