package com.alejandro.ecommerce.imagem;

import jakarta.annotation.Resource;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.ByteArrayResource;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.Map;

@RestController
@RequestMapping("/api/imagem")
public class ImagemController {

    @Autowired
    private ImagemService imagemService;

    @GetMapping("/produtos/{id}/imagem")
    public ResponseEntity<?> obterImagem(@PathVariable Long id) {
        Imagem img = imagemService.buscarPrincipal(id);
        if (img == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(Map.of(
                "url", img.getEndereco()
        ));
    }


    @PostMapping("/produtos/{id}/imagem")
    public ResponseEntity<?> uploadImagem(
            @PathVariable Long id,
            @RequestParam MultipartFile file,
            @RequestParam ImagemTipo tipo
    ) throws IOException {

        imagemService.salvarImagemProduto(id, file, tipo);
        return ResponseEntity.ok().build();
    }
}

