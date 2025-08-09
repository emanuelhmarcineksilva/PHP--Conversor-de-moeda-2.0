<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Resultado Conversão</title>
</head>
<body>
    <section>
        <?php 
        $_num = $_GET['numero'];

        // Cotação vinda do branco central
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


        echo("<h4>Você tem R\$ " . $_num . " Reais");

        // Esse number_format permite vc escolher o numero de casas decimais, aqui foi duas, a divisão para as casas decimais que foi escolhido a virgula ',' e o que vai separar milhar aqui foi o espaço ' ' o primeiro termo é o número.
        echo("<p>Você tem <b> us\$" . number_format($cotação, 2, ',', ' ') . "</b> Dolares</p>");

        // Formatação de moedas com internacionalização

        // Aqui mostramos o idioma do site e o tipo de numero que vai formatar, deve ser escrito exatamente assim

        // Não estava fuincionando no servidor local xampp por que a biblioteca que é usada estava desativada

        // A biblioteca é a intl
        $_teste = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

        // Primeiro deve ser colocado no numfmt... o Padrão do computador, o valor que esta no padrão e a sigra internacional dela (já é acresentado o R$)
        echo("<p>Seus <b> " . numfmt_format_currency($_teste, $_num, "BRL") . "</b> Equivalem a <b> " . numfmt_format_currency($_teste, $cotação, "USD") . "</b> Dolares</p>");
        ?>
    </section>
    <a href="javascript:history.go(-1)">Voltar</a>
</body>

</html>
