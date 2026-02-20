package com.alejandro.ecommerce.carrinho;

import com.alejandro.ecommerce.pedido.Pedido;
import com.alejandro.ecommerce.pedido.PedidoService;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
@RequestMapping("/api/carrinho")
public class CarrinhoController {

    private final CarrinhoService carrinhoService;
    private final PedidoService pedidoService;


    public CarrinhoController(CarrinhoService carrinhoService, PedidoService pedidoService) {
        this.carrinhoService = carrinhoService;
        this.pedidoService = pedidoService;
    }

    @GetMapping
    public List<Carrinho> listar() {
        return carrinhoService.listarTodos();
    }

    @PostMapping("/alterar")
    public Carrinho alterar(@RequestBody Carrinho carrinho) {
        return carrinhoService.alterar(carrinho);
    }

    @PostMapping("/finalizar")
    public Pedido finalizar(@RequestParam Long usuarioId) {
        return carrinhoService.finalizar(usuarioId, pedidoService);
    }
}
