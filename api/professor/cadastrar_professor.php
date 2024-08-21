<?php
function alterar_professor(){
    $codigoProfessorAlterar = $_POST["codigo"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    
    $dadosProfessores = @file_get_contents("professores.json");
    $arDadosProfessores = json_decode($dadosProfessores, true);

    $arDadosProfessoresNovo = array();
    foreach($arDadosProfessores as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoProfessorAlterar == $codigoAtual){
            $aDados["nome"] = $nome;
            $aDados["email"] = $email;
        }

        $arDadosProfessoresNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("professores.json", json_encode($arDadosProfessoresNovo));
}

function excluir_professor(){
    $codigoProfessorExcluir = $_GET["codigo"];

    $dadosProfessores = @file_get_contents("professores.json");
    $arDadosProfessores = json_decode($arDadosProfessores, true);

    $arDadosProfessoresNovo = array();
    foreach($arDadosProfessores as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoProfessorExcluir == $codigoAtual){
            // ignora e vai para o proximo registro
            continue;
        }

        $arDadosProfessoresNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("professores.json", json_encode($arDadosProfessoresNovo));
}

function incluir_professor(){
    $arDadosProfessores = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dadosProfessores = @file_get_contents("professores.json");
    if($arDadosProfessores){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosProfessores = json_decode($DadosProfessores, true);
    }

    // Armazenar os dados do professor atual, num array associativo

    $aDadosProfessorAtual = array();
    $aDadosProfessorAtual["codigo"] = getProximoCodigo($arDadosProfessores);
    $aDadosProfessorAtual["nome"] = $_POST["nome"];
    $aDadosProfessorAtual["email"] = $_POST["email"];
    $aDadosProfessorAtual["senha"] = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    // Pega os dados atuais do professor e armazena no array que foi lido
    $arDadosProfessores[] = $aDadosProfessorAtual;

    // Gravar os dados no arquivo
    file_put_contents("professores.json", json_encode($arDadosProfessores));
}

function getProximoCodigo($arDadosProfessores){
    $ultimoCodigo = 0;
    foreach($arDadosProfessores as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoAtual > $ultimoCodigo){
            $ultimoCodigo = $codigoAtual;
        }      
    }

    return $ultimoCodigo + 1;
}

// PROCESSAMENTO DA PAGINA
// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;
// echo "<pre>" . print_r($_GET, true) . "</pre>";return true;

// Verificar se esta setado o $_POST
if(isset($_POST["ACAO"])){
    $acao = $_POST["ACAO"];
    if($acao == "INCLUIR"){
        incluir_professor();

        // Redireciona para a pagina de consulta do professor
        header('Location: consulta_professor.php');
    } else if($acao == "ALTERAR"){        
        alterar_professor();

        // Redireciona para a pagina de consulta do professor
        header('Location: consulta_professor.php');
    }
} else if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "EXCLUIR"){
        excluir_professor();
        
        // Redireciona para a pagina de consulta do professor
        header('Location: consulta_professor.php');
    } else if($acao == "ALTERAR"){
        $codigoProfessorAlterar = $_GET["codigo"];

        // Redireciona para a pagina do professor
        header('Location: professor.php?ACAO=ALTERAR&codigo=' . $codigoProfessorAlterar);
    }
} else {
    // Redireciona para a pagina de consulta do professor
    header('Location: consulta_professor.php');
}
