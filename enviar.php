<?php
// Recebe o formulário de orçamento do site e envia por e-mail.
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

const DESTINO = 'contato@soloverdeambiental.com.br';
const REMETENTE = 'contato@soloverdeambiental.com.br';

function responder($ok, $status = 200, $erro = null) {
  http_response_code($status);
  echo json_encode($erro ? ['ok' => $ok, 'erro' => $erro] : ['ok' => $ok], JSON_UNESCAPED_UNICODE);
  exit;
}

// GET simples para conferir se o PHP está ativo
if ($_SERVER['REQUEST_METHOD'] === 'GET') responder(true);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') responder(false, 405, 'método');

// campo-isca: robôs preenchem, pessoas não veem
if (!empty($_POST['site'])) responder(true);

function campo($nome, $max = 200) {
  $v = trim((string)($_POST[$nome] ?? ''));
  $v = str_replace(["\r\n", "\r"], "\n", $v);
  return mb_substr($v, 0, $max);
}
function linha($v) { return trim(preg_replace('/[\r\n]+/', ' ', $v)); }

$nome    = linha(campo('nome', 120));
$empresa = linha(campo('empresa', 120));
$tel     = linha(campo('tel', 40));
$email   = linha(campo('email', 160));
$tipo    = linha(campo('tipo', 60));
$area    = linha(campo('area', 40));
$cidade  = linha(campo('cidade', 120));
$msg     = campo('msg', 3000);

if ($nome === '' || $tel === '') responder(false, 422, 'obrigatorios');
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $email = '';

$corpo = "Novo pedido de orçamento pelo site\n\n"
  . "Nome: $nome\n"
  . ($empresa !== '' ? "Empresa: $empresa\n" : '')
  . "Telefone/WhatsApp: $tel\n"
  . ($email !== '' ? "E-mail: $email\n" : '')
  . "Tipo de obra: $tipo\n"
  . ($area !== '' ? "Área estimada: $area m²\n" : '')
  . ($cidade !== '' ? "Cidade da obra: $cidade\n" : '')
  . ($msg !== '' ? "\nSobre a área:\n$msg\n" : '')
  . "\n—\nEnviado pelo formulário de soloverdeambiental.com.br em " . date('d/m/Y H:i');

$assunto = '=?UTF-8?B?' . base64_encode("Orçamento pelo site: $nome" . ($cidade !== '' ? " ($cidade)" : '')) . '?=';
$cabecalhos = [
  'MIME-Version: 1.0',
  'Content-Type: text/plain; charset=UTF-8',
  'Content-Transfer-Encoding: 8bit',
  'From: =?UTF-8?B?' . base64_encode('Site Solo Verde') . '?= <' . REMETENTE . '>',
];
if ($email !== '') $cabecalhos[] = 'Reply-To: ' . $email;

$ok = mail(DESTINO, $assunto, $corpo, implode("\r\n", $cabecalhos), '-f' . REMETENTE);
responder($ok, $ok ? 200 : 500, $ok ? null : 'envio');
