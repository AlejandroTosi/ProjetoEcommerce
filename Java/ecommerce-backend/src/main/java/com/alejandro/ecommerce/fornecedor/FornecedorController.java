package com.alejandro.ecommerce.fornecedor;

import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/fornecedor")
public class FornecedorController {

    private final FornecedorService fornecedorService;

    public FornecedorController(FornecedorService fornecedorService) {
        this.fornecedorService = fornecedorService;
    }

    // Criar
    @PostMapping("/adicionar")
    public Fornecedor cadastrar(@RequestBody Fornecedor fornecedor){
        return fornecedorService.cadastrar(fornecedor);
    }

    // Listar
    @GetMapping
    public List<Fornecedor> listar(){
        return fornecedorService.listarTodos();
    }

    // Buscar por nome
    @GetMapping("/buscar")
    public List<Fornecedor> buscar(@RequestParam String nome){
        return fornecedorService.buscar(nome);
    }

    // Alterar
    @PutMapping("/{id}")
    public Fornecedor alterar(@PathVariable Long id,
                              @RequestBody Fornecedor fornecedor){
        return fornecedorService.alterar(id, fornecedor);
    }
}

