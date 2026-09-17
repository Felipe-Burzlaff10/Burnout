<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro com CEP</title>

<style>
body{
    font-family: Arial;
    width: 450px;
    margin: 30px auto;
}

label{
    display:block;
    margin-top:10px;
}

input{
    width:100%;
    padding:8px;
    box-sizing:border-box;
}
</style>

</head>
<body>

<h2>Cadastro de Endereço</h2>

<form action="salvar.php" method="post">

    <label>CEP</label>
    <input
        type="text"
        name="cep"
        id="cep"
        maxlength="9"
        placeholder="00000-000"
        required>

    <label>Rua</label>
    <input type="text" name="rua" id="rua">

    <label>Bairro</label>
    <input type="text" name="bairro" id="bairro">

    <label>Cidade</label>
    <input type="text" name="cidade" id="cidade">

    <label>Estado</label>
    <input type="text" name="estado" id="estado">

    <br><br>

    <button type="submit">Salvar</button>

</form>

<script>

const cep = document.getElementById("cep");

cep.addEventListener("blur", buscarCEP);

async function buscarCEP(){

    let valorCEP = cep.value.replace(/\D/g,'');

    if(valorCEP.length != 8){
        alert("CEP inválido!");
        return;
    }

    try{

        const resposta = await fetch(`https://viacep.com.br/ws/${valorCEP}/json/`);

        const dados = await resposta.json();

        if(dados.erro){
            alert("CEP não encontrado.");
            return;
        }

        document.getElementById("rua").value = dados.logradouro;
        document.getElementById("bairro").value = dados.bairro;
        document.getElementById("cidade").value = dados.localidade;
        document.getElementById("estado").value = dados.uf;

    }catch(erro){
        alert("Erro ao consultar a API.");
    }

}

</script>

</body>
</html>