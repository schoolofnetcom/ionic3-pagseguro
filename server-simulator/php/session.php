<?php
//Pagamento transparente

//1 - Conectar com pagseguro e gerar uma sessão - token
//2 - Iniciar uma biblioteca javascript do pagseguro passando este token
//3 - Gerar outro token para enviar para o servidor com as informações de pagamento

require_once __DIR__ . '/vendor/autoload.php';
//CORS - Aplicativo 8100 | Aplicacao php 8000
header('Access-Control-Allow-Origin: *');

putenv('PAGSEGURO_EMAIL=argentinaluiz@yahoo.com.br');
putenv('PAGSEGURO_TOKEN_SANDBOX=AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
putenv('PAGSEGURO_ENV=sandbox');

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("School of Net")->setRelease("10.0.1");
\PagSeguro\Library::moduleVersion()->setName("School of Net")->setRelease("10.0.2");

$sessionCode = \PagSeguro\Services\Session::create(
    \PagSeguro\Configuration\Configure::getAccountCredentials()
);

echo json_encode([
    'sessionId' => $sessionCode->getResult()
]);