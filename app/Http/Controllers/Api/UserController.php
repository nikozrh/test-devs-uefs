<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HelperApiController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
// use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Retorna todos os usuários cadastrados.
     * Rota: GET /api/users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();  // Retorna todos os usuários sem filtros.
    }

     /**
     * Exibe os dados de um usuário específico pelo ID.
     * Rota: GET /api/users/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        //valido se o usuário é existente
        if(User::find($id) == null)
        return HelperApiController::ExistText($id, 'users');

        // Encontra e retorna um usuário pelo ID ou lança uma exceção se não encontrado.
        return User::findOrFail($id);
    } 

    /**
     * Cria um novo usuário no banco de dados.
     * Rota: POST /api/users
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validação dos dados da requisição
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6',  // Confirmar que as senhas coincidem
        ]);

        // Tratar erro de validação dos dados de entrada.
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cria um novo usuário com os dados validados.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Criptografando a senha
        ]);

        // Retornando o usuário criado
        return response()->json($user, 201);
        
    }

    /**
     * Atualiza os dados de um usuário existente.
     * Rota: PUT /api/users/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //valido se o usuário é existente
         if(User::find($id) == null)
         return HelperApiController::ExistText($id, 'users');

        // Encontra o usuário pelo ID ou lança uma exceção se não encontrado.
        $user = User::findOrFail($id);

        // Atualiza o usuário com os dados fornecidos no request.
        $user->update($request->all());

        // Retorna os dados atualizados do usuário.
        return response()->json($user);
    }

    /**
     * Exclui um usuário pelo ID.
     * Rota: DELETE /api/users/{id}
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //valido se o usuário é existente
        if(User::find($id) == null)
        return HelperApiController::ExistText($id, 'users');

        // Encontra e deleta o usuário pelo ID.
        User::findOrFail($id)->delete();

        // Retorna uma mensagem indicando que o usuário foi excluído com sucesso.
        return response()->json(['message' => 'Usuário deletado com sucesso!']);
    }

      /**
     * Validar se existe um token ativo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function is_loged(Request $request)
    {
        // Verifica se o token existe no cookie
        if ($request->cookie('token')) {

            return true;
        }
    }

    /**
     * Função especifica para o login dashboard web. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $auth = new AuthController();
        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            session(['token' => auth('api')->attempt($credentials)]);
            return redirect()->guest('/postagens')->cookie('token', session('token'), 60, null, null, false, true);
        }

        return redirect()->back()->withErrors(['msg' => 'Credenciais Inválidas']);
    }
}
