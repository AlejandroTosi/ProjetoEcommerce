package com.alejandro.ecommerce.estoque;

import com.alejandro.ecommerce.produto.Produto;
import com.fasterxml.jackson.annotation.JsonBackReference;
import jakarta.persistence.*;

@Entity
@Table(name = "estoque")
public class Estoque {

    @Id
    private Long id;

    @OneToOne(optional = false)
    @MapsId
    @JoinColumn(name = "produto_id")
    @JsonBackReference
    private Produto produto;

    @Column(nullable = false)
    private Integer quantidade;

    public Long getId() {
        return id;
    }

    public Produto getProduto() {
        return produto;
    }

    public void setProduto(Produto produto) {
        this.produto = produto;
        this.id = produto.getId();
    }

    public Integer getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(Integer quantidade) {
        this.quantidade = quantidade;
    }
}
