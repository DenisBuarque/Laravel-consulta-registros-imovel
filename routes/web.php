<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// usuário
Route::get('/usuario','UserController@index')->middleware(['can:list-user','auth'])->name('users.index');
Route::get('/usuario/novo','UserController@create')->middleware(['can:create-data','auth'])->name('users.create');
Route::post('/usuario/novo','UserController@store')->middleware('auth')->name('users.store');
Route::get('/usuario/editar/{id}','UserController@edit')->middleware(['can:update-data','auth'])->name('users.edit');
Route::put('/usuario/editar/{id}','UserController@update')->middleware('auth')->name('users.update');
Route::delete('/usuario/{id}','UserController@destroy')->middleware(['can:delete-data','auth'])->name('users.delete');
// consulta transferencia
Route::get('/consulta/transferencia', 'TransferController@create')->middleware('auth')->name('consultations.transfer.incash.index');
Route::post('/consulta/transferencia', 'TransferController@store')->middleware('auth')->name('consultations.transfer.incash.store');
// consulta transferencia financiado
Route::get('/consulta/transferencia/financiado', 'FinanceController@create')->middleware('auth')->name('consultations.tranfer.finance.index');
Route::post('/consulta/transferencia/financiado', 'FinanceController@store')->middleware('auth')->name('consultations.tranfer.finance.store');
// consulta construção e obra
Route::get('/consulta/construcao', 'ConstructionController@create')->middleware(['can:query-building','auth'])->name('consultations.construction.index');
Route::post('/consulta/construcao', 'ConstructionController@store')->middleware('auth')->name('consultations.construction.store');
// consulta declaração de posse
Route::get('/consulta/declaracao', 'DeclarationController@create')->middleware('auth')->name('consultations.declaration.index');
Route::post('/consulta/declaracao', 'DeclarationController@store')->middleware('auth')->name('consultations.declaration.store');
// consulta cessão d eposse
Route::get('/consulta/sessao', 'PossessionController@create')->middleware('auth')->name('consultations.possession.index');
Route::post('/consulta/sessao', 'PossessionController@store')->middleware('auth')->name('consultations.possession.store');
// consulta usucapião
Route::get('/consulta/usucapiao', 'UsucapiaoController@create')->middleware(['can:query-usucapiao','auth'])->name('consultations.usucapiao.index');
Route::post('/consulta/usucapiao', 'UsucapiaoController@store')->middleware('auth')->name('consultations.usucapiao.store');
// consulta inventario
Route::get('/consulta/inventario','InventoryController@create')->middleware(['can:query-inventory','auth'])->name('consultations.inventory.index');
Route::post('/consulta/inventario','InventoryController@store')->middleware('auth')->name('consultations.inventory.store');
// cliente (atores)
Route::get('/clientes','ClientController@index')->middleware(['can:list-actors','auth'])->name('clients.index');
Route::get('/clientes/detalhe/{id}','ClientController@show')->middleware(['can:show-data','auth'])->name('clients.show');
// cliente (atores) pessoa fisica
Route::get('/clientes/pessoa/fisica','FisicClientController@create')->middleware(['can:create-data','auth'])->name('clients.fisic.create');
Route::post('/clientes/pessoa/fisica','FisicClientController@store')->middleware('auth')->name('clients.fisic.store');
Route::get('/clientes/editar/fisica/{id}','FisicClientController@edit')->middleware(['can:update-data','auth'])->name('clients.fisic.edit');
Route::put('/clientes/fisica/{id}','FisicClientController@update')->middleware('auth')->name('clients.fisic.update');
// cliente (atores) pessoa juridica
Route::get('/clientes/pessoa/juridica','JuridicClientController@create')->middleware(['can:create-data','auth'])->name('clients.juridic.create');
Route::post('/clientes/pessoa/juridica','JuridicClientController@store')->middleware('auth')->name('clients.juridic.store');
Route::get('/clientes/editar/juridica/{id}','JuridicClientController@edit')->middleware(['can:update-data','auth'])->name('clients.juridic.edit');
Route::put('/clientes/juridica/{id}','JuridicClientController@update')->middleware('auth')->name('clients.juridic.update');
Route::delete('/clientes/{id}','ClientController@destroy')->middleware(['can:delete-data','auth'])->name('clients.delete');
// imoveis
Route::get('/imovel','ImovelController@index')->middleware(['can:list-imovels','auth'])->name('imovel.index');
Route::get('/imovel/novo','ImovelController@create')->middleware(['can:create-data','auth'])->name('imovel.create');
Route::post('/imovel/novo','ImovelController@store')->middleware('auth')->name('imovel.store');
Route::get('/imovel/editar/{id}','ImovelController@edit')->middleware(['can:update-data','auth'])->name('imovel.edit');
Route::put('/imovel/editar/{id}','ImovelController@update')->middleware('auth')->name('imovel.update');
Route::delete('/imovel/{id}','ImovelController@destroy')->middleware(['can:delete-data','auth'])->name('imovel.delete');
// documento de transferencia
Route::get('/documento','DocumentController@index')->middleware(['can:generate-transfer','auth'])->name('documents.index');
Route::get('/documento/detalhe/{id}','DocumentController@show')->middleware(['can:show-data','auth'])->name('documents.show');
Route::get('/documento/novo','DocumentController@create')->middleware(['can:create-data','auth'])->name('documents.create');
Route::post('/documento/novo','DocumentController@store')->middleware('auth')->name('documents.store');
Route::get('/documento/editar/{id}','DocumentController@edit')->middleware(['can:update-data','auth'])->name('documents.edit');
Route::put('/documento/editar/{id}','DocumentController@update')->middleware('auth')->name('documents.update');
Route::delete('/documento/{id}','DocumentController@destroy')->middleware(['can:delete-data','auth'])->name('documents.delete');
Route::delete('/documento/image/{id}','DocumentController@imagedestroy')->middleware('auth')->name('documents.imagedelete');
Route::get('/documento/pdf/{id}','PdfController@pdf')->middleware('can:generate-pdf')->name('documents.pdf');
//certidões
Route::get('/certidao','CertificationController@index')->middleware(['can:generate-certificate','auth'])->name('certificates.index');
Route::get('/certidao/detalhe/{id}','CertificationController@show')->middleware(['can:show-data','auth'])->name('certificates.show');
Route::get('/certidao/novo','CertificationController@create')->middleware(['can:create-data','auth'])->name('certificates.create');
Route::post('/certidao/novo','CertificationController@store')->middleware('auth')->name('certificates.store');
Route::get('/certidao/editar/{id}','CertificationController@edit')->middleware(['can:update-data','auth'])->name('certificates.edit');
Route::put('/certidao/editar/{id}','CertificationController@update')->middleware('auth')->name('certificates.update');
Route::delete('/certidao/image/{id}','CertificationController@imagedestroy')->middleware('auth')->name('certificates.imagedelete');
Route::delete('/certidao/{id}','CertificationController@destroy')->middleware(['can:delete-data','auth'])->name('certificates.delete');
Route::get('/certidao/pdf/{id}/{type}','PdfController@pdfcertificate')->middleware('can:generate-pdf')->name('certificates.pdfcertificate');
// declarações
Route::get('/declaracao','DeclarationSessionController@index')->middleware(['can:generate-declaration','auth'])->name('declaration.index');
Route::get('/declaracao/detalhe/{id}','DeclarationSessionController@show')->middleware(['can:show-data','auth'])->name('declaration.show');
Route::get('/declaracao/novo','DeclarationSessionController@create')->middleware(['can:create-data','auth'])->name('declaration.create');
Route::post('/declaracao/novo','DeclarationSessionController@store')->middleware('auth')->name('declaration.store');
Route::get('/declaracao/edit/{id}','DeclarationSessionController@edit')->middleware(['can:update-data','auth'])->name('declaration.edit');
Route::put('/declaracao/edit/{id}','DeclarationSessionController@update')->middleware('auth')->name('declaration.update');
Route::delete('/declaracao/{id}','DeclarationSessionController@destroy')->middleware(['can:delete-data','auth'])->name('declaration.delete');
Route::get('/declaracao/pdf/{id}/{type}','PdfController@pdfdeclaration')->middleware('can:generate-pdf')->name('declaration.pdfdeclaration');
// recibos
Route::get('/recibo','ReceiptController@index')->middleware(['can:list-receipt','auth'])->name('receipt.index');
Route::get('/recibo/novo','ReceiptController@create')->middleware(['can:create-data','auth'])->name('receipt.create');
Route::post('/recibo/novo','ReceiptController@store')->middleware('auth')->name('receipt.store');
Route::delete('/recibo/{id}','ReceiptController@destroy')->middleware(['can:delete-data','auth'])->name('receipt.delete');
Route::get('/recibo/pdf/{id}','PdfController@pdfreceipt')->middleware('can:generate-pdf')->name('receipt.pdfreceipt');
// propostas
Route::get('/propostas','TenderController@index')->middleware(['can:list-tender','auth'])->name('tenders.index');
Route::post('/propostas/novo','TenderController@store')->middleware('auth')->name('tenders.store');
Route::delete('/propostas/delete/{id}','TenderController@destroy')->middleware('auth')->name('tender.delete');
Route::get('/propostas/pdf/{id}','PdfController@pdftender')->middleware('auth')->name('tenders.pdf');
// email
Route::get('/email','ReceiptMailController@create')->middleware(['can:list-mail','auth'])->name('receiptemail.create');
Route::post('/email/enviar','ReceiptMailController@store')->middleware('auth')->name('receiptemail.store');
// taxas de escritura (Deed Fee)
Route::get('/taxaescritura','DeedFeeController@index')->middleware(['can:list-deed','auth'])->name('deedfee.index');
Route::get('/taxaescritura/novo','DeedFeeController@create')->middleware(['can:create-data','auth'])->name('deedfee.create');
Route::post('/taxaescritura/novo','DeedFeeController@store')->middleware('auth')->name('deedfee.store');
Route::get('/taxaescritura/editar/{id}','DeedFeeController@edit')->middleware(['can:update-data','auth'])->name('deedfee.edit');
Route::put('/taxaescritura/editar/{id}','DeedFeeController@update')->middleware('auth')->name('deedfee.update');
Route::delete('/taxaescritura/{id}','DeedFeeController@destroy')->middleware(['can:delete-data','auth'])->name('deedfee.delete');
// taxas de registr (registration Fee)
Route::get('/taxaregistro','RegistrationFeeController@index')->middleware(['can:list-register','auth'])->name('registrationfee.index');
Route::get('/taxaregistro/novo','RegistrationFeeController@create')->middleware(['can:create-data','auth'])->name('registrationfee.create');
Route::post('/taxaregistro/novo','RegistrationFeeController@store')->middleware('auth')->name('registrationfee.store');
Route::get('/taxaregistro/editar/{id}','RegistrationFeeController@edit')->middleware(['can:update-data','auth'])->name('registrationfee.edit');
Route::put('/taxaregistro/editar/{id}','RegistrationFeeController@update')->middleware('auth')->name('registrationfee.update');
Route::delete('/taxaregistro/{id}','RegistrationFeeController@destroy')->middleware(['can:delete-data','auth'])->name('registrationfee.delete');
// taxas de registr (registration Fee)
Route::get('/incra','IncraController@index')->middleware(['can:list-register','auth'])->name('incra.index');
Route::get('/incra/detalhe/{id}','IncraController@show')->middleware(['can:show-data','auth'])->name('incra.show');
Route::get('/incra/novo','IncraController@create')->middleware(['can:create-data','auth'])->name('incra.create');
Route::post('/incra/novo','IncraController@store')->middleware('auth')->name('incra.store');
Route::get('/incra/editar/{id}','IncraController@edit')->middleware(['can:update-data','auth'])->name('incra.edit');
Route::put('/incra/editar/{id}','IncraController@update')->middleware('auth')->name('incra.update');
Route::delete('/incra/{id}','IncraController@destroy')->middleware(['can:delete-data','auth'])->name('incra.delete');
Route::get('/incra/pdf/{id}','PdfController@pdfincra')->middleware('auth')->name('incra.pdf');