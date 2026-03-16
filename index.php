<?php

class ContaBancaria {
    private string $titular;
    private float $saldo;
    private array $extrato = []; // Armazena o histórico

    public function __construct(string $nomeTitular, float $saldoInicial) {
        $this->titular = $nomeTitular;
        $this->saldo = $saldoInicial;
        $this->registrarMovimentacao("Abertura de conta: R$ " . number_format($saldoInicial, 2, ',', '.'));
    }

    public function depositar(float $valor): void {
        $this->saldo += $valor;
        $this->registrarMovimentacao("Depósito: R$ " . number_format($valor, 2, ',', '.'));
    }

    public function sacar(float $valor): bool {
        if ($valor > $this->saldo) {
            $this->registrarMovimentacao("Tentativa de saque (Sem saldo): R$ " . number_format($valor, 2, ',', '.'));
            return false;
        }
        $this->saldo -= $valor;
        $this->registrarMovimentacao("Saque: R$ " . number_format($valor, 2, ',', '.'));
        return true;
    }

    private function registrarMovimentacao(string $mensagem): void {
        $data = date('d/m/Y H:i');
        $this->extrato[] = "[$data] $mensagem";
    }

    public function exibirExtrato(): void {
        echo "--- Extrato Bancário: {$this->titular} ---\n";
        foreach ($this->extrato as $linha) {
            echo $linha . "\n";
        }
        echo "Saldo Atual: R$ " . number_format($this->saldo, 2, ',', '.') . "\n";
    }
}

// Testando o código
$minhaConta = new ContaBancaria("Leandro Araújo", 500.00);
$minhaConta->depositar(200.00);
$minhaConta->sacar(100.00);
$minhaConta->exibirExtrato();
