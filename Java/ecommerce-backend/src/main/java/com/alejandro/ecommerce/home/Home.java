package com.alejandro.ecommerce.home;

import jakarta.persistence.*;

@Entity
@Table(name = "home")
public class Home {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable=false, unique=true)
    private Integer posicao;

    @Column(nullable=false)
    private Boolean ativo = true;

    @Column(name="produtoid", nullable=false)
    private Long produtoId;

    public Long getId(){ return id; }

    public Long getProdutoId(){ return produtoId; }
    public void setProdutoId(Long produtoId){ this.produtoId = produtoId; }

    public Integer getPosicao(){ return posicao; }
    public void setPosicao(Integer posicao){ this.posicao = posicao; }

    public Boolean getAtivo(){ return ativo; }
    public void setAtivo(Boolean ativo){ this.ativo = ativo; }
}