<?php
/**
 * Content plugin for show a disclaimer, adult warning, age check or something
 * similar before users can view an article.
 *
 * @version		disclaimer.php, v1.9.3, rev. 299, Apr 2015.
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) Adonay R. M. All rights reserved.
 * @author		Adonay R. M. -> http://adonay.name/
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgContentDisclaimer extends JPlugin
{
	public function onContentPrepare( $context, &$row, &$params, $limitstart = 0 )
	{
		$doc = JFactory::getDocument();

		// cargar estilos
		$doc->addStyleSheet( "plugins/content/disclaimer/css/estilos.css" );

		// cargar jquery si es inferior a j3
		$parametros = $this->params;
		$librerias = $parametros->get ('librerias');

		if (version_compare( JVERSION, '3.0', '<' ) == 1)
		{ if ($librerias) $doc->addScript( "plugins/content/disclaimer/js/jquery.min.js" ); }
		else JHtml::_('jquery.framework');

		$doc->addScript( "plugins/content/disclaimer/js/scripts.js" );

		// duracion de la cookie
		$duracion = $parametros->get ('duracion');

		if (empty ($duracion) || $duracion == 0) $llamada = 'var dias;';
		else $llamada = 'var dias='.$duracion.';';

		$doc->addScriptDeclaration ( $llamada );

		// opacidad de la mascara
		$opacidad = $parametros->get ('opacidad');

		if (empty ($opacidad)) $opacidad = '0.9';
		$setopacidad = 'var opacidad='.$opacidad.';';

		$doc->addScriptDeclaration ( $setopacidad );
	}

	public function onContentBeforeDisplay( $context, &$row, &$params )
	{
		// cargar mismo idioma que en backend
		$lang = JFactory::getLanguage();
		$lang->load('plg_content_disclaimer', JPATH_ADMINISTRATOR);

		// obtener parametros
		$parametros = $this->params;

		// internacionalizar plugin
		$aviso = JText::_('WARNING');
		$renuncia = JText::_('DEFAULT_DISCLAIMER');
		$entrar = JText::_('ENTER');
		$salir = JText::_('LEAVE');

		// texto de aviso + blinker
		$texto = $parametros->get ('texto');
		$muestraviso = $parametros->get ('muestraviso');
		$blinktexto = $parametros->get ('blinktexto');

		if (empty ($texto) || $texto == "\r\n") $texto = $renuncia;
		if (!empty ($blinktexto)) $aviso = $blinktexto;
		if (!$muestraviso) unset ($aviso);

		// texto de los botones
		$textentrar = $parametros->get ('textentrar');
		$textsalir = $parametros->get ('textsalir');

		if (empty ($textentrar)) $textentrar = $entrar;
		if (empty ($textsalir)) $textsalir = $salir;

		// averiguar ID del articulo actual
		$articuloid = (JRequest::getVar('option')==='com_content' && JRequest::getVar('view')==='article')? JRequest::getInt('id') : 0;
		$artomisiones = $parametros->get ('artomisiones');

		if (!empty ($artomisiones)) $artomision = explode (',', $artomisiones);
		else $artomision = array('696969696969');

		// color de fondo del popup
		$fondo = $parametros->get ('fondo');

		if (empty ($fondo) || $fondo === 0) $fondo = '#3D3D3D';

		// o color de fondo personalizado
		$micolor = $parametros->get ('micolor');

		if (!empty ($micolor)) $fondo = $micolor;

		// color del texto personalizado
		$colortexto = $parametros->get ('colortexto');

		if (empty ($colortexto)) $colortexto = '#FFFFFF';

		// alineacion del texto emergente
		$align = $parametros->get ('align');

		if (empty ($align) || $align == 0) $align = 'center';
		if ($align == 1) $align = 'justify';

		// imagen de fondo para el popup
		$imagen = $parametros->get ('imagen');

		if (empty ($imagen)) $imagen = 'url(\'plugins/content/disclaimer/images/disclaimer.png\') no-repeat scroll center center transparent';
		else $imagen = 'url(\''.$imagen.'\') no-repeat scroll center center transparent';

		// opacidad de la mascara
		$opacidad = $parametros->get ('opacidad');

		if (empty ($opacidad)) $opacidad = '0.9';

		// contenedor del html
		$contenido = '		<!-- Content Disclaimer - Adonay http://adonay.name/ -->
		<div id="popup">
		 <div id="jcdisclaimer" class="ventanuki" style="background-color: '.$fondo.';">
		  <div id="logopopup" style="background: '.$imagen.';"></div>
		  <h6 class="aviso" style="text-align: '.$align.'; color: '.$colortexto.';"><span>'.$aviso.' </span>'.$texto.'</h6>
		  <div id="botones">
		   <div><a href="#" id="mayor" class="jcdentrar readmore btn btn-primary button-primary readon">'.$textentrar.'</a></div>
		   <div><a href="http://adonay.name" id="menor" class="jcdsalir readmore btn button-default readon">'.$textsalir.'</a></div>
		  </div>
		 </div>
		 <div style="opacity: '.$opacidad.'" id="mascara"></div>
		</div>
		<!-- end Adonay http://adonay.name/ --> ';

		if (in_array ($articuloid, $artomision, false)) return;
		else return $contenido;
	}
}
?>