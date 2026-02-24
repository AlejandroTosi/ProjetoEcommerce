package com.alejandro.ecommerce.estoque;
import org.springframework.web.bind.annotation.*;

import java.util.List;


@RestController
@RequestMapping("/api/estoque")
public class EstoqueController {

    private final EstoqueService service;

    public EstoqueController(EstoqueService estoqueService){
        this.service = estoqueService;
    }

        @GetMapping
        public List<Estoque> listar(){
            return service.findAll();
        }

        @GetMapping("/{id}")
        public Estoque getById(@PathVariable Long id){
                    return service.findById(id);
        }

        @PutMapping("/{id}")
        public Estoque putById(@PathVariable Long id,@RequestParam Integer quantidade){
            return service.alterar(id, quantidade);
        }
    }

