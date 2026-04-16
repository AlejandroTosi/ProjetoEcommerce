package com.alejandro.ecommerce.usuario;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.util.List;
import java.util.Optional;

public interface UsuarioRepository extends JpaRepository<Usuario, Long> {

    // =========================
    // LOGIN
    // =========================
    Optional<Usuario> findByUsername(String username);


    // =========================
    // PESQUISA DINÂMICA
    // =========================
    @Query("""
       SELECT u FROM Usuario u
       WHERE (:q IS NULL OR
              LOWER(u.nome) LIKE LOWER(CONCAT('%', :q, '%')) OR
              LOWER(u.username) LIKE LOWER(CONCAT('%', :q, '%')) OR
              LOWER(u.email) LIKE LOWER(CONCAT('%', :q, '%')))
       AND (:tipodeconta IS NULL OR u.tipoDeConta.id = :tipodeconta)
       """)
    List<Usuario> pesquisa(
            @Param("q") String q,
            @Param("tipodeconta") Long tipoDeContaId
    );

    @Query("""
        SELECT u FROM Usuario u
        JOIN u.tipoDeConta t
        WHERE 
        (:nome IS NULL OR :nome = '' OR UPPER(u.nome) LIKE UPPER(CONCAT('%', :nome, '%')))
        OR
        (:tipo IS NULL OR :tipo = '' OR UPPER(t.descricao) LIKE UPPER(CONCAT('%', :tipo, '%')))
        """)
    List<Usuario> pesquisar(String nome, String tipo);}