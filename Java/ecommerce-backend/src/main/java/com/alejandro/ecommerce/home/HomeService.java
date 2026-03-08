package com.alejandro.ecommerce.home;

import com.alejandro.ecommerce.imagem.ImagemService;
import com.alejandro.ecommerce.produto.ProdutoService;
import jakarta.transaction.Transactional;
import org.springframework.stereotype.Service;


import java.util.List;


@Service
public class HomeService {

    private final HomeRepository homeRepo;
    private final ProdutoService produtoService;
    private final ImagemService imagemService;

    public HomeService(HomeRepository homeRepo,
                       ProdutoService produtoService,
                       ImagemService imagemService){

        this.homeRepo = homeRepo;
        this.produtoService = produtoService;
        this.imagemService = imagemService;
    }

    public List<HomeViewer> listar(){

        return homeRepo.findByAtivoTrueOrderByPosicaoAsc()
                .stream()
                .map(item -> {

                    var p = produtoService.getIdProduto(item.getProdutoId());
                    var img = imagemService.buscarPrincipal(p.id());

                    return new HomeViewer(
                            p.id(),
                            p.nome(),
                            p.valor().doubleValue(),
                            img != null ? img.endereco() : null,
                            item.getPosicao()
                    );

                })
                .toList();
    }

    public HomeViewer adicionar(HomeInput input) {

        // Verifica se o produto existe
        var produto = produtoService.getIdProduto(input.produtoId());
        if (produto == null) {
            throw new RuntimeException("Produto não encontrado");
        }

        //Opcional: Verifica se a posição já está ocupada
        if(homeRepo.existsById(Long.valueOf(input.posicao()))) {
            throw new RuntimeException("Posição " + input.posicao() + " já está ocupada");
        }

        //Cria e salva o item na home
        var itemHome = new Home();
        itemHome.setProdutoId(produto.id());
        itemHome.setPosicao(input.posicao());
        itemHome.setAtivo(true);
        homeRepo.save(itemHome);

        //Busca imagem principal
        var img = imagemService.buscarPrincipal(produto.id());

        //Retorna HomeViewer
        return new HomeViewer(
                produto.id(),
                produto.nome(),
                produto.valor().doubleValue(),
                img != null ? img.endereco() : null,
                input.posicao()
        );
    }
    @Transactional
    public void deletar(Integer posicao){
        homeRepo.deleteByPosicao(posicao);
    }
    }
