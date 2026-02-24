package com.alejandro.ecommerce.produto;

import org.springframework.web.bind.annotation.*;

import java.math.BigDecimal;
import java.util.List;

@RestController
@RequestMapping("/api/produtos")
public class ProdutoController {

    private final ProdutoService service;

    public ProdutoController(ProdutoService service) {
        this.service = service;
    }

    // LISTAR TODOS
    @GetMapping
    public List<Produto> listar() {
        return service.findAll();
    }

    // BUSCAR POR ID
    @GetMapping("/{id}")
    public Produto buscarPorId(@PathVariable Long id) {
        return service.getIdProduto(id);
    }

    // BUSCA COM FILTROS
    @GetMapping("/buscar")
    public List<Produto> buscar(
            @RequestParam(required = false) Long fornecedorId,
            @RequestParam(required = false) Long categoriaId,
            @RequestParam(required = false) Boolean ativo,
            @RequestParam(required = false) BigDecimal min,
            @RequestParam(required = false) BigDecimal max,
            @RequestParam(required = false) String q
    ) {
        return service.buscar(fornecedorId, categoriaId, ativo, min, max, q);
    }

    // BUSCAR VARIOS POR IDS (Listas)
    @PostMapping("/by-ids")
    public List<Produto> buscarPorIds(@RequestBody List<Long> ids) {
        return service.findAllByIds(ids);
    }

    // CRIAR
    @PostMapping
    public Produto criar(@RequestBody Produto produto) {
        return service.salvar(produto);
    }

    // ATUALIZAR
    @PutMapping
    public Produto atualizar(@RequestBody Produto produto){
        return service.atualizar(produto);
    }
}