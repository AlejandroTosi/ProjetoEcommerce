package com.alejandro.ecommerce.categoria;

import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController
@RequestMapping("/api/categoria")
public class CategoriaController {

    private final CategoriaService service;

    public CategoriaController(CategoriaService service) {
        this.service = service;
    }

    @GetMapping
    public List<Categoria> listar() {
        return service.listarTodos();
    }

    @GetMapping("/buscar")
    public List<Categoria> buscar(@RequestParam String q) {
        return service.buscar(q);
    }

    @PostMapping("/alterar")
    public Categoria alterar(
            @RequestParam Long id,
            @RequestParam String tipo) {
        return service.alterar(id, tipo);
    }
}
