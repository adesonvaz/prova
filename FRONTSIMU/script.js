const form = document.querySelector('#Agendar_Form')
const marca = document.querySelector('#marca')
const modelo = document.querySelector('#modelo')
const anofabricacao = document.querySelector('#anofabricacao')
const preco = document.querySelector('#preco')
const tableBody = document.querySelector('#carro_tabela tbody')

const URL = 'http://localhost:8080/consulta.php'

function carregarcarros() {
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        mode: 'cors'
    })
        .then(response => response.json())
        .then(carros => {
            tableBody.innerHTML = ''

            carros.forEach(carros => {
                const tr = document.createElement('tr')
                tr.innerHTML = `
            <td>${carros.marca}</td>
            <td>${carros.modelo}</td>
            <td>${carros.anofabricacao}</td>
            <td>${carros.preco}</td>
            <td>
            <button anofabricacao-idcarro="${carros.idcarro}" onclick="atualizarcarros(${carros.idcarro})">Editar</button>
            <button onclick="excluircarros(${carros.idcarro})">Excluir</button>
            </td>
            `
                tableBody.appendChild(tr)
            })
        })
}

function adicionarcarros(e) {

    e.preventDefault()

    const marcaValor = marca.value
    const modeloValor = modelo.value
    const anofabricacaoValor = anofabricacao.value
    const precoValor = preco.value

    fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `marca=${encodeURIComponent(marcaValor)}&modelo=${encodeURIComponent(modeloValor)}&anofabricacao=${encodeURIComponent(anofabricacaoValor)}&preco=${encodeURIComponent(precoValor)}`
    })
        .then(response => {
            if (response.ok) {
                carregarcarros()
                marcaValor.value = ''
                modeloValor.value = ''
                anofabricacaoValor.value = ''
                precoValor.value = ''
            } else {
                console.error('Erro ao add carros')
                alert('Erro ao add carros')
            }
        })
}

//excluir carros

function excluircarros(idcarro){
    if(confirm('Deseja excluir esse carros?')){
        fetch(`${URL}?id=${idcarro}`, {
            method:'DELETE'
        })
            .then(response => {
                if (response.ok){
                    carregarcarros()
                } else {
                    console.error('Erro ao excluir carros')
                    alert('Erro ao excluir carros')
                }
            })
    }
}


function atualizarcarros(idcarro){
    const marca = prompt('Digite o novo marca: ')
    const modelo = prompt('Digite o novo modelo: ')
    const anofabricacao = prompt('Digite a nova anofabricacao: ')
    const preco = prompt('Digite o novo preco: ')

    if(marca && modelo && anofabricacao && preco){
        fetch(`${URL}?idcarro=${idcarro}`,{
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `marca=${encodeURIComponent(marca)}&modelo=${encodeURIComponent(modelo)}&anofabricacao=${encodeURIComponent(anofabricacao)}&preco=${encodeURIComponent(preco)}`
        })
            .then(response => {
                if(response.ok){
                    carregarcarros()
                }else{
                    console.error('Erro ao auterar carros')
                }
            })
    }

}
form.addEventListener('onclick', excluircarros)
excluircarros()

form.addEventListener('onclick', atualizarcarros)
atualizarcarros()

form.addEventListener('submit', adicionarcarros)
carregarcarros()
