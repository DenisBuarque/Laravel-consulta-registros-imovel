<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Certificate;
use App\Client;
use App\Imovel;
use App\CertificateImage;

class CertificationController extends Controller
{
    
    private $model;
    private $modelclient;
    private $modelimovel;
    private $modelimage;

    public function __construct(Certificate $model, Client $modelclient, Imovel $modelimovel, CertificateImage $modelimage)
    {
        $this->model = $model;
        $this->modelclient = $modelclient;
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
        $clients = $this->modelclient->all();
        
        $search = '';
        if(isset($request->search)){

            $search = $request->search;
            
            $query = $this->model;
            $columns = ['certificate'];
            foreach($columns as $value){
                $query = $query->orWhere($value, 'like', '%'.$search.'%');
            }
            $certificates = $query->orderBy('id','DESC')->get();

        }else{
            $certificates = $this->model->orderBy('id', 'DESC')->paginate(5);
        }

        return view('certificates.index', compact(['certificates','search']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = $this->modelclient->all();
        $imovels = $this->modelimovel->all();
        return view('certificates.create', compact(['clients','imovels']));
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
            'registry' => 'required',
            'craft' => 'required',
            'certificate' => 'required',
            'client_id' => 'required',
            //filename' => 'required',
            //'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ])->validate();

        $certificate = new Certificate();
        $certificate->registry = $request->registry;
        $certificate->craft = $request->craft;
        $certificate->certificate = $request->certificate;
        $certificate->imovel_id = $request->imovel_id;
        $certificate->book = $request->book;
        $certificate->sheet = $request->sheet;
        $certificate->transcription = $request->transcription;
        $certificate->date_registry = $request->date_registry;
        $certificate->description = $request->description;
        $certificate->client_id = $request->client_id;

        if($certificate->save()) 
        {
            if($request->hasfile('arquivo'))
            {
                Validator::make($request->file('arquivo'),[
                    'arquivo' => 'image|mimes:jpeg,png,jpg,gif,svg',
                ])->validate();
                
                foreach($request->file('arquivo') as $image)
                {
                    $name = time().rand(1,100).'.'.$image->extension();
                    $image->move(public_path('certificates/'.$certificate->id), $name);
                    //$image->move(Storage::makeDirectory('documents/'.$document->id), $name);
                    $certificate_image = new CertificateImage();
                    $certificate_image->certificate_id = $certificate->id;
                    $certificate_image->path = $name;
                    $certificate_image->save();
                    unset($certificate_image);
                }
            }

            $request->session()->flash('alert', 'Registro inserido com sucesso!');
            return redirect()->route('certificates.index');
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
        $certificate_images = $this->modelimage->all();
        $clients = $this->modelclient->all();
        $imovels = $this->modelimovel->all();

        $certificate = $this->model->find($id);
        if($certificate){
            return view('certificates.show', compact(['certificate','clients','imovels','certificate_images']));
        }

        $request->session()->flash('erro', 'Não encontramos o documento!');
        return view('certificates.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients = $this->modelclient->all();
        $imovels = $this->modelimovel->all();

        $certificate = $this->model->find($id);
        if($certificate){
            return view('certificates.edit', compact(['certificate','clients','imovels']));
        }

        $request->session()->flash('erro', 'Não encontramos o documento!');
        return view('certificates.index');
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
            'registry' => 'required',
            'craft' => 'required',
            'certificate' => 'required',
            'client_id' => 'required',
            //filename' => 'required',
            //'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ])->validate();

        $certificate = $this->model->find($id);
        if(isset($certificate))
        {
            if($certificate->update($data)){

                if($request->hasfile('arquivo'))
                {
                    Validator::make($request->file('arquivo'),[
                        'arquivo' => 'image|mimes:jpeg,png,jpg,gif,svg',
                    ])->validate();
                    
                    foreach($request->file('arquivo') as $image)
                    {
                        $name = time().rand(1,100).'.'.$image->extension();
                        $image->move(public_path('certificates/'.$id), $name);
                        //$image->move(Storage::makeDirectory('certificates/'.$id), $name);
                        
                        $certificate_image = new CertificateImage();
                        $certificate_image->certificate_id = $id;
                        $certificate_image->path = $name;
                        $certificate_image->save();
                        unset($certificate_image);
                    }
                }
                
                $request->session()->flash('alert', 'Registro alterado com sucesso!');
                return redirect()->route('certificates.index');

            }else{
                $request->session()->flash('alert', 'Erro ao alterar o registro!');
                return redirect()->back();
            }
        }

        return redirect()->route('certificates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $certificate = $this->model->find($id);
        if($certificate):
            $certificate->delete();
            $request->session()->flash('alert', 'Registro excluído com sucesso!');
        else:
            $request->session()->flash('erro', 'Erro ao excluir o sucesso!');
        endif;

        return redirect()->route('certificates.index');
    }

    public function imagedestroy(Request $request, $id)
    {
        $image = $this->modelimage->find($id);
        if($image):
            unlink(public_path('certificates/'.$image->certificate_id.'/'.$image->path));
            $image->delete();
            $request->session()->flash('alert', 'Registro excluído com sucesso!');
        else:
            $request->session()->flash('erro', 'Erro ao excluir o sucesso!');
        endif;

        return redirect()->back();
    }
}
