<?php

use Prophecy\Argument;

class IMCDublesTest extends PHPUnit_Framework_TestCase
{
  // Propriedade que armazenará o Profeta
  private $profeta;

  public function setUp() {
    $this->profeta = new \Prophecy\Prophet();
  }

  public function testCalcularIMCValido() {
    // Arrange

    // Fazendo a profecia
    $profecia = $this->profeta->prophesize('Pessoa');

    // Stub do método get/setAtura()
    $profecia->getAltura()->willReturn(null);

    /*
      - Sobre Promessas (isso categoria este dublê como um Stub):

      willReturnArgument($indice) // Retorna um dos argumentos de entrada segundo o índice
      willThrow(Exception) // Lança uma exceção
      will(function ($args) {
          if ($args[0] == 0) {
              return true;
          } else {
              trow new Exception(0);
          }
      });
    */

    $profecia->setAltura(Argument::type('double'))->will(function ($args) use ($profecia) {
      $profecia->getAltura()->willReturn($args[0]);
    });

    /*
      - Sobre Argumentos:

      Argument::type('string') // Aceitará apenas strings, mas poderia qualquer tipo ou classe :)
      Argument::containingString($value) // Um trecho de uma string que deverá ser declarada
    */

    // Stub do método get/setPeso()
    $profecia->getPeso()->willReturn(null);
    $profecia->setPeso(Argument::type('double'))->will(function ($args) use ($profecia) {
      $profecia->getPeso()->willReturn($args[0]);
    })->shouldNotBeCalled();

    /*
      - Sobre Predições (isso categoria este dublê como um Mock):

      shouldBeCalled() // Valida se o método foi chaamdo ao meno uma vez
      shouldBeCalledTimes($contagem) // Valida que o método foi chamado N ($contagem) vezes
    */

    // Revelando a profecia
    $pessoa = $profecia->reveal();

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
    $profecia = $this->profeta->prophesize('Pessoa');

    // Stub do método get/setAtura()
    $profecia->getAltura()->willReturn(null);
    $profecia->setAltura(Argument::type('double'))->will(function ($args) use ($profecia) {
      $profecia->getAltura()->willReturn($args[0]);
    });

    // Stub do método get/setPeso()
    $profecia->getPeso()->willReturn(null);
    $profecia->setPeso(Argument::type('double'))->will(function ($args) use ($profecia) {
      $profecia->getPeso()->willReturn($args[0]);
    });

    // Revelando a profecia
    $pessoa = $profecia->reveal();

    // Espera-se que durante o teste uma exceção seja lançada
    $this->setExpectedException('Exception', 'Ta de brincadeira?');

    // Act
    $pessoa->setAltura(1.89);
    $imc       = new IMC($pessoa);
    $resultado = $imc->calcular();
  }

  public function testCalcularIMCSemAltura() {
    // Arrange
    $profecia = $this->profeta->prophesize('Pessoa');

    // Stub do método get/setAtura()
    $profecia->getAltura()->willReturn(null);
    $profecia->setAltura(Argument::type('double'))->will(function ($args) use ($profecia) {
      $profecia->getAltura()->willReturn($args[0]);
    });

    // Stub do método get/setPeso()
    $profecia->getPeso()->willReturn(null);
    $profecia->setPeso(Argument::type('double'))->will(function ($args) use ($profecia) {
      $profecia->getPeso()->willReturn($args[0]);
    });

    // Revelando a profecia
    $pessoa = $profecia->reveal();

    // Espera-se que durante o teste uma exceção seja lançada
    $this->setExpectedException('Exception', 'Ta de brincadeira?');

    // Act
    $pessoa->setPeso(84.00);
    $imc       = new IMC($pessoa);
    $resultado = $imc->calcular();
  }

  public function testCalcularIMCSemAlturaEPeso() {
    // Arrange
    $profecia = $this->profeta->prophesize('Pessoa');

    // Revelando a profecia
    $pessoa = $profecia->reveal();

    // Espera-se que durante o teste uma exceção seja lançada
    $this->setExpectedException('Exception', 'Ta de brincadeira?');

    // Act
    $imc       = new IMC($pessoa);
    $resultado = $imc->calcular();
  }

  /**
    * @dataProvider insumosCategorizarICM
  */
  public function testCategorizarPessoa($altura, $peso, $categoria) {
    // Arrange
    $profecia = $this->profeta->prophesize('Pessoa');

    // Stub do método get/setAtura()
    $profecia->getAltura()->willReturn(null);
    $profecia->setAltura(Argument::type('double'))->will(function ($args) use ($profecia) {
      $profecia->getAltura()->willReturn($args[0]);
    });

    // Stub do método get/setPeso()
    $profecia->getPeso()->willReturn(null);
    $profecia->setPeso(Argument::type('double'))->will(function ($args) use ($profecia) {
      $profecia->getPeso()->willReturn($args[0]);
    });

    // Revelando a profecia
    $pessoa = $profecia->reveal();

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
