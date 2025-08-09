<pre>
    <?php // API banco do brasil - Dollar
        /* Primeiro devemos acessar os dados abertos que tem no banco para conseguirmos a API
            Para isso devemos mudar o URL de 'www.bcb.gov.br' para 'dadosabertos.bcb.gov.br'
            O URL que vamos colar é do estilo json
        */

        // date() é para pegar a data atual. strtotime é uma string para tempo que eu retrocedi 7 dias para o início
        $início = date("m-d-Y", strtotime("-7 days"));
        $fim = date("m-d-Y");

        // Estamos usando aspas simples porque tem sifrão dentro do link, e se for dupla o PHP vai procurar variaveis com os sifrões que não existem. Devemos colocar contra barra \ na frente das aspas simples para ele indentificar como aspas simples que não estão fexando o todo.
        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $início . '\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

        // json_decode() trata (manipula) dados em json, o file_get_contents() é para pegar a url, o true é para 
        $dados = json_decode(file_get_contents($url), true); // esse true coloca dentro de um array e o false deixa dentro de um object

        // var_dump() mostra a estrutura de uma url
        // var_dump($dados);

        $cotação = $dados["value"][0]["cotacaoCompra"];

        echo "cotação foi " . $cotação;
    ?>
</pre>