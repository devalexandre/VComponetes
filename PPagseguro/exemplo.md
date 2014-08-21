 
 public function onBuyClick($param){

        try{
        TTransaction::open('sample');

        //produto para incluir no carrinho
        $produto = new PProduto();
        $cliente = new Alunos(TSession::getValue('alunos_id'));

        //é nescessario ao menos o nome do cliente
        $c = new PCliente();
        $c->setNome('alexandre');


        $dados = new Cursos($param['id']);

        //seta os dados do produto
        $produto->setId($dados->id);
        $produto->setNome($dados->nome);
        $produto->setDescricao($dados->descricao);
        $produto->setQtd(1);
        $produto->setPreco($dados->preco);

        //arquivo Ini
        $pg = new PPagSeguro('pagseguro');

        $pg->addCliente($c);
        $pg->addItem($produto);


        $url =  $pg->getButton();

        echo "<a class='btn btn-success' href=".$url.">Comprar</a>";

    }catch (Exception $e){
        
            new TMessage('error',$e->getMessage());
        }
    }