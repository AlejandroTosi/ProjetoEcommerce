package com.alejandro.ecommerce.carrinho;

import com.alejandro.ecommerce.pedido.Pedido;
import com.alejandro.ecommerce.pedido.PedidoService;
import jakarta.transaction.Transactional;
import org.springframework.stereotype.Service;
import java.util.List;

@Service
public class CarrinhoService {

    private final CarrinhoRepository carrinhoRepository;

    public CarrinhoService(CarrinhoRepository carrinhoRepository) {
        this.carrinhoRepository = carrinhoRepository;
    }

    public List<Carrinho> listarTodos() {
        return carrinhoRepository.findAll();
    }

    public Carrinho alterar(Carrinho carrinho) {
        // validações podem entrar aqui
        return carrinhoRepository.save(carrinho);
    }

    public Carrinho finalizar(Long usuarioId, PedidoService pedidoService) {
        List<Carrinho> itens = carrinhoRepository.findByUsuarioId(usuarioId);

        // cria o pedido com valor total
        Pedido pedido = pedidoService.criarPedido(usuarioId, itens);

        // limpar carrinho
        carrinhoRepository.deleteAll(itens);

        return pedido;
    }

    @Transactional
    public Carrinho remover(Long id, Long usuarioId) {
        int deletados = carrinhoRepository.deleteByIdAndUsuarioId(id, usuarioId);
        if (deletados == 0) {
            throw new RuntimeException("Item não encontrado ou não pertence ao usuário");
        }

        carrinhoRepository.deleteById(id);
    }
}
