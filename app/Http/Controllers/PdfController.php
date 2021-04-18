<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Imovel;
use App\Document;
use App\Certificate;
use App\DeclarationSession;
use App\Receipt;
use App\Tender;
use App\Incra;
use PDF;

class PdfController extends Controller
{
    
    private $model;
    private $modelcli;
    private $modelimovel;
    private $modelcertificate;
    private $modelreceipt;
    private $modeltender;
    private $modelincra;

    public function __construct(
        Document $model, 
        Client $modelcli, 
        Imovel $modelimovel, 
        Certificate $modelcertificate, 
        DeclarationSession $modeldeclaration,
        Receipt $modelreceipt,
        Tender $modeltender,
        Incra $modelincra
        )
    {
        $this->model = $model;
        $this->modelcli = $modelcli;
        $this->modelimovel = $modelimovel;
        $this->modelcertificate = $modelcertificate;
        $this->modeldeclaration = $modeldeclaration;
        $this->modelreceipt = $modelreceipt;
        $this->modeltender = $modeltender;
        $this->modelincra = $modelincra;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request, $id)
    {
        $actors = $this->modelcli->all();
        
        $document = $this->model->find($id);
        if($document)
        {
            $pdf = PDF::loadView('documents.pdf', compact(['document','actors']));
            return $pdf->setPaper('A4')->stream();
            //return download('documents.pdf');
        }

        $request->session()->flash('alert', 'Registro não encontrado');
        return redirect()->route('documents.index');
        
    }

    public function pdfcertificate(Request $request, $id, $type)
    {
        $clients = $this->modelcli->all();
        
        $certificate = $this->modelcertificate->find($id);
        if($certificate)
        {
            
            if($type == 'minuta'){
                $pdf = PDF::loadView('certificates.pdf_minuta', compact(['certificate','clients']));
                return $pdf->setPaper('A4')->stream();
            }

            if($type == 'contract'){
                $pdf = PDF::loadView('certificates.pdf_contract', compact(['certificate','clients']));
                return $pdf->setPaper('A4')->stream();
            }

            if($type == 'letter'){
                $pdf = PDF::loadView('certificates.pdf_letter', compact(['certificate','clients']));
                return $pdf->setPaper('A4')->stream();
            }
        }

        $request->session()->flash('alert', 'Registro não encontrado');
        return redirect()->route('certificates.index');
        
    }

    public function pdfdeclaration(Request $request, $id, $type)
    {
        $clients = $this->modelcli->all();
        $imovels = $this->modelimovel->all();
        
        $declaration = $this->modeldeclaration->find($id);
        if($declaration){

            if($type == 'minuta'){
                $pdf = PDF::loadView('declaration.pdf_minuta', compact(['declaration','clients','imovels']));
                return $pdf->setPaper('A4')->stream();
            }
            if($type == 'contract'){
                $pdf = PDF::loadView('declaration.pdf_contract', compact(['declaration','clients','imovels']));
                return $pdf->setPaper('A4')->stream();
            }

            if($type == 'letter'){
                $pdf = PDF::loadView('declaration.pdf_letter', compact(['declaration','clients','imovels']));
                return $pdf->setPaper('A4')->stream();
            }

        }
        $request->session()->flash('alert', 'Registro não encontrado');
        return redirect()->route('declaration.index');
    }

    public function pdfreceipt(Request $request, $id)
    {
        $clients = $this->modelcli->all();
        $imovels = $this->modelimovel->all();
        
        $receipt = $this->modelreceipt->find($id);
        if($receipt)
        {
            $pdf = PDF::loadView('receipt.pdf', compact(['receipt','clients','imovels']));
            return $pdf->setPaper('A4')->stream();
        }
        $request->session()->flash('alert', 'Registro não encontrado');
        return redirect()->route('receipt.index');
    }

    public function pdftender(Request $request, $id)
    {
        //$clients = $this->modelcli->all();
        //$imovels = $this->modelimovel->all();
        
        $tender = $this->modeltender->find($id);
        if($tender)
        {
            $pdf = PDF::loadView('tenders.pdf', compact(['tender']));
            return $pdf->setPaper('A4')->stream();
        }
        $request->session()->flash('alert', 'Registro não encontrado');
        return redirect()->route('tenders.index');
    }

    public function pdfincra(Request $request, $id)
    {
        $clients = $this->modelcli->all();
        $incra = $this->modelincra->find($id);
        if($incra)
        {
            $pdf = PDF::loadView('incra.pdf', compact(['incra', 'clients']));
            return $pdf->setPaper('A4')->stream();
        }
        $request->session()->flash('alert', 'Registro não encontrado');
        return redirect()->route('incra.index');
    }

}
