package com.alejandro.ecommerce.tipodeconta;


import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class TipoDeContaService {

    private final TipoDeContaRepository tipodecontaRepository;

    public TipoDeContaService(TipoDeContaRepository tipodecontaRepository) {
        this.tipodecontaRepository = tipodecontaRepository;
    }

    public List<TipoDeConta> listarTodos() {
        return tipodecontaRepository.findAll();
    }

    public TipoDeConta salvar(TipoDeConta tipoDeConta){
        return tipodecontaRepository.save(tipoDeConta);
    }

}