package com.alejandro.ecommerce.categoria;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import java.util.List;

public interface CategoriaRepository extends JpaRepository<Categoria, Long> {
    List<Categoria> findByTipoContainingIgnoreCase(String q);
}
