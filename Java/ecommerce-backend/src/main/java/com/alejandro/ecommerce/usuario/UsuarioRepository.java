package com.alejandro.ecommerce.usuario;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface UsuarioRepository extends JpaRepository<Usuario, Long> {
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


}

