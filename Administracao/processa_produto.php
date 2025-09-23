<?php
session_start();

// 1. VERIFICAR SE O USUÁRIO É ADMINISTRADOR
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    // Se não for, redireciona para o login com uma mensagem de erro
    $_SESSION['mensagem'] = "Acesso negado. Faça login como administrador.";
    $_SESSION['tipo_mensagem'] = "danger";
    header("Location: ../login/login.php");
    exit();
}

// 2. CONECTAR AO BANCO DE DADOS
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "bepet";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
} catch (mysqli_sql_exception $e) {
    // Em caso de erro de conexão, define uma mensagem de erro e redireciona
    $_SESSION['mensagem'] = "Erro de comunicação com o servidor. Tente novamente mais tarde.";
    $_SESSION['tipo_mensagem'] = "danger";
    header("Location: listar_produtos.php"); // Redireciona para a lista em caso de erro de DB
    exit();
}

// --- INÍCIO DO PROCESSAMENTO DAS AÇÕES ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $acao = $_POST['acao'] ?? '';

    if ($acao === 'cadastrar') {
        // 4. PEGAR E VALIDAR OS DADOS DO FORMULÁRIO
        $nome = trim($_POST['nome_produto'] ?? '');
        $descricao = trim($_POST['descricao_produto'] ?? '');
        $preco = filter_var($_POST['preco_produto'] ?? '', FILTER_VALIDATE_FLOAT);
        $imagem = $_FILES['imagem_produto'];

        // Validação básica
        if (empty($nome) || $preco === false || !isset($imagem) || $imagem['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['mensagem'] = "Erro: Todos os campos obrigatórios devem ser preenchidos corretamente.";
            $_SESSION['tipo_mensagem'] = "danger";
            header("Location: gerenciar_produto.php");
            exit();
        }

        // 5. PROCESSAR O UPLOAD DA IMAGEM
        $caminho_upload = '../uploads/produtos/';
        if (!is_dir($caminho_upload)) {
            mkdir($caminho_upload, 0777, true);
        }

        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nome_arquivo_unico = uniqid('produto_', true) . '.' . $extensao;
        $caminho_completo = $caminho_upload . $nome_arquivo_unico;

        $tipos_permitidos = ['jpg', 'jpeg', 'png', 'webp'];
        $tamanho_maximo = 2 * 1024 * 1024; // 2MB

        if (!in_array(strtolower($extensao), $tipos_permitidos)) {
            $_SESSION['mensagem'] = "Erro: Tipo de arquivo de imagem não permitido. Use apenas JPG, PNG ou WEBP.";
            $_SESSION['tipo_mensagem'] = "danger";
            header("Location: gerenciar_produto.php");
            exit();
        }

        if ($imagem['size'] > $tamanho_maximo) {
            $_SESSION['mensagem'] = "Erro: O arquivo de imagem é muito grande. O tamanho máximo é 2MB.";
            $_SESSION['tipo_mensagem'] = "danger";
            header("Location: gerenciar_produto.php");
            exit();
        }

        if (move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
            $caminho_db = 'uploads/produtos/' . $nome_arquivo_unico;

            $sql = "INSERT INTO produtos (nome, descricao, preco, caminho_imagem) VALUES (?, ?, ?, ?)";
            try {
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("ssds", $nome, $descricao, $preco, $caminho_db);
                
                if ($stmt->execute()) {
                    $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
                    $_SESSION['tipo_mensagem'] = "success";
                } else {
                    throw new Exception("Não foi possível executar a inserção no banco de dados.");
                }
                $stmt->close();
            } catch (Exception $e) {
                if (file_exists($caminho_completo)) {
                    unlink($caminho_completo);
                }
                $_SESSION['mensagem'] = "Erro ao cadastrar o produto: " . $e->getMessage();
                $_SESSION['tipo_mensagem'] = "danger";
            }
        } else {
            $_SESSION['mensagem'] = "Erro ao fazer o upload da imagem.";
            $_SESSION['tipo_mensagem'] = "danger";
        }

        header("Location: listar_produtos.php");
        exit();

    } elseif ($acao === 'editar') {
        // 9. PEGAR E VALIDAR OS DADOS DO FORMULÁRIO DE EDIÇÃO
        $id = filter_var($_POST['id_produto'], FILTER_VALIDATE_INT);
        $nome = trim($_POST['nome_produto'] ?? '');
        $descricao = trim($_POST['descricao_produto'] ?? '');
        $preco = filter_var($_POST['preco_produto'], FILTER_VALIDATE_FLOAT);
        $imagem_atual = $_POST['imagem_atual'];
        $nova_imagem = $_FILES['imagem_produto'];

        if ($id === false || empty($nome) || $preco === false) {
            $_SESSION['mensagem'] = "Erro: Dados inválidos para edição.";
            $_SESSION['tipo_mensagem'] = "danger";
            header("Location: listar_produtos.php");
            exit();
        }

        $caminho_db = $imagem_atual; // Mantém a imagem atual por padrão

        // 10. PROCESSAR UPLOAD APENAS SE UMA NOVA IMAGEM FOI ENVIADA
        if (isset($nova_imagem) && $nova_imagem['error'] === UPLOAD_ERR_OK) {
            $caminho_upload = '../uploads/produtos/';
            $extensao = pathinfo($nova_imagem['name'], PATHINFO_EXTENSION);
            $nome_arquivo_unico = uniqid('produto_', true) . '.' . $extensao;
            $caminho_completo = $caminho_upload . $nome_arquivo_unico;

            // Validações (pode criar uma função para reutilizar)
            $tipos_permitidos = ['jpg', 'jpeg', 'png', 'webp'];
            $tamanho_maximo = 2 * 1024 * 1024; // 2MB

            if (!in_array(strtolower($extensao), $tipos_permitidos) || $nova_imagem['size'] > $tamanho_maximo) {
                $_SESSION['mensagem'] = "Erro: Nova imagem inválida (tipo ou tamanho).";
                $_SESSION['tipo_mensagem'] = "danger";
                header("Location: gerenciar_produto.php?id=$id");
                exit();
            }

            if (move_uploaded_file($nova_imagem['tmp_name'], $caminho_completo)) {
                // Apaga a imagem antiga se o upload da nova deu certo e se a antiga existir
                $caminho_antigo_fisico = '../' . $imagem_atual;
                if (!empty($imagem_atual) && file_exists($caminho_antigo_fisico)) {
                    unlink($caminho_antigo_fisico);
                }
                $caminho_db = 'uploads/produtos/' . $nome_arquivo_unico; // Atualiza o caminho no banco
            } else {
                $_SESSION['mensagem'] = "Erro ao fazer upload da nova imagem.";
                $_SESSION['tipo_mensagem'] = "danger";
                header("Location: gerenciar_produto.php?id=$id");
                exit();
            }
        }

        // 11. PREPARAR E EXECUTAR A QUERY SQL PARA ATUALIZAR O PRODUTO
        $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, caminho_imagem = ? WHERE id = ?";
        
        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $caminho_db, $id);
            
            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Produto atualizado com sucesso!";
                $_SESSION['tipo_mensagem'] = "success";
            } else {
                throw new Exception("Não foi possível executar a atualização no banco de dados.");
            }
            $stmt->close();

        } catch (Exception $e) {
            $_SESSION['mensagem'] = "Erro ao atualizar o produto: " . $e->getMessage();
            $_SESSION['tipo_mensagem'] = "danger";
        }

        header("Location: listar_produtos.php");
        exit();
    }
} 
// 12. VERIFICAR SE A AÇÃO É 'EXCLUIR' E O MÉTODO É GET
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['acao']) && $_GET['acao'] === 'excluir') {

    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $_SESSION['mensagem'] = "ID do produto inválido para exclusão.";
        $_SESSION['tipo_mensagem'] = "danger";
        header("Location: listar_produtos.php");
        exit();
    }
    $id_produto = (int)$_GET['id'];

    try {
        // BUSCAR O CAMINHO DA IMAGEM ANTES DE DELETAR O REGISTRO
        $sql_select = "SELECT caminho_imagem FROM produtos WHERE id = ?";
        $stmt_select = $conexao->prepare($sql_select);
        $stmt_select->bind_param("i", $id_produto);
        $stmt_select->execute();
        $resultado = $stmt_select->get_result();
        $produto = $resultado->fetch_assoc();
        $stmt_select->close();

        if ($produto) {
            $sql_delete = "DELETE FROM produtos WHERE id = ?";
            $stmt_delete = $conexao->prepare($sql_delete);
            $stmt_delete->bind_param("i", $id_produto);

            if ($stmt_delete->execute()) {
                // SE A EXCLUSÃO NO BANCO FOR BEM-SUCEDIDA, APAGAR O ARQUIVO DA IMAGEM
                $caminho_imagem_fisico = '../' . $produto['caminho_imagem'];
                if (!empty($produto['caminho_imagem']) && file_exists($caminho_imagem_fisico)) {
                    unlink($caminho_imagem_fisico);
                }
                $_SESSION['mensagem'] = "Produto excluído com sucesso!";
                $_SESSION['tipo_mensagem'] = "success";
            } else {
                throw new Exception("Não foi possível excluir o produto do banco de dados.");
            }
            $stmt_delete->close();
        } else {
            $_SESSION['mensagem'] = "Produto não encontrado.";
            $_SESSION['tipo_mensagem'] = "danger";
        }
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Ocorreu um erro ao tentar excluir o produto.";
        $_SESSION['tipo_mensagem'] = "danger";
    }
}

// Se o acesso for indevido, redireciona para o painel
$conexao->close();
header("Location: listar_produtos.php");
exit();
?>