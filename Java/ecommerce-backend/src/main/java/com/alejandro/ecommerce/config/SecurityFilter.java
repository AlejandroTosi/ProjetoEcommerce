package com.alejandro.ecommerce.config;

import com.alejandro.ecommerce.usuario.TokenService;
import com.alejandro.ecommerce.usuario.UsuarioRepository;
import jakarta.servlet.FilterChain;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Component;
import org.springframework.web.filter.OncePerRequestFilter;

import java.io.IOException;

@Component
public class SecurityFilter extends OncePerRequestFilter {

    private final TokenService tokenService;
    private final UsuarioRepository usuarioRepository;

    public SecurityFilter(TokenService tokenService, UsuarioRepository usuarioRepository) {
        this.tokenService = tokenService;
        this.usuarioRepository = usuarioRepository;
    }

    @Override
    protected void doFilterInternal(HttpServletRequest request, HttpServletResponse response, FilterChain filterChain) throws ServletException, IOException {

        // Extrair token do header
        String token = extrairToken(request);

        if (token != null && tokenService.isTokenValido(token)) {
            // Obter username do token
            String username = tokenService.obterUsername(token);

            // Buscar usuário no banco
            var usuario = usuarioRepository.findByUsername(username).orElse(null);

            if (usuario != null) {
                // Criar autenticação e adicionar ao contexto
                var auth = new UsernamePasswordAuthenticationToken(
                        username,
                        null,
                        usuario.getAuthorities()
                );
                SecurityContextHolder.getContext().setAuthentication(auth);
            }
        }

        filterChain.doFilter(request, response);
    }

    // Extrai o token do header Authorization
    private String extrairToken(HttpServletRequest request) {
        String header = request.getHeader("Authorization");
        if (header != null && header.startsWith("Bearer ")) {
            return header.substring(7); // Remove "Bearer "
        }
        return null;
    }
}
