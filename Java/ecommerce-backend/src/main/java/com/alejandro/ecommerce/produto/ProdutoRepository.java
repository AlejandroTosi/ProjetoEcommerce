package com.alejandro.ecommerce.produto;


import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.math.BigDecimal;
import java.util.List;

public interface ProdutoRepository extends JpaRepository<Produto, Long> {

    @Query("SELECT DISTINCT p FROM Produto p " +
            "LEFT JOIN FETCH p.estoque " +
            "LEFT JOIN FETCH p.categoria " +
            "LEFT JOIN FETCH p.fornecedor " +
            "LEFT JOIN FETCH p.descricao " +
            "WHERE (:fornecedorId IS NULL OR p.fornecedor.id = :fornecedorId) " +
            "AND (:categoriaId IS NULL OR p.categoria.id = :categoriaId) " +
            "AND (:ativo IS NULL OR p.ativo = :ativo) " +
            "AND (:min IS NULL OR p.valor >= :min) " +
            "AND (:max IS NULL OR p.valor <= :max) " +
            "AND (:q IS NULL OR LOWER(p.nome) LIKE LOWER(CONCAT('%', :q, '%')) " +
            "     OR LOWER(p.fornecedor.razaoSocial) LIKE LOWER(CONCAT('%', :q, '%')))")
    List<Produto> buscarComFiltros(
            @Param("fornecedorId") Long fornecedorId,
            @Param("categoriaId") Long categoriaId,
            @Param("ativo") Boolean ativo,
            @Param("min") BigDecimal min,
            @Param("max") BigDecimal max,
            @Param("q") String q
    );
}