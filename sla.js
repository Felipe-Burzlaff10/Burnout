function endereco_decode(endereco)
{
    const regex = /^(?<logradouro>.*?),\s*Nº:\s*(?<numero>\d+),\s*(?<bairro>.*?)\s*-\s*(?<cidade>.*?)\/(?<uf>[A-Z]{2})\s*CEP:\s*(?<cep>\d{8})/;

    
    const resultado = endereco.match(regex);
    
    if (resultado)
    {   
        const { logradouro, numero, bairro, cidade, uf, cep } = resultado.groups;
    
        document.getElementById("rua").value = logradouro;
        document.getElementById("num").value = numero;
        document.getElementById("bairro").value = bairro;
        document.getElementById("cidade").value = cidade;
        document.getElementById("uf").value = uf;
        document.getElementById("cep").value = cep;
    }
}

function preencher_input(email, endereco)
{
    endereco_decode(endereco);
    document.getElementById("email").value = email;
}