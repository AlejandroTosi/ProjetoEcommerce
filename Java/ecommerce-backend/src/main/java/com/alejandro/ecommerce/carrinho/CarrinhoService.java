package com.alejandro.ecommerce.carrinho;

import com.alejandro.ecommerce.pedido.PedidoService;
import com.alejandro.ecommerce.produto.Produto;
import com.alejandro.ecommerce.imagem.Imagem;
import com.alejandro.ecommerce.usuario.Usuario;
import jakarta.persistence.EntityManager;
import jakarta.persistence.PersistenceContext;
import jakarta.transaction.Transactional;
import org.springframework.stereotype.Service;
import java.util.List;
import java.util.Optional;

@Service
public class CarrinhoService {
    @PersistenceContext
    private EntityManager entityManager;

    private final CarrinhoRepository carrinhoRepository;
    private final PedidoService pedidoService;

    public CarrinhoService(CarrinhoRepository carrinhoRepository,
                           PedidoService pedidoService) {
        this.carrinhoRepository = carrinhoRepository;
        this.pedidoService = pedidoService;
    }

    public List<CarrinhoDTO.PegarCarrinhoResponse> listarPorUsuario(Long usuarioId) {
        return carrinhoRepository.findByUsuarioId(usuarioId)
                .stream()
                .map(this::converterParaDTO)
                .toList();
    }

    public CarrinhoDTO.PegarCarrinhoResponse adicionar(Long produtoId, Long usuarioId) {

        //evita duplicação
        Optional<Carrinho> existente =
                carrinhoRepository.findByUsuarioIdAndProdutoId(
                        usuarioId, produtoId
                );
        Carrinho carrinho = null;
        if (existente.isPresent()) {
            Carrinho item = existente.get();
            item.setQuantidade(item.getQuantidade() + 1);
            Carrinho salvo = carrinhoRepository.save(item);
            return converterParaDTO(salvo);
        }

        Carrinho req = new Carrinho();
        req.setUsuario(new Usuario());
        req.getUsuario().setId(usuarioId);
        Produto produto = entityManager.getReference(Produto.class, produtoId);
        req.setProduto(produto);
        req.setProduto(produto);
        req.setQuantidade(1);

        Carrinho salvo = carrinhoRepository.save(req);

        return converterParaDTO(salvo);
    }
    private CarrinhoDTO.PegarCarrinhoResponse converterParaDTO(Carrinho carrinho) {
        String imagemEndereco = carrinho.getProduto().getImagens().stream()
                .filter(img -> img.getTipo().name().equals("PRINCIPAL"))
                .findFirst()
                .map(Imagem::getEndereco)
                .orElse(null);

        return new CarrinhoDTO.PegarCarrinhoResponse(
                carrinho.getId(),
                carrinho.getProduto().getId(),
                carrinho.getProduto().getNome(),
                carrinho.getProduto().getValor().doubleValue(),
                imagemEndereco,
                carrinho.getQuantidade()

        );
    }


    @Transactional
    public void remover(Long id, Long usuarioId) {
        int deletados = carrinhoRepository.deleteByIdAndUsuarioId(id, usuarioId);

        if (deletados == 0) {
            throw new RuntimeException("Item não encontrado ou não pertence ao usuário");
        }
    }

}