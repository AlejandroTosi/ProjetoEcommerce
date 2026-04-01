package com.alejandro.ecommerce.carrinho;

import com.alejandro.ecommerce.pedido.Pedido;
import com.alejandro.ecommerce.pedido.PedidoService;
import jakarta.transaction.Transactional;
import org.springframework.stereotype.Service;
import java.util.List;
import java.util.Optional;

@Service
public class CarrinhoService {

    private final CarrinhoRepository carrinhoRepository;
    private final PedidoService pedidoService;

    public CarrinhoService(CarrinhoRepository carrinhoRepository,
                           PedidoService pedidoService) {
        this.carrinhoRepository = carrinhoRepository;
        this.pedidoService = pedidoService;
    }

    public List<Carrinho> listarPorUsuario(Long usuarioId) {
        return carrinhoRepository.findByUsuarioId(usuarioId);
    }

    public Carrinho adicionar(Carrinho req, Long usuarioId) {

        // 🔥 evita duplicação (muito importante)
        Optional<Carrinho> existente =
                carrinhoRepository.findByUsuarioIdAndProdutoId(
                        usuarioId, req.getProduto().getId()
                );

        if (existente.isPresent()) {
            Carrinho item = existente.get();
            item.setQuantidade(item.getQuantidade() + req.getQuantidade());
            return carrinhoRepository.save(item);
        }

            req.getUsuario().setId(usuarioId);

        return carrinhoRepository.save(req);
    }

    @Transactional
    public void remover(Long id, Long usuarioId) {
        int deletados = carrinhoRepository.deleteByIdAndUsuarioId(id, usuarioId);

        if (deletados == 0) {
            throw new RuntimeException("Item não encontrado ou não pertence ao usuário");
        }
    }

    @Transactional
    public Pedido checkout(Long usuarioId) {

        List<Carrinho> itens = carrinhoRepository.findByUsuarioId(usuarioId);

        if (itens.isEmpty()) {
            throw new RuntimeException("Carrinho vazio");
        }

        Pedido pedido = pedidoService.criarPedido(usuarioId, itens);

        carrinhoRepository.deleteAll(itens);

        return pedido;
    }
}