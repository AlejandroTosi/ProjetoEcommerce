package com.alejandro.ecommerce.produto;

import com.alejandro.ecommerce.categoria.Categoria;
import com.alejandro.ecommerce.categoria.CategoriaRepository;
import com.alejandro.ecommerce.descricao.Descricao;
import com.alejandro.ecommerce.descricao.DescricaoRepository;
import com.alejandro.ecommerce.fornecedor.Fornecedor;
import com.alejandro.ecommerce.fornecedor.FornecedorRepository;
import org.springframework.stereotype.Service;

import java.math.BigDecimal;
import java.util.List;

@Service
public class ProdutoService {

    private final ProdutoRepository repository;
    private final DescricaoRepository descricaoRepository;
    private final CategoriaRepository categoriaRepository;
    private final FornecedorRepository fornecedorRepository;

    public ProdutoService(
            ProdutoRepository repository,
            DescricaoRepository descricaoRepository,
            CategoriaRepository categoriaRepository,
            FornecedorRepository fornecedorRepository) {

        this.repository = repository;
        this.descricaoRepository = descricaoRepository;
        this.categoriaRepository = categoriaRepository;
        this.fornecedorRepository = fornecedorRepository;
    }

    // LISTAR TODOS
    public List<Produto> findAll() {
        return repository.findAll();
    }

    // BUSCAR VARIOS IDS
    public List<Produto> findAllByIds(List<Long> ids) {
        return repository.findAllById(ids);
    }

    // SALVAR
    public Produto salvar(Produto produto) {

        Descricao descricao = produto.getDescricao();

        if (descricao != null && descricao.getId() == null) {
            descricao = descricaoRepository.save(descricao);
        }

        produto.setDescricao(descricao);
        return repository.save(produto);
    }

    // BUSCA COM FILTROS
    public List<ProdutoViewer> buscar(
            Long fornecedorId,
            Long categoriaId,
            Boolean ativo,
            BigDecimal min,
            BigDecimal max,
            String q
    ) {
        if (q != null && q.isBlank()) {
            q = null;
        }

        List<Produto> produtos = repository.buscarComFiltros(
                fornecedorId, categoriaId, ativo, min, max, q
        );

        return produtos.stream()
                .map(this::toViewer)
                .toList();
    }

    // BUSCAR POR ID
    public ProdutoViewer getIdProduto(Long id) {
                Produto produto= repository.findById(id)
                .orElseThrow(() -> new RuntimeException("Produto não encontrado"));

                return toViewer(produto);
    }

    // ATUALIZAR
    public Produto atualizar(Produto produtoAtualizado) {

        Produto produto = repository.findById(produtoAtualizado.getId())
                .orElseThrow(() -> new RuntimeException("Produto não encontrado"));

        produto.setNome(produtoAtualizado.getNome());
        produto.setValor(produtoAtualizado.getValor());

        // categoria
        if (produtoAtualizado.getCategoria() != null &&
                produtoAtualizado.getCategoria().getId() != null) {

            Categoria categoria = categoriaRepository.findById(
                    produtoAtualizado.getCategoria().getId()
            ).orElseThrow(() -> new RuntimeException("Categoria não encontrada"));

            produto.setCategoria(categoria);
        }

        // fornecedor
        if (produtoAtualizado.getFornecedor() != null &&
                produtoAtualizado.getFornecedor().getId() != null) {

            Fornecedor fornecedor = fornecedorRepository.findById(
                    produtoAtualizado.getFornecedor().getId()
            ).orElseThrow(() -> new RuntimeException("Fornecedor não encontrado"));

            produto.setFornecedor(fornecedor);
        }

        // descricao
        if (produtoAtualizado.getDescricao() != null) {

            Descricao descricao = produto.getDescricao();

            if (descricao == null) {
                descricao = new Descricao();
            }

            descricao.setTexto(produtoAtualizado.getDescricao().getTexto());
            descricao = descricaoRepository.save(descricao);

            produto.setDescricao(descricao);
        }

        return repository.save(produto);
    }
// MAPPER
    private ProdutoViewer toViewer(Produto produto) {

        List<String> imagens = produto.getImagens()
                .stream()
                .map(img -> img.getEndereco())
                .toList();

        String descricao = produto.getDescricao() != null
                ? produto.getDescricao().getTexto()
                : null;

        String categoria = produto.getCategoria() != null
                ? produto.getCategoria().getTipo()
                : null;

        return new ProdutoViewer(
                produto.getId(),
                produto.getNome(),
                produto.getValor(),
                descricao,
                imagens,
                categoria
        );
    }

    private ProdutoBuscarViewer toBuscarViewer(Produto produto) {
        String imagem = produto.getImagens().isEmpty()
                ? null
                : produto.getImagens().get(0).getEndereco();

        return new ProdutoBuscarViewer(
                produto.getId(),
                produto.getNome(),
                imagem,
                produto.getValor().doubleValue()
        );
    }
}