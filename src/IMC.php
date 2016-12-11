<?php
  class IMC
  {
    private $pessoa;

    public function __construct(IPessoa $pessoa) {
      $this->pessoa = $pessoa;
    }

    // Calculando o IMC
    public function calcular() {
      if ($this->pessoa->getPeso() > 0 && $this->pessoa->getAltura() > 0) {
        return $this->pessoa->getPeso() / pow($this->pessoa->getAltura(), 2);
      } else {
        throw new Exception('Ta de brincadeira?');
      }
    }

    public function categorizar() {
      // Conseguindo o IMC
      $imc = self::calcular();

      //  Fazendo a categorização
      if ($imc <= 17) {
        $mensagem = "Muito abaixo do peso";
      } elseif(($imc > 17) and ($imc <= 18.49)) {
        $mensagem = "Abaixo do peso";
      } elseif(($imc > 18.49) and ($imc <= 24.99)) {
        $mensagem = "Peso Normal";
      } elseif(($imc > 24.99) and ($imc <= 29.99)) {
        $mensagem = "Acima do Peso";
      } elseif(($imc > 29.99) and ($imc <= 34.99)) {
        $mensagem = "Obesidade I";
      } elseif(($imc > 34.99) and ($imc <= 39.99)) {
        $mensagem = "Obesidade II (severa)";
      } else {
        $mensagem = "Obesidade III (mórbida)";
      }

      return $mensagem;
    }
  }
