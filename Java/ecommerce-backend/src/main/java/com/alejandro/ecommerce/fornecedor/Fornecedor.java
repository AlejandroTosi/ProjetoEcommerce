package com.alejandro.ecommerce.fornecedor;

import jakarta.persistence.*;

@Entity
@Table(name = "fornecedores")
public class Fornecedor {
    public Fornecedor() {}

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(length = 14, unique = true)
    private String cnpj;

    @Column(name = "razao_social", length = 150)
    private String razaoSocial;

    @Column(name = "email_contato", length = 150)
    private String emailContato;

    @Column(name = "numero_contato", length = 20)
    private String numeroContato;

    public Long getId() {
        return id;
    }

    public String getCnpj() {
        return cnpj;
    }

    public void setCnpj(String cnpj) {
        this.cnpj = cnpj;
    }

    public String getRazaoSocial() {
        return razaoSocial;
    }

    public void setRazaoSocial(String razaoSocial) {
        this.razaoSocial = razaoSocial;
    }

    public String getEmailContato() {
        return emailContato;
    }

    public void setEmailContato(String emailContato) {
        this.emailContato = emailContato;
    }

    public String getNumeroContato() {
        return numeroContato;
    }

    public void setNumeroContato(String numeroContato) {
        this.numeroContato = numeroContato;
    }
}


