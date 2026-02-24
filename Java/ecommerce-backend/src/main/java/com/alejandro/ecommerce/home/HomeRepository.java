package com.alejandro.ecommerce.home;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface HomeRepository extends JpaRepository<Home, Long> {

    List<Home> findByAtivoTrueOrderByPosicaoAsc();

    void deleteByPosicao(int posicao);

}
