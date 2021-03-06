<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="TreasureHunt, um Jogo de Caça ao Tesouro de Segurança Computacional">
	<meta name="keywords" content="Treasure Hunt, Segurança Computacional">
	<meta name="author" content="Ricardo de la Rocha Ladeira">
	<title>TreasureHunt{Security} -- You'll never find me!</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" type="image/png" href="img/favicon.png">
	<script src="js/script.js"></script>	
</head>
<body>
<div id="container">
    <nav>
        <ul>
            <li><a>Início</a></li>
            <li><a id="regras">Como Jogar?</a>
            <li><a id="contato">Contato</a></li>
        </ul>
    </nav>
    <div id="main">
	  	<h1>Treasure<span id="bracket">Hunt</span>{<span>Security</span>}</h1>
		<p>Um jogo para testar suas habilidades em Segurança Computacional. <span id="smile">:)</span></p>
		<form action="acesso.php" method="POST">
			<label>Autentique-se:</label><br>
	    	<input type="text" name="usuario" placeholder="Informe seu ID" required autofocus><br>
	        <input type="password" name="senha" placeholder="Informe sua senha" required><br>
	        <button type="submit" name="enviar"><span id="whitebracket">{</span>Entrar<span id="whitebracket">}</span></button>
	    </form>
	</div>
    <div id="modal-regras">
    	<h1>Como <span class="destaque">Jogar</span>{<span>?</span>}</h1>
    	<div id="modal-regras-content">
	    	<p>Na tela de início, insira seu ID e sua senha e clique em <button><span id="whitebracket">{</span>Entrar<span id="whitebracket">}</span></button>.</p>
	    	<p>Faça o download do arquivo zip disponível e descompacte-o. Este arquivo contém alguns diretórios representados por números inteiros. Cada diretório contém pelo menos um arquivo.</p>
	    	<p>Seu objetivo é descobrir a palavra secreta escondida em cada um dos diretórios.</p>
	    	<p>Cada palavra descoberta é um desafio resolvido! Você só precisa realizar a submissão no sistema, informando o ID do problema (número do diretório) e a palavra encontrada. O sistema informará se a palavra está (in)correta.</p>
	    	<p>As palavras secretas possuem o formato <strong>TreasureHunt{texto-aleatorio}</strong>. Na submissão, digite toda palavra! Exemplo: TreasureHunt{dhi2uh39}.</p>
    	</div>
    </div>
    <div id="modal-contato">
    	<h1>Cont<span class="destaque">@</span>te-<span class="destaque">nos</span>{<span>!</span>}</h1>
    	<address>
    	<span class="nome">Ricardo de la Rocha <span class="destaque">Ladeira</span></span> <span class="sinal-menor"></span>ricardo.delarocha<span class="at"></span>gmail.com<span class="sinal-maior"></span><br>
    	<span class="nome">Rafael Rodrigues <span class="destaque">Obelheiro</span></span> <span class="sinal-menor"></span>rafael.obelheiro<span class="at"></span>udesc.br<span class="sinal-maior"></span>
    	</address>
    </div>
</div>
</body>
</html>