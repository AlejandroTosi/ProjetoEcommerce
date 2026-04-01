package com.alejandro.ecommerce.carrinho;

import com.alejandro.ecommerce.pedido.Pedido;
import com.alejandro.ecommerce.pedido.PedidoService;
import com.alejandro.ecommerce.usuario.UsuarioLogadoService;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
@RequestMapping("/api/carrinho")
public class CarrinhoController {

    private final CarrinhoService carrinhoService;
    private final UsuarioLogadoService usuarioLogadoService;

    public CarrinhoController(CarrinhoService carrinhoService,
                              UsuarioLogadoService usuarioLogadoService) {
        this.carrinhoService = carrinhoService;
        this.usuarioLogadoService = usuarioLogadoService;
    }

    // pegar carrinho do usuário
    @GetMapping
    public List<Carrinho> listar() {
        Long usuarioId = usuarioLogadoService.getId();
        return carrinhoService.listarPorUsuario(usuarioId);
    }

    // adicionar item
    @PostMapping("/itens")
    public Carrinho adicionar(@RequestBody Carrinho req) {
        Long usuarioId = usuarioLogadoService.getId();
        return carrinhoService.adicionar(req, usuarioId);
    }

    // remover item
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> remover(@PathVariable Long id) {
        Long usuarioId = usuarioLogadoService.getId();
        carrinhoService.remover(id, usuarioId);
        return ResponseEntity.noContent().build();
    }

    // checkout
    @PostMapping("/checkout")
    public Pedido checkout() {
        Long usuarioId = usuarioLogadoService.getId();
        return carrinhoService.checkout(usuarioId);
    }
}