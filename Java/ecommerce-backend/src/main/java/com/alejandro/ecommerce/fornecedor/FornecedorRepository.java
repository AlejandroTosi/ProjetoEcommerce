package com.alejandro.ecommerce.fornecedor;

import org.springframework.data.jpa.repository.JpaRepository;
import java.util.List;

public interface FornecedorRepository extends JpaRepository<Fornecedor, Long> {

    List<Fornecedor> findByRazaoSocialContainingIgnoreCase(String razaoSocial);

    boolean existsByRazaoSocial(String razaoSocial);
    boolean existsByCnpj(String cnpj);
}
