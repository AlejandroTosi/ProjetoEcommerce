package com.alejandro.ecommerce.produto;

import com.alejandro.ecommerce.categoria.Categoria;
import com.alejandro.ecommerce.descricao.Descricao;
import com.alejandro.ecommerce.fornecedor.Fornecedor;
import com.alejandro.ecommerce.estoque.Estoque;
import com.alejandro.ecommerce.imagem.Imagem;

import com.fasterxml.jackson.annotation.JsonManagedReference;
import jakarta.persistence.*;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;

@Entity
@Table(name = "produtos")
public class Produto {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false, length = 150)
    private String nome;

    @ManyToOne
    @JoinColumn(name = "categoria_id")
    private Categoria categoria;

    @ManyToOne
    @JoinColumn(name = "descricao_id")
    private Descricao descricao;

    @Column(nullable = false, precision = 10, scale = 2)
    private BigDecimal valor;

    @ManyToOne
    @JoinColumn(name = "fornecedor_id")
    private Fornecedor fornecedor;

    @Column(nullable = false)
    private Boolean ativo = true;

    @OneToOne(mappedBy = "produto")
    @JsonManagedReference
    private Estoque estoque;

    @OneToMany(
            mappedBy = "produto",
            cascade = CascadeType.ALL,
            orphanRemoval = true,
            fetch = FetchType.LAZY
    )
    private List<Imagem> imagens = new ArrayList<>();

    // GETTERS E SETTERS

    public Long getId() {
        return id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public Categoria getCategoria() {
        return categoria;
    }

    public void setCategoria(Categoria categoria) {
        this.categoria = categoria;
    }

    public Descricao getDescricao() {
        return descricao;
    }

    public void setDescricao(Descricao descricao) {
        this.descricao = descricao;
    }

    public BigDecimal getValor() {
        return valor;
    }

    public void setValor(BigDecimal valor) {
        this.valor = valor;
    }

    public Fornecedor getFornecedor() {
        return fornecedor;
    }

    public void setFornecedor(Fornecedor fornecedor) {
        this.fornecedor = fornecedor;
    }

    public Boolean getAtivo() {
        return ativo;
    }

    public void setAtivo(Boolean ativo) {
        this.ativo = ativo;
    }

    // ← ADICIONE ESTES AQUI
    public Estoque getEstoque() {
        return estoque;
    }

    public void setEstoque(Estoque estoque) {
        this.estoque = estoque;
    }

    public List<Imagem> getImagens() {
        return imagens;
    }

    public void setImagens(List<Imagem> imagens) {
        this.imagens = imagens;
    }
}