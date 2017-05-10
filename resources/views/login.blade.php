    <link href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <script src="{!! URL::asset('/bower_components/jquery/dist/jquery.min.js'); !!}"></script>

       <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading" style="background-color:#6796C8;border-color:#6796C8">
                        <h3 class="panel-title" style="color:white">Ingrese Usuario y Contrase&ntilde;a</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="{{action('WelcomeController@doLogin')}}" method="POST">
                             <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <?if($recordarme):?>
                                        <input name="recordar_usuario" type="checkbox" value="recordar" checked>Recordarme
                                        <?else:?>
                                        <input name="recordar_usuario" type="checkbox" value="recordar">Recordarme
                                        <?endif;?>
                                    </label>
                                </div>
                                
                            <input type="submit" class="btn btn-lg btn-success btn-block" style="background-color:#6796C8;border-color:#6796C8" value="Ingresar"></input>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--<a href="{{action('WelcomeController@doLogin')}}" class="btn btn-lg btn-success btn-block" style="background-color:#6796C8;border-color:#6796C8">Ingresar</a>-->