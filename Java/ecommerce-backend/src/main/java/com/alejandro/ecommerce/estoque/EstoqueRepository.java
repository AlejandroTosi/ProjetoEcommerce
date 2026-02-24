package com.alejandro.ecommerce.estoque;

import com.alejandro.ecommerce.produto.Produto;
import org.springframework.data.jpa.repository.JpaRepository;

public interface EstoqueRepository extends JpaRepository<Estoque, Long> {
}
