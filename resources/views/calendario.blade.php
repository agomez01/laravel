<div id="calendar">calendario</div>

<div class="modal fade" id="events-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Evento</h3>
            </div>
            <div class="modal-body" style="height: 400px">
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn">Cerrar</a>
            </div>
        </div>
    </div>
</div>

<div>

	<div class="checkbox">
		<label><div class="ck_event_personal"><input type="checkbox" id='ck_event_personal' class='ckb_filtro_eventos' checked></div> Eventos Personales</label>
	</div>
	
	<div class="checkbox">
		<label><div class="ck_event_global"><input type="checkbox" id='ck_event_global' class='ckb_filtro_eventos' checked></div> Eventos Globales</label>
	</div>

	<div class="checkbox">
		<label><div class="ck_event_curso"><input type="checkbox" id='ck_event_curso' class='ckb_filtro_eventos' checked></div> Eventos Curso</label>
	</div>
	
</div>

 <!-- Calendar -->
    <script src="{{ asset('assets/js/underscore/underscore-min.js') }}"></script>
    <script src="{{ asset('assets/js/jstimezonedetect/jstz.min.js') }}"></script>
    <script src="{{ asset('assets/js/calendar/calendar.js') }}" src="js/calendar.js"></script>
    <script src="{{ asset('assets/js/calendar/language/es-ES.js') }}" src="js/language/es-ES.js"></script>
    <script src="{{ asset('assets/js/calendar/app.js') }}" src="js/app.js"></script>