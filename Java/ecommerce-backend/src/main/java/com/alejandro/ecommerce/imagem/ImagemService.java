package com.alejandro.ecommerce.imagem;

import com.alejandro.ecommerce.produto.Produto;
import com.alejandro.ecommerce.produto.ProdutoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MaxUploadSizeExceededException;
import org.springframework.web.multipart.MultipartFile;



import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.UUID;

@Service
    public class ImagemService {

        @Autowired
        private ProdutoRepository produtoRepository;

        @Autowired
        private com.alejandro.ecommerce.imagem.ImagemRepository imagemRepository;

        public void salvarImagemProduto(Long produtoId, MultipartFile file, ImagemTipo tipo) throws IOException {
        long tamanhoMaximo = 2 * 1024 * 1024; //2mb
            if(file.getSize()> tamanhoMaximo){
                throw new MaxUploadSizeExceededException(tamanhoMaximo);
            }
            Produto produto = produtoRepository.findById(produtoId)
                    .orElseThrow();

            String nomeArquivo = UUID.randomUUID() + "_" + file.getOriginalFilename();

            Path caminho = Paths.get("uploads/produtos/" + nomeArquivo);
            Files.createDirectories(caminho.getParent());
            Files.copy(file.getInputStream(), caminho);

            Imagem img = new Imagem();
            img.setProduto(produto);
            img.setTipo(tipo);
            img.setEndereco("/uploads/produtos/" + nomeArquivo);

            imagemRepository.save(img);
        }


    public ImagemViewers buscarPrincipal(Long produtoId) {
        return imagemRepository
                .findFirstByProdutoIdAndTipo(produtoId, ImagemTipo.PRINCIPAL)
                .map(this::toViewer)
                .orElse(null);
    }


    private ImagemViewers toViewer(Imagem imagem) {
        return new ImagemViewers(
                imagem.getEndereco(),
                imagem.getTipo().name() // transforma enum em String
        );
    }


}


