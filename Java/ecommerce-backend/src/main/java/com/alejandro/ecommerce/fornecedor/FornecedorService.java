package com.alejandro.ecommerce.fornecedor;

import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class FornecedorService {

    private final FornecedorRepository repo;

    public FornecedorService(FornecedorRepository repo){
        this.repo = repo;
    }

    public Fornecedor cadastrar(Fornecedor f){

        if(repo.existsByCnpj(f.getCnpj()))
            throw new RuntimeException("CNPJ já cadastrado");

        return repo.save(f);
    }

    public List<Fornecedor> listarTodos(){
        return repo.findAll();
    }

    public List<Fornecedor> buscar(String nome){
        return repo.findByRazaoSocialContainingIgnoreCase(nome);
    }

    public Fornecedor alterar(Long id, Fornecedor novo){

        Fornecedor atual = repo.findById(id)
                .orElseThrow(() -> new RuntimeException("Fornecedor não encontrado"));

        atual.setRazaoSocial(novo.getRazaoSocial());
        atual.setNumeroContato(novo.getNumeroContato());
        atual.setEmailContato(novo.getEmailContato());
        atual.setCnpj(novo.getCnpj());

        return repo.save(atual);
    }
}
