<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="">
        <meta name="description" content="">

        <title>Regulariza Imoveis</title>

        <!-- stylesheets css -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/et-line-font.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/vegas.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style_template.css') }}">

        <link href='https://fonts.googleapis.com/css?family=Rajdhani:400,500,700' rel='stylesheet' type='text/css'>

    </head>
    <body>
        
        <!-- preloader section -->
        <section class="preloader">
            <div class="sk-circle">
            <div class="sk-circle1 sk-child"></div>
            <div class="sk-circle2 sk-child"></div>
            <div class="sk-circle3 sk-child"></div>
            <div class="sk-circle4 sk-child"></div>
            <div class="sk-circle5 sk-child"></div>
            <div class="sk-circle6 sk-child"></div>
            <div class="sk-circle7 sk-child"></div>
            <div class="sk-circle8 sk-child"></div>
            <div class="sk-circle9 sk-child"></div>
            <div class="sk-circle10 sk-child"></div>
            <div class="sk-circle11 sk-child"></div>
            <div class="sk-circle12 sk-child"></div>
            </div>
        </section>
        <!-- preloader end -->

        <!-- home section -->
        <section id="home">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-2 col-md-8 col-sm-12">
                        <div class="home-thumb">
                            <h1 class="wow fadeInUp" data-wow-delay="0.4s">< SISGERS /></h1>
                            <h3 class="wow fadeInUp" data-wow-delay="0.6s">Solução em <strong>Gestão</strong> de <strong>Registros</strong> de imoveis.</h3>
                            <a href="#" data-toggle="modal" data-target="#modal1" class="btn btn-lg btn-success smoothScroll wow fadeInUp" data-wow-delay="1.0s">Acessar sistema</a>
                        </div>
                    </div>
                </div>
            </div>		
        </section>
        <!-- home end -->

        <!-- about section -->
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <img src="{{ asset('images/about-img.png') }}" class="img-responsive wow fadeInUp" alt="About">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="about-thumb">
                            <div class="section-title">
                                <h1 class="wow fadeIn" data-wow-delay="0.2s">SISREGS</h1>
                                <h3 class="wow fadeInUp" data-wow-delay="0.4s">Sisteam de Gestão de Registro de Imóvel.</h3>
                            </div>
                            <div class="wow fadeInUp" data-wow-delay="0.6s">
                                <p>Realize diversas consultas de taxas de imóvel com transferência de imóvel, cálculo de contrução 
                                e obra, cáculo de usucapião, cálculo de inventário, declaração de posse, cessão de posse, conulta a 
                                taxas de escrituras e registros.<p> 
                                <p>Gere porpostas de serviços e relatórios e documentos de transferências de imóveis, INCRA, 
                                solicitações de certidões, declarações de posse do imóvel, cessões de posse do imóvel, recibos emitidos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about end -->

        <!-- footer section -->
        <footer>
            <div class="container">
                <div class="row">
                    <svg class="svgcolor-light" preserveAspectRatio="none" viewBox="0 0 100 102" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0 L50 100 L100 0 Z"></path>
                    </svg>
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <h2>Endereço</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.6s">
                        Informa o endereço da empresa, nº 123<br>
                        Bairro - Maceió/AL<br>
                        Telefone: (82)91234-5678
                        </p>
                        <ul class="social-icon">
                        <li><a href="#" class="fa fa-facebook wow bounceIn" data-wow-delay="0.9s"></a></li>
                        <li><a href="#" class="fa fa-twitter wow bounceIn" data-wow-delay="1.2s"></a></li>
                        <li><a href="#" class="fa fa-behance wow bounceIn" data-wow-delay="1.4s"></a></li>
                        <li><a href="#" class="fa fa-dribbble wow bounceIn" data-wow-delay="1.6s"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end -->

        <!-- modal -->
        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-popup">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Acessar Sistema</h2>
                </div>
                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input name="email" type="email" class="form-control" id="fullname" placeholder="E-mail" require>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input name="password" type="password" class="form-control" id="email" placeholder="Senha" require>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                        <input name="submit" type="submit" class="form-control" id="submit" value="ENTRAR">
                </form>
            </div>
        </div>
        </div>
        <!-- modal end -->

        <!-- Back top -->
        <a href="#back-top" class="go-top"><i class="fa fa-angle-up"></i></a>

        <!-- javscript js -->
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <script src="{{ asset('js/vegas.min.js') }}"></script>

        <script src="{{ asset('js/wow.min.js') }}"></script>
        <script src="{{ asset('js/smoothscroll.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>

    </body>
</html>
