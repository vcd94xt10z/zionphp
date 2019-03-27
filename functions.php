<?php
/**
 * Este arquivo deve conter funções que estaram disponível no escopo global
 * Coloque aqui as funções para ajustar algum comportamento incorreto
 */
function old_count($arg){
    if(is_array($arg)){
        return count($arg);
    }else{
        return 0;
    }
}
?>