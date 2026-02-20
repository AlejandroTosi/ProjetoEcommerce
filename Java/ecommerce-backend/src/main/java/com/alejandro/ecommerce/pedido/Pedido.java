package com.alejandro.ecommerce.pedido;
import java.util.List;

import com.alejandro.ecommerce.itempedido.ItemPedido;
import com.alejandro.ecommerce.usuario.Usuario;
import jakarta.persistence.*;

import java.math.BigDecimal;
import java.time.LocalDateTime;

@Entity
@Table(name = "pedidos")
public class Pedido {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne(optional = false)
    @JoinColumn(name = "usuario_id")
    private Usuario usuario;

    @Column(nullable = false, length = 30)
    private String status;

    @Column(name = "data_criacao", nullable = false)
    private LocalDateTime dataCriacao;

    @Column(name = "valor_total", nullable = false, precision = 12, scale = 2)
    private BigDecimal valorTotal;

    @OneToMany(mappedBy = "pedido")
    private List<ItemPedido> itens;

    public Long getId() {
        return id;
    }

    public Usuario getUsuario() {
        return usuario;
    }

    public void setUsuario(Usuario usuario) {
        this.usuario = usuario;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public LocalDateTime getDataCriacao() {
        return dataCriacao;
    }

    public void setDataCriacao(LocalDateTime dataCriacao) {
        this.dataCriacao = dataCriacao;
    }

    public BigDecimal getValorTotal() {
        return valorTotal;
    }

    public void setValorTotal(BigDecimal valorTotal) {
        this.valorTotal = valorTotal;
    }
}
