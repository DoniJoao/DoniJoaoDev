<?php
/** Páginas estáticas, sem banco. */
class ContatoController extends Controller
{
    public function contato()
    {
        $this->view('contato');
    }
}