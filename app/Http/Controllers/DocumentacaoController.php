<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentacaoController extends Controller
{
    public function index()
    {
        return view('documentacao');
    }
}