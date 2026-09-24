function buscarEndereco()
        {

            let cep = document.getElementById('cep').value;

            if(cep.length != 8)
            {
                alert("CEP inválido!");
                return;
            }

            let url = 'https://viacep.com.br/ws/' + cep + '/json/';



            fetch(url)
                .then(resposta => {return resposta.json()})
                .then(dados => {
                                    if (dados.erro)
                                    {
                                        alert("CEP não encontrado.");
                                        return;
                                    }

                                    document.getElementById("uf").value = dados.uf;
                                    document.getElementById("cidade").value = dados.localidade;
                                    document.getElementById("bairro").value = dados.bairro;
                                    document.getElementById("rua").value = dados.logradouro;
                
                                })
        }