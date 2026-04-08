package com.alejandro.ecommerce.carrinho;

public class CarrinhoDTO {

    public record PegarCarrinhoResponse(
            Long id, Long produtoId,
            String nomeProduto,
            Double precoProduto,
            String imagemProduto,
            Integer quantidade
            ){}
    public record AdicionarCarrinhoRequest(
            Long produtoId,
            Long usuarioId
    ){}

}