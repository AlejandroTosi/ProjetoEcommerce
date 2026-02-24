package com.alejandro.ecommerce.home;

import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/home")
public class HomeController {

    private final HomeService homeService;

    public HomeController(HomeService homeService) {
        this.homeService = homeService;
    }

    @GetMapping
    public List<HomeViewer> listar(){
        return homeService.listar();
    }

    @PostMapping
    public HomeViewer adicionar(@RequestBody HomeInput input){
        return homeService.adicionar(input);
    }

    @DeleteMapping("/{posicao}")
    public void deletar(@PathVariable Integer posicao){
        homeService.deletar(posicao);
    }

}