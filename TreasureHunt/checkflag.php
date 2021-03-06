<?php
// Codifica os caracteres
header("Content-type: text/html; charset=utf-8");
require_once 'conexao.php';

ob_start();
@session_start();

if (!isset($_SESSION['usuario']) == true) {
	unset($_SESSION['usuario']);
	header('location:index.php');
}

$problema = filter_input(INPUT_POST, 'problema');
$flagPura = filter_input(INPUT_POST, 'flag');
$flag = hash("sha256", $flagPura);
$usuario = $_SESSION['usuario'];

// Insere idUser, idResposta e flagPura na tabela submissão
$sql = "INSERT INTO Submissao VALUES ($usuario, $problema, '$flagPura', date('Y-m-d H:i:s'))";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
$stmt->bindParam(':problema', $problema, PDO::PARAM_STR);
$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
$stmt->execute();

// Verifica se o usuário já acertou a questão
$sql = "SELECT * FROM Resposta WHERE idUser='$usuario' AND idProblema='$problema' AND acertou=true";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
$stmt->bindParam(':problema', $problema, PDO::PARAM_STR);
$stmt->execute();

// Se retornar resultado, usuário já havia respondido corretamente
if ($stmt->rowCount() > 0) {
?>
<script type="text/javascript">
	alert('Você já acertou a questão '+ <?php echo $problema; ?> + '!');
</script>
<?php
} else {

	// Se acerta a resposta e depois segue informando,
	// informa se está certa ou errada, mas não incrementa
	// as tentativas.

	// Poderia informar quando a resposta correta já foi submetida
	// e o usuário segue submetendo para o mesmo problema
	$sql = "SELECT * FROM Resposta WHERE idUser='$usuario' AND idProblema='$problema' AND resposta='$flag'";
	$stmt = $conexao->prepare($sql);
	$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
	$stmt->bindParam(':problema', $problema, PDO::PARAM_STR);
	$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
	$stmt->execute();

	// Se retornar resultado, resposta correta
	if ($stmt->rowCount() > 0) {
		$acertou = true;
		atualiza($acertou, $usuario, $problema);

		$stmt = $conexao->prepare("SELECT COUNT(*) AS Total FROM 	Resposta WHERE idUser=$usuario");
		$stmt->execute();
		$linhaTotal = $stmt->fetch(PDO::FETCH_OBJ);

		$stmt = $conexao->prepare("SELECT COUNT(*) AS Acertos FROM Resposta WHERE idUser=$usuario and acertou=1");
		$stmt->execute();
		$linhaAcertos = $stmt->fetch(PDO::FETCH_OBJ);
?>
<script type="text/javascript">
	alert('Acertou! '+ <?php echo $linhaAcertos->Acertos; ?> + '/' + <?php echo $linhaTotal->Total; ?>);
</script>
<?php
	} else {
		$stmt = $conexao->prepare("SELECT MAX(idProblema) AS Max FROM Resposta");
		$stmt->execute();
		$linhaTotal = $stmt->fetch(PDO::FETCH_OBJ);
		if ($problema < 1 or $problema > $linhaTotal->Max) {
?>
<script type="text/javascript">
	alert('Problema com ID inválido!');
</script>
<?php
		} else {
		$acertou = false;
		atualiza($acertou, $usuario, $problema);

		$tamanho = strlen($flagPura);
    	$verificaPadrao = (substr($flagPura, 0, 13) === 'TreasureHunt{') && (substr($flagPura, $tamanho - 1, $tamanho) === '}');
    	$mensagem = "Errou!";
    	if ($verificaPadrao != 1) {
	    	$mensagem .= " Considere submeter a flag no seguinte formato: TreasureHunt{texto-aleatorio}";
    	}
?>
<script type="text/javascript">
	alert('<?php echo $mensagem; ?>');
</script>
<?php
		}
	}
}

/* Função que atualiza a tabela de respostas
   quando o usuário submeter uma flag */
function atualiza($resposta, $usuario, $problema) {
	include 'conexao.php';

	$param="";

	if ($resposta == true) {
		$hora = date('Y-m-d H:i:s');
		$param = "acertou=1, hora='$hora',";
		//$param = "acertou=1,";
	}

	$sql = "UPDATE Resposta SET $param tentativas=tentativas+1 WHERE idUser='$usuario' AND idProblema='$problema' AND acertou=0";
	$stmt = $conexao->prepare($sql);
	$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
	$stmt->bindParam(':problema', $problema, PDO::PARAM_STR);
	$stmt->execute();
}
?>
<script type="text/javascript">
	window.setTimeout("location.href='home.php';");
</script>