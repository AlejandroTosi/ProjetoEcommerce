package com.alejandro.ecommerce.home;

public record HomeViewer(
    Long id,
    String nome,
    Double preco,
    String imagem,
    Integer posicao){}
