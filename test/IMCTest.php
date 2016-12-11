<?php

class IMCTest extends PHPUnit_Framework_TestCase
{
  public function testCalcularIMCValido() {
    // Arrange
    $pessoa = new Pessoa();

    // Act
    $pessoa->setAltura(1.89);
    $pessoa->setPeso(84.00);
    $imc       = new IMC($pessoa);
    $resultado = $imc->calcular();

    // Assert
    $this->assertEquals(23.5155790711, $resultado);
  }

  public function testCalcularIMCSemPeso() {
    // Arrange
    $pessoa = new Pessoa();
    $this->setExpectedException('Exception', 'Ta de brincadeira?'); // Espera-se que durante o teste uma exceção seja lançada

    // Act
    $pessoa->setAltura(1.89);
    $imc       = new IMC($pessoa);
    $resultado = $imc->calcular();
  }

  public function testCalcularIMCSemAltura() {
    // Arrange
    $pessoa = new Pessoa();
    $this->setExpectedException('Exception', 'Ta de brincadeira?'); // Espera-se que durante o teste uma exceção seja lançada

    // Act
    $pessoa->setPeso(84.00);
    $imc       = new IMC($pessoa);
    $resultado = $imc->calcular();
  }

  public function testCalcularIMCSemAlturaEPeso() {
    // Arrange
    $pessoa = new Pessoa();
    $this->setExpectedException('Exception', 'Ta de brincadeira?'); // Espera-se que durante o teste uma exceção seja lançada

    // Act
    $imc       = new IMC($pessoa);
    $resultado = $imc->calcular();
  }

  /**
    * @dataProvider insumosCategorizarICM
  */
  public function testCategorizarPessoa($altura, $peso, $categoria) {
    // Arrange
    $pessoa = new Pessoa();

    // Act
    $pessoa->setAltura($altura);
    $pessoa->setPeso($peso);
    $imc       = new IMC($pessoa);
    $resultado = $imc->categorizar();

    // Assert
    $this->assertEquals($categoria, $resultado);
  }

  public function insumosCategorizarICM(){
    return [
      [ 1.89, 44.00, "Muito abaixo do peso" ],
      [ 1.89, 64.00, "Abaixo do peso" ],
      [ 1.89, 84.00, "Peso Normal" ],
      [ 1.89, 94.00, "Acima do Peso" ],
      [ 1.89, 114.00, "Obesidade I" ],
      [ 1.89, 134.00, "Obesidade II (severa)" ],
      [ 1.89, 164.00, "Obesidade III (mórbida)" ]
    ];
  }
}
