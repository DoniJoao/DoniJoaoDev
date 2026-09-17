<?php
class ProdutoController extends Controller
{
    public function index()
    {
        $produtoModel = new Produto($this->db());
        $produtos = $produtoModel->listarAtivos()->fetchAll();

        $this->view('produtos', ['produtos' => $produtos]);
    }
}