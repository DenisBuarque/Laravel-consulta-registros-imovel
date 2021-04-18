<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Permission;

class UserController extends Controller
{
    private $model;
    private $modelpermission;

    public function __construct(User $model, Permission $modelpermission)
    {
        $this->model = $model;
        $this->modelpermission = $modelpermission;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->model->all();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->modelpermission->all();
        return view('users.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ])->validate();

        $data['password'] =  bcrypt($request->password);

        $record = $this->model->create($data);
        if($record){
            if(isset($data['permissions']) && count($data['permissions']))
            {
                foreach($data['permissions'] as $key => $value):
                    $record->permissions()->attach($value);
                endforeach;
            }
            $request->session()->flash('alert','Registro inserido com sucesso!');
            return redirect()->route('users.index');
        }else{
            $request->session()->flash('erro','Erro ao inserir o registro!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $permissions = $this->modelpermission->all();
        $user = $this->model->find($id);
        if($user){
            return view('users.edit',compact(['user','permissions']));
        }
        $request->session()->flash('alert','Não encontramos o que procura!');
        return redirect()->route('users.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if(!$data['password']):
            unset($data['password']);
        endif;
        
        Validator::make($data, [
            'name' => 'required|string|max:50',
            'email' => ['required','string','email','max:100',Rule::unique('users')->ignore($id)],
            'password' => 'sometimes|required|string|min:6|confirmed',
        ])->validate();

        if($request->password){
            $data['password'] =  bcrypt($request->password);
        }

        $records = $this->model->find($id);
        if($records)
        {
            $permissions = $records->permissions;
            if(count($permissions)){
                foreach($permissions as $key => $value):
                    // chama a função permissions do modelo Permission.php e usa detach() apara apaga registro
                    $records->permissions()->detach($value->id);
                endforeach;
            }

            if(isset($data['permissions']) && count($data['permissions']))
            {
                foreach($data['permissions'] as $key => $value):
                    $records->permissions()->attach($value);
                endforeach;
            }
            
            if($records->update($data)){
                $request->session()->flash('alert','Registro alterado com sucesso!');
                return redirect()->route('users.index');
            }else{
                $request->session()->flash('erro','Erro ao alterar o registro!');
                return redirect()->back();
            }
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $this->model->find($id);
        if($user)
        {
            if($user->delete()){
                $request->session()->flash('alert','Registro excluído com sucesso!');
                return redirect()->route('users.index');
            }else{
                $request->session()->flash('erro','Erro ao excluir o registro!');
                return redirect()->back();
            }
        }
    }
}
