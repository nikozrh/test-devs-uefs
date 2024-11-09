<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Retornar a lista de usuários
     * @return JsonResponse Retorna os usuários
     */
    public function index(): JsonResponse
    {   
        DB::beginTransaction();
        try { 
            $users = $this->userService->all();
            DB::commit();
         
            return response()->json([
                'status' => true,
                'users' => $users
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao buscar os usuários'
            ], 400);
        }
    }

    /**
     * Retornar um usuário específico
     * @return JsonResponse Retorna um usuário específico
     */
    public function show(Request $request): JsonResponse
    {   
        DB::beginTransaction();
        try{
            $user = $this->userService->find($request->id);
            DB::commit();

            return response()->json([
                'status' => true,
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => 'Usuário não encontrado.'
            ], 400);
        }
    }

    /**
     * Criar um novo usuário
     * @return JsonResponse Retorna o usuário criado
     */

    public function store(UserRequest $request):JsonResponse
    { 
        //Inicia a transação no banco
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password, ['rounds' => 12]),
            ];
           
            $result = $this->userService->store($data);

            //Operação concluida com exito no banco
            DB::commit(); 

            if($result['status']){
                return response()->json([
                    'status' => $result['status'],
                    'user' => $result['user'],
                    'message' => $result['message']
                ], 201);
            } else {
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], 400);
            }
            
        } catch (\Exception $e) {
            //Operação não concluida com exito no banco
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao cadastrar o usuário'
            ], 400);
        }
    }

    /**
     * Atualizar um usuário
     * @return JsonResponse Retorna o usuário atualizado
     */
    public function update(UserRequest $request):JsonResponse
    {
        DB::beginTransaction();

        try{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password, ['rounds' => 12])
            ];

            $result = $this->userService->update($request->id, $data);
            DB::commit();

            if($result['status']){
                return response()->json([
                    'status' => $result['status'],
                    'user' => $result['user'],
                    'message' => $result['message']
                ], 200);
            } else {
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], 400);
            }
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao atualizar o usuário'
            ], 400);
        }

    }

    /**
     * Deleta um usuário
     * @return JsonResponse Retorna o usuário deletado
     */
    public function destroy(Request $request):JsonResponse
    {
        DB::beginTransaction();
        try{
            $result = $this->userService->destroy($request->id);
            DB::commit();

            if($result['status']){
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], 200);
            } else {
                return response()->json([
                    'status' => $result['status'],
                    'message' => $result['message']
                ], 400);
            }
        }catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Ocorreu um erro ao excluir o usuário'
            ], 400);
        }
    }
}