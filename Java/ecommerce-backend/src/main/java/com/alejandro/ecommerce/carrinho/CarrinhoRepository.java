package com.alejandro.ecommerce.carrinho;

import org.springframework.data.jpa.repository.JpaRepository;
import java.util.List;

public interface CarrinhoRepository extends JpaRepository<Carrinho, Long> {

    List<Carrinho> findByUsuarioId(Long usuarioId);
}
