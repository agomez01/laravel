<!--<div id="close-toggle2" class="cerrar-toggle2"></div>-->
    <header role="banner" class="navbar navbar-fixed-top navbar-inverse">
        <div class="container row">

            <div class="navbar-header"  >
                <button id="collapse-left" data-toggle="collapse-side" data-target=".side-collapse" data-target-2=".side-collapse-container" type="button" class="navbar-toggle pull-left">
                    <span class="glyphicon glyphicon-chevron-right"></span>              
                </button>
            </div>

            <div class="top_line col-md-12 col-sm-12"><!-- top_line -->    
    <div class="top_usuario" style="color:#fff;">    
    </div>
    <div class="top_btn" title="Salir">
        <a href="/logout" >
            Salir
            <img src="../assets/img/webclass-btn-salir.png" alt="Salir" width="24" height="24"   />
        </a>
    </div>

    <div class="top_btn" title="Ayuda">
        <a href="http://webclass.com/tutoriales" target="_blank" >
            Ayuda
            <img src="../assets/img/webclass-btn-pregunta.png" alt="Ayuda" width="24" height="24"/>
        </a>
    </div>
    <div class="top_btn" title="Soprte">
        <a id="islpronto_link" href="mailto:soporte@webclass.com">
            Chat Soporte
            <img src="../assets/img/webclass-btn-soporte.png" alt=">Chat Soporte" name="islpronto_image" width="24" height="24" id="islpronto_image" style="border:none"/>
        </a>
    </div>
    <div class="top_btn">
        <a href="#" title="Cambiar tema">
            Cambiar tema
            <img src="../assets/img/webclass-btn-configuracion.png" alt="Cambiar tema"  width="24" height="24"/>
        </a>
    </div>
    <div class="top_selector" title="Cambiar rol de usuario">
        <img src="../assets/img/webclass-btn-cambiar_vista.png" width="24" height="24"/>
        <span>    
            <div id="cambioColegio">
                <select name="comboboxcolegio" onChange="">
                    <option  value="">Cambiar vista</option>         
                    <option value=""></option>              
                </select>
            </div>
        </span>     
    </div>
</div>
            
            <div class="navbar-inverse side-collapse in">            
                <nav role="navigation" class="navbar-collapse">                    
                    <ul class="nav navbar-nav">                                    
                        @yield('menu')
                                                                         
                    </ul>
                </nav>
            </div>
        </div>
    </header>  