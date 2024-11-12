<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AcpController extends Controller
{

    //Renderiza view de login
    public function index(Request $request)
    {
        return view('home');
    }

    //Renderizar view área restrita
    public function acp(Request $request)
    {
        return view('dashboardacp');
    }

    //Metódo para buscar dados de postagem
    public function gerarXls()
    {
        $dados = Post::getdata();

        $html = '';
        $html .= ' <meta charset="UTF-8">';
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<td><b>ID</b></td>';
        $html .= '<td><b>Title Post</b></td>';
        $html .= '<td><b>Conteúdo</b></td>';
        $html .= '<td><b>Data de criação</b></td>';
        $html .= '<td><b>Autor/User</b></td>';
        $html .= '<td><b>Tags Relacionadas</b></td>';
        $html .= '</tr>';

        //esse comando inseri no banco o(s) alunos
        foreach ($dados as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row->id . '</td>';
            $html .= '<td>' . $row->title . '</td>';
            $html .= '<td>' . $row->content . '</td>';
            $html .= '<td>' . $row->created_at . '</td>';
            $html .= '<td>' . $row->user_name . '</td>';
            $html .= '<td>' . $row->tag_names . '</td>';
            $html .= '</tr>';
        }

        $dados->isEmpty() ?  $html .= '<tr><td colspan="6">SEM DADOS PARA EXIBIR</td></tr>' : '';

        $html .= '</table>';

        $arquivo = "Api_Acp_Group.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $arquivo . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        echo $html;
    }
}
