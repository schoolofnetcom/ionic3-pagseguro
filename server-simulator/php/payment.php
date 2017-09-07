<?php

require_once __DIR__ . '/vendor/autoload.php';
//CORS - Aplicativo 8100 | Aplicacao php 8000
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

putenv('PAGSEGURO_EMAIL=argentinaluiz@yahoo.com.br');
putenv('PAGSEGURO_TOKEN_SANDBOX=AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
putenv('PAGSEGURO_ENV=sandbox');

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("School of Net")->setRelease("10.0.1");
\PagSeguro\Library::moduleVersion()->setName("School of Net")->setRelease("10.0.2");

function paymentWithCreditCard($items, $hash, $total, $token)
{
    $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
    $creditCard->setMode('DEFAULT');

    $creditCard->setCurrency('BRL');

    foreach ($items as $key => $item) {
        $creditCard
            ->addItems()
            ->withParameters("00$key", $item['name'], 1, $item['price']);
    }

    $creditCard->setSender()
        ->setName('Fulaninho de tal')
        ->setEmail('fulaninho@sandbox.pagseguro.com.br')
        ->setPhone()->withParameters('11', '11111111');

    $creditCard->setSender()->setDocument()->withParameters('CPF', '156.009.442-76');
    $creditCard->setSender()->setHash($hash);

    $creditCard->setInstallment()->withParameters(1, $total);

    $creditCard->setShipping()
        ->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

    $creditCard->setBilling()
        ->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

    $creditCard->setToken($token);

    $creditCard->setHolder()->setName('Fulaninho de tal');
    $creditCard->setHolder()->setBirthDate(date('01/01/2000'));
    $creditCard->setHolder()->setPhone()->withParameters('11', '11111111');
    $creditCard->setHolder()->setDocument()->withParameters('CPF', '156.009.442-76');

    try{
        /** @var \PagSeguro\Parsers\Transaction\CreditCard\Response $result */
        $result = $creditCard->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
        echo json_encode([
            'code' => $result->getCode()
        ]);
    }catch (\Exception $e){
        http_response_code(500);
        echo json_encode([
            'error' => $e->getMessage()
        ]);
    }

}

function paymentWithBankSlip($items,$hash,$total)
{
    $bankSlip = new \PagSeguro\Domains\Requests\DirectPayment\Boleto();
    $bankSlip->setMode('DEFAULT');
    $bankSlip->setReference('Compra na loja da SON');
    $bankSlip->setReceiverEmail('coloque o e-mail da sua conta aqui ou e-mail do comprador de testes');
    $bankSlip->setCurrency('BRL');

    foreach ($items as $key => $item) {
        $bankSlip
            ->addItems()
            ->withParameters("00$key", $item['name'], 1, $item['price']);
    }

    $bankSlip->setSender()
        ->setName('Fulaninho de tal')
        ->setEmail('fulaninho@sandbox.pagseguro.com.br')
        ->setPhone()->withParameters('11', '11111111');

    $bankSlip->setSender()->setDocument()->withParameters('CPF', '156.009.442-76');
    $bankSlip->setSender()->setHash($hash);

    $bankSlip->setShipping()
        ->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

    try{
        /** @var \PagSeguro\Parsers\Transaction\Boleto\Response $result */
        $result = $bankSlip->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
        echo json_encode([
            'code' => $result->getCode(),
            'link' => $result->getPaymentLink()
        ]);
    }catch (\Exception $e){
        http_response_code(500);
        echo json_encode([
            'error' => $e->getMessage()
        ]);
    }
}

$data = json_decode(file_get_contents('php://input'), true);
$method = $data['method'];
$items = $data['items'];
$hash = $data['hash'];
$total = $data['total'];
$token = $data['token'] ?? null; //isset($data['token']) ? $data['token']:null

if ($method == 'BOLETO') {
    paymentWithBankSlip($items,$hash,$total);
} elseif ($method == 'CREDIT_CARD') {
    paymentWithCreditCard($items,$hash,$total,$token);
}

