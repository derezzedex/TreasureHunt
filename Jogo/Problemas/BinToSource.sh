# Define o tamanho do texto aleatório
TAM=20

# Define o diretório de destino
DESTINO=$2

# Define o tamanho da flag
TAM_FLAG=8

# Texto inicial do arquivo, que servirá de distração, deve vir com o conteúdo "TEXTO"
TEXTO_INICIAL="TEXTO"
TEXTO_INICIAL_ORIGINAL="TEXTO"

# Texto inicial da Flag
case $3 in
	1) FLAG="FLAG"
	   FLAG_ORIGINAL="FLAG" ;;
	2) FLAG="FLAG = \"\""
	   FLAG_ORIGINAL="FLAG = \"\"" ;;
esac

# Recebe o diretório do arquivo. Se não for indicado, pega o diretório atual.
if [ $# -eq 0 ]
then DIRETORIO=$pwd
else DIRETORIO="$1"
fi

# Sorteia um arquivo em $DIRETORIO
FONTE=$(ls "$DIRETORIO" | shuf -n 1)

# Define um texto aleatório de tamanho TAM
TEXTO=$(cat /dev/urandom | tr -cd 'A-Za-z0-9' | head -c $TAM)

# Substitui o texto inicial por um texto aleatório
sed -i -e "s~$TEXTO_INICIAL~$TEXTO~g" "$DIRETORIO$FONTE"
	
# Recebe o texto atual para substituí-lo na próxima instância gerada
TEXTO_INICIAL=$TEXTO

# Define uma palavra aleatória de tamanho TAM_FLAG que será a flag
FLAG_GERADA=$(cat /dev/urandom | tr -cd 'A-Za-z0-9' | head -c $TAM_FLAG)

# Gera a flag
case $# in 
	4) FLAG_GERADA="FLAG = \"$(cat $4)\"" ;;
	*) FLAG_GERADA="FLAG = \"TreasureHunt{$FLAG_GERADA}\"" ;;
esac

# Atribui um valor à variável FLAG (que será a $FLAG)
sed -i -e "s~$FLAG~$FLAG_GERADA~g" "$DIRETORIO$FONTE"

# Recebe a flag atual para substituí-la na próxima instância gerada
FLAG=$FLAG_GERADA

# Compila o código com texto e flag gerados, salva o arquivo compilado
# no diretório destino e remove o arquivo compilado do diretório base
case $3 in
	1) javac $DIRETORIO$FONTE
	   cp -T $DIRETORIO${FONTE%.*}.class $DESTINO/${FONTE%.*}.class
	   [ -e $DIRETORIO${FONTE%.*}.class ] && rm $DIRETORIO${FONTE%.*}.class ;;
	2) python2 -m compileall -q $DIRETORIO$FONTE
	   sleep 1
	   cp -T $DIRETORIO${FONTE%.*}.pyc $DESTINO/${FONTE%.*}.pyc
	   [ -e $DIRETORIO${FONTE%.*}.pyc ] && rm $DIRETORIO${FONTE%.*}.pyc ;;
esac

# Recoloca os valores originais no texto inicial e na flag do código-fonte
sed -i -e "s~$TEXTO_INICIAL~$TEXTO_INICIAL_ORIGINAL~g" "$DIRETORIO$FONTE"
sed -i -e "s~$FLAG~$FLAG_ORIGINAL~g" "$DIRETORIO$FONTE"