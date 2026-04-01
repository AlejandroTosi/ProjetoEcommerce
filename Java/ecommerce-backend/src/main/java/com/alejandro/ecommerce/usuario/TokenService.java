package com.alejandro.ecommerce.usuario;

import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.SignatureAlgorithm;
import io.jsonwebtoken.Claims;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import java.util.Date;

@Service
public class TokenService {

    @Value("${jwt.secret:sua-chave-super-secreta-cambiar-em-producao}")
    private String jwtSecret;

    @Value("${jwt.expiration:86400000}")
    private long jwtExpiration;

    // Gera um JWT baseado no usuário
    public String gerarToken(Usuario usuario) {
        Date agora = new Date();
        Date expiracao = new Date(agora.getTime() + jwtExpiration);

        return Jwts.builder()
                .subject(usuario.getUsername())
                .issuedAt(agora)
                .expiration(expiracao)
                .signWith(SignatureAlgorithm.HS256, jwtSecret)
                .compact();
    }

    // Valida e extrai o username do token
    public String obterUsername(String token) {
        try {
            Claims claims = Jwts.parser()
                    .setSigningKey(jwtSecret)
                    .build()
                    .parseSignedClaims(token)
                    .getPayload();
            return claims.getSubject();
        } catch (Exception e) {
            throw new RuntimeException("Token inválido ou expirado");
        }
    }

    // Verifica se o token é válido
    public boolean isTokenValido(String token) {
        try {
            Jwts.parser()
                    .setSigningKey(jwtSecret)
                    .build()
                    .parseSignedClaims(token);
            return true;
        } catch (Exception e) {
            return false;
        }
    }
}
