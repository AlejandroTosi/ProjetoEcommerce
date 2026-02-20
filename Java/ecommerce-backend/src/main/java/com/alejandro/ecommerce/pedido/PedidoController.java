package com.alejandro.ecommerce.pedido;

import com.alejandro.ecommerce.carrinho.Carrinho;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/pedidos")
public class PedidoController {

    private final PedidoService service;

    public PedidoController(PedidoService service) {
        this.service = service;
    }

    @PostMapping("/{usuarioId}")
    public Pedido criar(@PathVariable Long usuarioId,
                        @RequestBody List<Carrinho> itens) {
        return service.criarPedido(usuarioId, itens);
    }
}
