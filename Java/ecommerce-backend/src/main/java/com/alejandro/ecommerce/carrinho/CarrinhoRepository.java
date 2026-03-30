package com.alejandro.ecommerce.carrinho;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;

import java.util.List;

public interface CarrinhoRepository extends JpaRepository<Carrinho, Long> {

    List<Carrinho> findByUsuarioId(Long usuarioId);

    @Modifying
    @Query("DELETE FROM Carrinho c WHERE c.id = :id AND c.usuario.id = :usuarioId")
    int deleteByIdAndUsuarioId(Long id, Long usuarioId);
}
