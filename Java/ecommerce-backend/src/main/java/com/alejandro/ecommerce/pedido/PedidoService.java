package com.alejandro.ecommerce.pedido;

import com.alejandro.ecommerce.carrinho.Carrinho;
import com.alejandro.ecommerce.usuario.Usuario;
import com.alejandro.ecommerce.usuario.UsuarioRepository;
import org.springframework.stereotype.Service;

import java.math.BigDecimal;
import java.time.LocalDateTime;
import java.util.List;

@Service
public class PedidoService {

    private final PedidoRepository pedidoRepository;
    private final UsuarioRepository usuarioRepository;

    public PedidoService(PedidoRepository pedidoRepository,
                         UsuarioRepository usuarioRepository) {
        this.pedidoRepository = pedidoRepository;
        this.usuarioRepository = usuarioRepository;
    }

    public Pedido criarPedido(Long usuarioId, List<Carrinho> itens) {

        Usuario usuario = usuarioRepository.findById(usuarioId)
                .orElseThrow(() -> new RuntimeException("Usuário não encontrado"));

        Pedido pedido = new Pedido();
        pedido.setUsuario(usuario);
        pedido.setStatus("CRIADO");
        pedido.setDataCriacao(LocalDateTime.now());

        pedido.setValorTotal(BigDecimal.ZERO);


        return pedidoRepository.save(pedido);
    }
}
