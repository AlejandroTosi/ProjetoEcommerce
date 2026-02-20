package com.alejandro.ecommerce.tipodeconta;

import com.alejandro.ecommerce.tipodeconta.TipoDeContaService;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/api/tipodeconta")
public class TipoDeContaController{

    private final TipoDeContaService TipoDeContaService;

    public TipoDeContaController(TipoDeContaService tipoDeContaService) {
        this.TipoDeContaService = tipoDeContaService;
    }
}


