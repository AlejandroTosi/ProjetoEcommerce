package com.alejandro.ecommerce.imagem;

import com.alejandro.ecommerce.produto.Produto;
import com.fasterxml.jackson.annotation.JsonIgnore;
import jakarta.persistence.*;

@Entity
@Table(name = "imagens")
public class Imagem {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne(optional = false)
    @JoinColumn(name = "produto_id")
    @JsonIgnore
    private Produto produto;

    @Enumerated(EnumType.STRING)
    @Column(nullable = false)
    private ImagemTipo tipo;

    @Column(nullable = false, columnDefinition = "TEXT")
    private String endereco;

    public Long getId() {
        return id;
    }

    public Produto getProduto() {
        return produto;
    }

    public void setProduto(Produto produto) {
        this.produto = produto;
    }

    public ImagemTipo getTipo() {
        return tipo;
    }

    public void setTipo(ImagemTipo tipo) {
        this.tipo = tipo;
    }

    public String getEndereco() {
        return endereco;
    }

    public void setEndereco(String endereco) {
        this.endereco = endereco;
    }
}
