IA utilizada: Chatgpt
O objetivo do uso da IA será para entender como poder integrar a API em um sistema.
Prompt inicial utilizado:

"Como eu integro uma API de clima ao meu sistema?

Sobre a API:

API de clima

Pesquise uma API que forneça informações meteorológicas e utilize seus dados na tela inicial do sistema. A integração deverá apresentar informações relevantes, como:
- Temperatura atual.
- Condições climáticas, como chuva, sol ou nebulosidade.
- Localização utilizada para consultar o clima.
- Data e horário da consulta ou da última atualização."

Ele me recomendou a API de clima: Open-Meteo

1-Gratuita para uso não comercial.

2-Não exige chave de API para o uso básico.

3-Fornece temperatura e condições climáticas.

4-Permite consultar o clima por coordenadas geográficas.

5-Disponibiliza data e horário dos dados.

Me explicou como funciona:

Usuário acessa a tela inicial -> PHP faz uma requisição à API -> API retorna os dados meteorológicos -> PHP organiza as informações -> Clima aparece na tela inicial.

E me deu um exemplo de código para o PHP:

"<?php

// Localização: Joinville - SC
$latitude = -26.3044;
$longitude = -48.8487;

// Endereço da API
$url = "https://api.open-meteo.com/v1/forecast?latitude=$latitude&longitude=$longitude&current=temperature_2m,weather_code,is_day&timezone=auto";

// Consulta à API
$resposta = file_get_contents($url);

// Transforma o JSON em dados PHP
$dados = json_decode($resposta, true);

// Verifica se a consulta funcionou
if ($dados && isset($dados['current'])) {

    $temperatura = $dados['current']['temperature_2m'];
    $codigo = $dados['current']['weather_code'];
    $horario = $dados['current']['time'];

    // Traduz as condições climáticas
    if ($codigo == 0) {
        $condicao = "Céu limpo";
    } elseif ($codigo <= 3) {
        $condicao = "Parcialmente nublado";
    } elseif ($codigo <= 48) {
        $condicao = "Neblina";
    } elseif ($codigo <= 67) {
        $condicao = "Chuva";
    } elseif ($codigo <= 77) {
        $condicao = "Neve";
    } elseif ($codigo <= 82) {
        $condicao = "Pancadas de chuva";
    } elseif ($codigo <= 86) {
        $condicao = "Pancadas de neve";
    } else {
        $condicao = "Trovoadas";
    }

} else {
    $erro = "Não foi possível consultar o clima.";
}

?>"



Outras ajudas da IA:

Além da integração com a API e da criação do código PHP, o ChatGPT também auxiliou na parte visual do sistema, ajudando com o CSS, na organização dos elementos da tela inicial, nas cores, no espaçamento e na apresentação das informações meteorológicas.

Resultado: A utilização da IA ajudou a compreender como funciona a integração de uma API externa com PHP, facilitando a implementação dos dados meteorológicos e a personalização visual da tela inicial do sistema.