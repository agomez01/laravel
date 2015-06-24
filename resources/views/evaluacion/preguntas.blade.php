@if ($pregunta["data"]->tipo === 1)
    
    <table class="" width="100%">
			<tr>
				<td>
					<table width="100%" >
						<tr>
							<td valign="middle"><input type="radio" name="vof_<?= $test['id'].$pregunta['data']->id ?>" id="v_<?= $test['id'].$pregunta['data']->id ?>" value="1"/> Verdadero</td>
						</tr>
						<tr>
							<td valign="middle"><input type="radio" name="vof_<?= $test['id'].$pregunta['data']->id ?>" id="f_<?= $test['id'].$pregunta['data']->id ?>" value="2"/> Falso</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

@elseif ($pregunta["data"]->tipo === 2)
    Pregunta de emparejamiento
@elseif ($pregunta["data"]->tipo === 3)
    
	<table class="body_pregunta" width="100%">
			<tr>
				<td>
					<table width="100%" >
						<tr>
                            
								<textarea rows="10" cols="80" id="des_<?= $test['id'].$pregunta['data']->id ?>" ></textarea>

						</tr>
					</table>					
				</td>
			</tr>
		</table>

@elseif ($pregunta["data"]->tipo === 4)
    Pregunta de Alternativas
@elseif ($pregunta["data"]->tipo === 5)

		<table class="body_pregunta" width="100%">
			<tr>
				<td>
					<table width="100%" >
						<tr>
                            
								<textarea rows="10" cols="80" id="cor_<?= $test['id'].$pregunta['data']->id ?>" ></textarea>

						</tr>
					</table>					
				</td>
			</tr>
		</table>

@endif