package com.alejandro.ecommerce.produto;

import java.math.BigDecimal;
import java.util.List;

public record ProdutoViewer(
        Long id,
        String nome,
        BigDecimal valor,
        String descricao,
        List<String> imagens,
        String categoria

){}
