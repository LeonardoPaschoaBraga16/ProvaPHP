<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste</title>
</head>
<body>
    <h1>Consultar Cep</h1>

    <input type="text" id="cep" placeholder="Digite seu CEP (ex: 12345678)">
    <button onclick="consultarCEP()">Buscar informações</button>

    <div class="resultado" id="resultado">

    </div>

    <script>
        function consultarCEP() {
            const cep = document.getElementById('cep').value;
            const resultado = document.getElementById('resultado');

            // Limpa resultado anterior
            resultado.innerHTML = 'Carregando...';

            fetch(`api.php?cep=${cep}`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        resultado.innerHTML = `<p style="color:red;">Erro: ${data.erro}</p>`;
                    } else {
                        resultado.innerHTML = `
                            <p><strong>CEP:</strong> ${data.cep}</p>
                            <p><strong>Logradouro:</strong> ${data.logradouro}</p>
                            <p><strong>Complemento:</strong> ${data.complemento}</p>
                            <p><strong>Unidade:</strong> ${data.unidade}</p>
                            <p><strong>Bairro:</strong> ${data.bairro}</p>
                            <p><strong>Cidade:</strong> ${data.localidade}</p>
                            <p><strong>Estado:</strong> ${data.uf}</p>
                            <p><strong>Região:</strong> ${data.regiao}</p>
                            <p><strong>Ibge:</strong> ${data.ibge}</p>
                            <p><strong>Gia:</strong> ${data.gia}</p>
                            <p><strong>DDD:</strong> ${data.ddd}</p>
                            <p><strong>Siafi:</strong> ${data.siafi}</p>
                        `;
                    }
                })
                .catch(error => {
                    resultado.innerHTML = `<p style="color:red;">Erro ao buscar CEP.</p>`;
                    console.error('Erro:', error);
                });
        }
    </script>
</body>
</html>
