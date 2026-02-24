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
    public List<Produto> buscar(
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

        return repository.buscarComFiltros(
                fornecedorId, categoriaId, ativo, min, max, q
        );
    }

    // BUSCAR POR ID
    public Produto getIdProduto(Long id) {
        return repository.findById(id)
                .orElseThrow(() -> new RuntimeException("Produto não encontrado"));
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
}