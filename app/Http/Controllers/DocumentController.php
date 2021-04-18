<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Utils\UtilsRepository; 
use App\Document;
use App\Client;
use App\Imovel;
use App\DocumentImage;

class DocumentController extends Controller
{
    private $model;
    private $modelcli;
    private $modelimovel;
    private $modelimage;

    public function __construct(Document $model, Client $modelcli, Imovel $modelimovel, DocumentImage $modelimage)
    {
        $this->model = $model;
        $this->modelcli = $modelcli;
        $this->modelimovel = $modelimovel;
        $this->modelimage = $modelimage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents_images = $this->modelimage->all();
        
        $clients = $this->modelcli->all();
        $search = '';
        if(isset($request->search)){

            $search = $request->search;
            
            $query = $this->model;
            $columns = ['buyer','seller','witness_1','witness_2'];
            foreach($columns as $value){
                $query = $query->orWhere($value, 'like', '%'.$search.'%');
            }
            $documents = $query->orderBy('id','DESC')->get();

        }else{
            $documents = $this->model->orderBy('id', 'DESC')->paginate(5);
        }

        return view('documents.index', compact(['documents','clients','search','documents_images']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = $this->modelcli->all();
        $imovels = $this->modelimovel->all();
        return view('documents.create', compact(['clients','imovels']));
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
            'imovel_id' => 'required',
            'seller' => 'required',
            'buyer' => 'required',
            //filename' => 'required',
            //'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ])->validate();

        $document = new Document();
        $document->imovel_id = $request->imovel_id;
        $document->seller = $request->seller;
        $document->buyer = $request->buyer;
        $document->witness_1 = $request->witness_1;
        $document->witness_2 = $request->witness_2;
        if($document->save()) 
        {
            if($request->hasfile('arquivo'))
            {
                Validator::make($request->file('arquivo'),[
                    'arquivo' => 'image|mimes:jpeg,png,jpg,gif,svg',
                ])->validate();
                
                foreach($request->file('arquivo') as $image)
                {
                    $name = time().rand(1,100).'.'.$image->extension();
                    $image->move(public_path('documents/'.$document->id), $name);
                    //$image->move(Storage::makeDirectory('documents/'.$document->id), $name);

                    $document_image = new Documentimage();
                    $document_image->document_id = $document->id;
                    $document_image->path = $name;
                    $document_image->save();
                    unset($document_image);
                }
            }

            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('documents.index');
        } 

        $request->session()->flash('erro', 'Erro ao inserir o registro!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $documents_images = $this->modelimage->all();
        $clients = $this->modelcli->all();
        
        $document = $this->model->find($id);
        if($document)
        {
            return view('documents.show', compact(['document','clients','documents_images']));
        }

        $request->session()->flash('erro', 'Não encontramos o que procura!');
        return redirect()->route('documents.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients = $this->modelcli->all();
        $imovels = $this->modelimovel->all();

        $document = $this->model->find($id);
        if($document){
            return view('documents.edit', compact(['document','clients','imovels']));
        }

        $request->session()->flash('erro', 'Não encontramos o documento!');
        return view('documents.index');
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
        Validator::make($data, [
            'imovel_id' => 'required',
            'seller' => 'required',
            'buyer' => 'required',
        ])->validate();
        
        $document = $this->model->find($id);
        if(isset($document))
        {
            if($document->update($data)){

                if($request->hasfile('arquivo'))
                {
                    Validator::make($request->file('arquivo'),[
                        'arquivo' => 'image|mimes:jpeg,png,jpg,gif,svg',
                    ])->validate();
                    
                    foreach($request->file('arquivo') as $image)
                    {
                        $name = time().rand(1,100).'.'.$image->extension();
                        $image->move(public_path('documents/'.$id), $name);
                        //$image->move(Storage::makeDirectory('documents/'.$id), $name);
                        
                        $document_image = new Documentimage();
                        $document_image->document_id = $id;
                        $document_image->path = $name;
                        $document_image->save();
                        unset($document_image);
                    }
                }
                
                $request->session()->flash('alert', 'Registro alterado com sucesso!');
                return redirect()->route('documents.index');

            }else{
                $request->session()->flash('alert', 'Erro ao alterar o registro!');
                return redirect()->back();
            }
        }

        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $document = $this->model->find($id);
        if($document):
            $document->delete();
            $request->session()->flash('alert', 'Registro excluído com sucesso!');
        else:
            $request->session()->flash('erro', 'Erro ao excluir o sucesso!');
        endif;

        return redirect()->route('documents.index');
    }

    public function imagedestroy(Request $request, $id)
    {
        $image = $this->modelimage->find($id);
        if($image):
            unlink(public_path('documents/'.$image->document_id.'/'.$image->path));
            $image->delete();
            $request->session()->flash('alert', 'Registro excluído com sucesso!');
        else:
            $request->session()->flash('erro', 'Erro ao excluir o sucesso!');
        endif;

        return redirect()->back();
    }

}
