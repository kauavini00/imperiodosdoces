interface Produto {
    id_produto: number;
    nm_produto: string;
    ds_produto: string;
    vl_preco: string;
    img_produto: string;
    nm_categoria: string;
}

interface Pedido {
    id_pedido: number;
    nm_cliente: string;
    vl_total: string;
    st_pedido: string;
}

interface ItemPedido {
    id_item: number;
    id_pedido: number;
    id_produto: number;
    qt_produto: string;
    vl_preco_unitario: string;
    vl_subtotal: string;
}

interface Ranking {
    id_produto: number;
    nm_produto: string;
    total_vendido: string | null;
    total_faturado: string | null;
}

interface ResumoApi {
    erro: boolean;
    mensagem?: string;
    produtos: Produto[];
    pedidos: Pedido[];
    itens: ItemPedido[];
    ranking: Ranking[];
}

const formatarMoeda = (valor: number): string => {
    return valor.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL"
    });
};

const mostrarTexto = (id: string, texto: string): void => {
    const elemento = document.getElementById(id);

    if (elemento) {
        elemento.textContent = texto;
    }
};

const carregarDashboard = async (): Promise<void> => {
    try {
        const resposta = await fetch("api/resumo.php");

        if (!resposta.ok) {
            throw new Error("Erro ao buscar dados da API.");
        }

        const dados: ResumoApi = await resposta.json();

        if (dados.erro) {
            throw new Error(dados.mensagem);
        }

        const totalVendido = dados.pedidos.reduce((total, pedido) => {
            return total + Number(pedido.vl_total);
        }, 0);

        const totalDocesVendidos = dados.itens.reduce((total, item) => {
            return total + Number(item.qt_produto);
        }, 0);

        const produtosFormatados = dados.produtos.map((produto) => {
            return {
                nome: produto.nm_produto,
                categoria: produto.nm_categoria,
                preco: Number(produto.vl_preco)
            };
        });

        const produtosEspeciais = produtosFormatados.filter((produto) => {
            return produto.preco >= 10;
        });

        const destaque = dados.ranking.find((item) => {
            return Number(item.total_vendido) > 0;
        });

        mostrarTexto("totalVendido", formatarMoeda(totalVendido));
        mostrarTexto("totalPedidos", String(dados.pedidos.length));
        mostrarTexto("totalProdutos", String(dados.produtos.length));
        mostrarTexto("totalDocesVendidos", String(totalDocesVendidos));
        mostrarTexto("produtoDestaque", destaque ? destaque.nm_produto : "Sem vendas");

        const tabelaProdutos = document.getElementById("tabelaProdutos");

        if (tabelaProdutos) {
            tabelaProdutos.innerHTML = produtosFormatados.map((produto) => {
                return `
                    <tr>
                        <td>${produto.nome}</td>
                        <td>${produto.categoria}</td>
                        <td>${formatarMoeda(produto.preco)}</td>
                    </tr>
                `;
            }).join("");
        }

        const listaProdutosEspeciais = document.getElementById("listaProdutosEspeciais");

        if (listaProdutosEspeciais) {
            if (produtosEspeciais.length == 0) {
                listaProdutosEspeciais.innerHTML = "<li class='list-group-item'>Nenhum produto especial encontrado.</li>";
            } else {
                listaProdutosEspeciais.innerHTML = produtosEspeciais.map((produto) => {
                    return `<li class='list-group-item d-flex justify-content-between'>
                        <span>${produto.nome}</span>
                        <strong>${formatarMoeda(produto.preco)}</strong>
                    </li>`;
                }).join("");
            }
        }

        const tabelaMaisPedidos = document.getElementById("tabelaMaisPedidos");

        if (tabelaMaisPedidos) {
            tabelaMaisPedidos.innerHTML = dados.ranking.map((produto) => {
                return `
                    <tr>
                        <td>${produto.nm_produto}</td>
                        <td>${Number(produto.total_vendido)}</td>
                    </tr>
                `;
            }).join("");
        }
    } catch (erro) {
        const mensagemErro = document.getElementById("mensagemErro");

        if (mensagemErro) {
            mensagemErro.classList.remove("d-none");
            mensagemErro.textContent = "Nao foi possivel carregar o dashboard. Verifique o banco de dados.";
        }
    }
};

carregarDashboard();
