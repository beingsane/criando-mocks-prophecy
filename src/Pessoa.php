<?php
  class Pessoa implements IPessoa
  {
    private $peso;
    private $altura;

    public function getPeso() {
      return $this->peso;
    }

    public function setPeso($peso) {
      $this->peso = $peso;
    }

    public function getAltura() {
      return $this->altura;
    }

    public function setAltura($altura) {
      $this->altura = $altura;
    }
  }
