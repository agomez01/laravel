
@if ($seccion === 'cuerpo')

		@if ($pregunta["data"]->tipo === 1)
    
		    
			<table width="100%" >

				<tr>

					<td valign="middle"><input type="radio" name="vof_<?= $test['id'].$pregunta['data']->id ?>" id="v_<?= $test['id'].$pregunta['data']->id ?>" value="1"/> Verdadero</td>

				</tr>
				<tr>

					<td valign="middle"><input type="radio" name="vof_<?= $test['id'].$pregunta['data']->id ?>" id="f_<?= $test['id'].$pregunta['data']->id ?>" value="2"/> Falso</td>
				
				</tr>

			</table>
						

		@elseif ($pregunta["data"]->tipo === 2)
		    
			<table width="100%" >
				
				<tr>

						<td>

								<ul class="eva-parejas">
									@foreach($pregunta["alternativas"]["col1"] as $val)

										<li>
											<select class="eva-RespEmpareja{{ $pregunta['data']->id }}" id="{{ $val->id }}">
													<option value="0">--</option>
												@foreach($pregunta["alternativas"]["col2"] as $val2)
													<option value="{{ $val2->id }}">{{ $val2->orden }}</option>
												@endforeach

											</select>
											<span id="{{ $val->id }}">{{ $val->texto }}</span>

										</li>

									@endforeach
								</ul>

						</td>
						<td>

								<ul class="eva-parejas">
									@foreach($pregunta["alternativas"]["col2"] as $val)

										<li>

											{{ $val->orden }}) <span id="{{ $val->id }}">{{ $val->texto }}</span>

										</li>

									@endforeach
								</ul>

						</td>
				</tr>

			</table>

		@elseif ($pregunta["data"]->tipo === 3)
		    
			<table width="100%" >

				<tr>
                    
						<textarea rows="10" cols="80" id="des_<?= $test['id'].$pregunta['data']->id ?>" ></textarea>

				</tr>

			</table>

		@elseif ($pregunta["data"]->tipo === 4)
		    
			<table width="100%" >

				@foreach($pregunta["alternativas"] as $pos => $val)

				<tr>
					<td class="eva-letraAlternativa">{{ $val->letra }}) </td>
					<td class="eva-checkAlternativa">
					
						<input name="respAlt_{{ $test['id'] }}{{ $val->pregunta }}" type="radio" value="{{ $val->id }}"/> 

					</td>
					<td class="eva-textoAlternativa">{{ $val->texto }}</td>
				</tr>

				@endforeach

			</table>

		@elseif ($pregunta["data"]->tipo === 5)

			<table width="100%" >
				<tr>
                    
						<textarea rows="10" cols="80" id="cor_<?= $test['id'].$pregunta['data']->id ?>" ></textarea>

				</tr>
			</table>	

		@endif		

@elseif($seccion === 'recurso')

		@if (strtolower($val["recurso"]->archivo_extension) === 'jpg' or strtolower($val["recurso"]->archivo_extension) === 'png' or strtolower($val["recurso"]->archivo_extension) === 'bmp' or strtolower($val["recurso"]->archivo_extension) === 'gif')

			<img src='{{ $val["recurso"]->url }}'/> <!-- 1 - {{  $val["recurso"]->id  }} -->

		@elseif (strtolower($val["recurso"]->archivo_extension) === 'libro')		

			<a  href="{{ $val["recurso"]->url }}" target="_blank" >
				<img src="{{ URL_PLATAFORMA_PRODUCCION }}/home/recursos/css/img/recurso_pregunta.jpg"  width="160" height="30"/>	<!-- 2 - {{  $val["recurso"]->id  }} -->
			</a>

		@elseif (strtolower($val["recurso"]->archivo_extension) === 'url' or strtolower($val["recurso"]->archivo_extension) === 'doc' or strtolower($val["recurso"]->archivo_extension) === 'docx' or strtolower($val["recurso"]->archivo_extension) === 'xls' or strtolower($val["recurso"]->archivo_extension) === 'xlsx' or strtolower($val["recurso"]->archivo_extension) === 'ppt' or strtolower($val["recurso"]->archivo_extension) === 'pps' or strtolower($val["recurso"]->archivo_extension) === 'pptx' or strtolower($val["recurso"]->archivo_extension) === 'pdf')

			<a  href="{{ $val['recurso']->url }}" target="_blank" > <strong>Archivo adjunto </strong> <!-- 3 - {{  $val["recurso"]->id  }}</a> -->
		
		@elseif (strtolower($val["recurso"]->archivo_extension) === 'flv')
		
			<a  href="{{ URL_PLATAFORMA_PRODUCCION }}/home/recursos/view.php?id={{ $val['recurso']->id }}" target="_blank"  onclick="window.open(this.href, this.target, 'width=500,height=200'); return false;"> <strong> Archivo adjunto <!-- 4 - {{  $val["recurso"]->id  }} --></strong> </a>	
		
		@elseif (strtolower($val["recurso"]->archivo_extension) === 'mp3')

			<a  href="{{ URL_PLATAFORMA_PRODUCCION }}/home/recursos/view.php?id={{ $val['recurso']->id }}" target="_blank"  onclick="window.open(this.href, this.target, 'width=500,height=200'); return false;"> <strong> Archivo adjunto <!-- 5 - {{  $val["recurso"]->id  }} --><strong> </a>

		@else
		
			<a  href="{{ URL_PLATAFORMA_PRODUCCION }}/home/recursos/view.php?id={{ $val['recurso']->id }}" target="_blank"  onclick="window.open(this.href, this.target, 'width=500,height=200'); return false;"> <strong> Archivo adjunto <!-- 6 - {{  $val["recurso"]->id  }}--> </strong> </a>

		@endif

@elseif ($seccion === 'miniaturas')

	<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

		@foreach ($preguntas as $pos=>$val)
			
			<div class="btn-group" role="group" aria-label="First group">
		    
		    	    <button type="button" class="btn btn-default eva-btnMinPreg" id="eva-minPregNum{{ $val['data']->id }}">{{ $val["numero"] }}</button>
		    
		    </div>

		@endforeach
      
      
    </div>

@endif

