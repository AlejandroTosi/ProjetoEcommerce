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
    // Endpoint para adicionar ou remover produtos
    // Usado em situações atipicas como avarias ou ajustes.
        @PutMapping
        public EstoqueDTO putById(@RequestBody EstoqueUpdateDTO estoqueUpdateDTO){
            Long id = estoqueUpdateDTO.id();
            Integer quantidade = estoqueUpdateDTO.quantidade();

            return service.alterar(id, quantidade);
        }
    }

