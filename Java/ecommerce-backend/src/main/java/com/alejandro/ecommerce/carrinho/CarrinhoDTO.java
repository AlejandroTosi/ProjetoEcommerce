package com.alejandro.ecommerce.carrinho;

public class CarrinhoDTO {
    public record AdicionarProdutoRequest(
            Long produtoId,
            Long usuarioId
    ) {}

    public record CarrinhoResponse(
            Long id,
            Long usuarioId,
            Double valorTotal
    ) {}

    public record RemoverProdutoRequest(
            Long produtoId,
            Long usuarioId
    ) {}

    public record CheckoutResponse(
            Long pedidoId,
            Double valorTotal
    ) {}
}