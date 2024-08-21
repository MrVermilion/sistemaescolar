<?php

function getAcaoExcluirProfessor($codigoProfessor){
    $sHTML = "<a id='acaoExcluir' href='http://localhost/sistemaescolar/api/professor/cadastrar_professor.php?ACAO=EXCLUIR&codigo=" . $codigoProfessor . "'>Excluir</a>";

    return $sHTML;
}

function getAcaoAlterarProfessor($codigoProfessor){
    $sHTML = "<a id='acaoAlterar' href='http://localhost/sistemaescolar/api/professor/cadastrar_professor.php?ACAO=ALTERAR&codigo=" . $codigoProfessor . "'>Alterar</a>";

    return $sHTML;
}

require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE PROFESSOR</h3>';

// JAVASCRIPT
$htmlTabelaProfessores = "
    <script>
        function abreCadastroInclusao(){
            // alert('Abrindo cadastro de inclusao de Professor...');
            window.location.href = 'professor.php';
        }
    </script>
";

$htmlTabelaProfessores .= "<button class='button' type='button' onclick='abreCadastroInclusao()'>Incluir - JAVASCRIPT<button>";
$htmlTabelaProfessores .= "<button class='button' type='button' onclick='abreCadastroInclusao()'><a href='professor.php' target='_blank'>Incluir - PHP</a><button>";


$htmlTabelaProfessores .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaProfessores .= "<head>";

// TITULOS DA TABLE
$htmlTabelaProfessores .= "<tr>";
$htmlTabelaProfessores .= "  <th>Código</th>";
$htmlTabelaProfessores .= "  <th>Nome</th>";
$htmlTabelaProfessores .= "  <th>E-mail</th>";
$htmlTabelaProfessores .= "  <th>Senha</th>";
$htmlTabelaProfessores .= "  <th colspan='2'>Ações</th>";
$htmlTabelaProfessores .= "</tr>";

$htmlTabelaProfessores .= "</head>";

// CORPO DA TABELA
$htmlTabelaProfessores .= "<tbody>";

// LINHAS DA TABELA
// LER OS DADOS DO ARQUIVO
$arDadosProfessores = array();
// Primeiro, verifica se existe dados no arquivo json
// @ na frente do metodo, remove o warning
$dadosProfessores = @file_get_contents("Professores.json");
if($dadosProfessores){
    // transforma os dados lidos em ARRAY, que estavam em JSON
    $arDadosProfessores = json_decode($dadosProfessores, true);
}

foreach($arDadosProfessores as $aDados){
    // echo '<br>lendo dados do professor: ' . json_encode($aDados);

    // ABRIR UMA NOVA LINHA
    $htmlTabelaProfessores .= "<tr>";
    
    // COLUNAS DENTRO DA LINHA
    // ALINHAMENTO
    // TEXTO, ALINHADO A ESQUERDA
    // VALORES, ALINHADOS A DIREITA
    $htmlTabelaProfessores .= "<td align='center'>" . $aDados["codigo"] . "</td>";
    $htmlTabelaProfessores .= "<td>" . $aDados["nome"] . "</td>";
    $htmlTabelaProfessores .= "<td>" . $aDados["email"] . "</td>";
    $htmlTabelaProfessores .= "<td>" . $aDados["senha"] . "</td>";

    // Adiciona a ação de excluir Professor
    $codigoProfessor = $aDados["codigo"];

    $htmlTabelaProfessores .= '<td>';
    $htmlTabelaProfessores .= getAcaoExcluirProfessor($codigoProfessor);
    $htmlTabelaProfessores .= '</td>';

    $htmlTabelaProfessores .= '<td>';
    $htmlTabelaProfessores .= getAcaoAlterarProfessor($codigoProfessor);
    $htmlTabelaProfessores .= '</td>';


    // FECHAR A LINHA ATUAL
    $htmlTabelaProfessores .= "</tr>";
}

$htmlTabelaProfessores .= "</tbody>";

$htmlTabelaProfessores .= "</table>";

echo $htmlTabelaProfessores;

require_once("../core/footer.php");
