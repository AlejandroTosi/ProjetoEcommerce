package com.alejandro.ecommerce.carrinho;

import com.alejandro.ecommerce.produto.Produto;
import com.alejandro.ecommerce.usuario.Usuario;
import jakarta.persistence.*;

@Entity
@Table(name = "carrinho")
public class Carrinho {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne(optional = false)
    @JoinColumn(name = "usuario_id")
    private Usuario usuario;

    @ManyToOne(optional = false)
    @JoinColumn(name = "produto_id")
    private Produto produto;

    @Column(nullable = false)
    private Integer quantidade;

    // Getters e Setters
    public Long getId() { return id; }
    public Usuario getUsuario() { return usuario; }
    public void setUsuario(Usuario usuario) { this.usuario = usuario; }
    public Produto getProduto() { return produto; }
    public void setProduto(Produto produto) { this.produto = produto; }
    public Integer getQuantidade() { return quantidade; }
    public void setQuantidade(Integer quantidade) { this.quantidade = quantidade; }
}
