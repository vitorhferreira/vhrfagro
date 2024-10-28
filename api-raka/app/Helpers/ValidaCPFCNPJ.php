<?php
namespace App\Helpers;
class ValidaCPFCNPJ {
    private $valor;

    public function __construct($valor = null) {
        // Remove qualquer caracter que não seja número
        $this->valor = preg_replace('/[^0-9]/', '', $valor);
    }

    public function valida() {
        // Verifica se o valor tem 11 caracteres para CPF ou 14 para CNPJ
        if (strlen($this->valor) == 11) {
            return $this->validaCPF();
        } elseif (strlen($this->valor) == 14) {
            return $this->validaCNPJ();
        } else {
            return false;
        }
    }

    // Função para validar CPF
    private function validaCPF() {
        // Elimina CPFs com dígitos repetidos
        if (preg_match('/(\d)\1{10}/', $this->valor)) {
            return false;
        }

        // Faz o cálculo dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $this->valor[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($this->valor[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    // Função para validar CNPJ
    private function validaCNPJ() {
        // Elimina CNPJs com dígitos repetidos
        if (preg_match('/(\d)\1{13}/', $this->valor)) {
            return false;
        }

        // Faz o cálculo dos dígitos verificadores
        $tamanho = strlen($this->valor) - 2;
        $numeros = substr($this->valor, 0, $tamanho);
        $digitos = substr($this->valor, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;

        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }

        $resultado = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);
        if ($resultado != $digitos[0]) {
            return false;
        }

        $tamanho++;
        $numeros = substr($this->valor, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;

        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }

        $resultado = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);
        if ($resultado != $digitos[1]) {
            return false;
        }

        return true;
    }

    // Função para formatar CPF ou CNPJ
    public function formata() {
        if (strlen($this->valor) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->valor);
        } elseif (strlen($this->valor) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $this->valor);
        }

        return null;
    }
}

