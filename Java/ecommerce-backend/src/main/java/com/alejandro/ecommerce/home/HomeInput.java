package com.alejandro.ecommerce.home;

import jakarta.validation.constraints.NotNull;

public record HomeInput(
         @NotNull
        Long produtoId,

        @NotNull
        Integer posicao
) {}