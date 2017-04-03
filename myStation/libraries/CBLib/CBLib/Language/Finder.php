<?php
/**
* CBLib, Community Builder Library(TM)
* @version $Id: 09.06.13 01:29 $
* @package ${NAMESPACE}
* @copyright (C) 2004-2016 www.joomlapolis.com / Lightning MultiCom SA - and its licensors, all rights reserved
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

namespace CBLib\Language;

defined('CBLIB') or die();

/**
 * CBLib\Language\Finder (L like Language) Class implementation
 *
 */
class Finder
{

	/**
	 * Outputs an XML field type for searching language keys and text
	 *
	 * @return string
	 */
	public static function input()
	{
		global $_CB_framework;

		static $JS_LOADED	=	0;

		if ( ! $JS_LOADED++ ) {
			$js				=	"var cbLangFinderRequest = null;"
							.	"var cbLangFinderPrevious = null;"
							.	"var cbLangFinderHandler = function() {"
							.		"var finder = $( this ).closest( '.cbLanguageFinder' );"
							.		"var search = finder.find( '.cbLanguageFinderSearch' ).val();"
							.		"var results = finder.find( '.cbLanguageFinderResults' );"
							.		"if ( ( cbLangFinderRequest == null ) && search && ( cbLangFinderPrevious != search ) ) {"
							.			"cbLangFinderPrevious = search;"
							.			"cbLangFinderRequest = $.ajax({"
							.				"url: '" . addslashes( $_CB_framework->backendViewUrl( 'languagefinder', false, array(), 'raw' ) ) . "',"
							.				"type: 'GET',"
							.				"dataType: 'html',"
							.				"cache: false,"
							.				"data: {"
							.					"search: search"
							.				"},"
							.				"beforeSend: function( jqXHR, textStatus, errorThrown ) {"
							.					"finder.find( '.cbLanguageFinderLoading' ).removeClass( 'hidden' );"
							.					"results.hide();"
							.				"}"
							.			"}).done( function( data, textStatus, jqXHR ) {"
							.				"results.html( data );"
							.				"results.fadeIn( 'slow' );"
							.				"results.find( '.cbMoreLess' ).cbmoreless();"
							.				"results.find( '.cbLanguageFinderResult' ).on( 'click', function() {"
							.					"var result = $( this );"
							.					"$( '.cbLanguageOverrideKey' ).each( function() {"
							.						"if ( $( this ).val() == '' ) {"
							.							"$( this ).val( result.find( '.cbLanguageFinderResultKey' ).html() );"
							.							"$( this ).closest( '.cbLanguageOverride' ).find( '.cbLanguageOverrideText' ).val( result.find( '.cbLanguageFinderResultText' ).html() ).focus();"
							.						"}"
							.					"});"
							.				"});"
							.			"}).always( function( data, textStatus, jqXHR ) {"
							.				"cbLangFinderRequest = null;"
							.				"finder.find( '.cbLanguageFinderLoading' ).addClass( 'hidden' );"
							.			"});"
							.		"}"
							.	"};"
							.	"$( '.cbLanguageFinderSearch' ).on( 'keypress', function( e ) {"
							.		"if ( e.which == 13 ) {"
							.			"cbLangFinderHandler.call( this );"
							.		"}"
							.	"});"
							.	"$( '.cbLanguageFinderButton' ).on( 'click', cbLangFinderHandler );";

			$_CB_framework->outputCbJQuery( $js, 'cbmoreless' );
		}

		$return				=	'<div class="cbLanguageFinder row">'
							.		'<div class="col-sm-4">'
							.			'<div class="form-group input-group">'
							.				'<input type="text" class="cbLanguageFinderSearch form-control input-block" placeholder="' . htmlspecialchars( CBTxt::T( 'Search Language Keys and Text...' ) ) . '" />'
							.				'<span class="input-group-btn">'
							.					'<button class="cbLanguageFinderButton btn btn-primary" type="button">' . CBTxt::T( 'Find' ) . '</button>'
							.				'</span>'
							.			'</div>'
							.		'</div>'
							.		'<div class="col-sm-8">'
							.			'<span class="cbLanguageFinderLoading fa fa-spinner fa-pulse hidden"></span>'
							.			'<div class="cbLanguageFinderResults"></div>'
							.		'</div>'
							.	'</div>';

		return $return;
	}

	/**
	 * Searches available language strings for a matching key or text
	 *
	 * @param string $search
	 * @return string
	 */
	public static function find( $search )
	{
		global $_PLUGINS;

		if ( ! $search ) {
			return CBTxt::T( 'Nothing to search for.' );
		}

		// Set language to default:
		$langCache			=	CBTxt::setLanguage( null );

		// Load core language files:
		cbimport( 'language.all' );

		// Load plugin language files:
		$_PLUGINS->loadPluginGroup( 'users' );

		// Grab all the default language keys and text:
		$languageStrings	=	CBTxt::getStrings();

		// Reset language back to original:
		CBTxt::setLanguage( $langCache );

		$return				=	null;

		foreach ( $languageStrings as $key => $text ) {
			if ( ( stripos( $key, $search ) !== false ) || ( stripos( $text, $search ) !== false ) ) {
				$return		.=	'<div class="cbLanguageFinderResult panel panel-default" style="cursor: pointer;">'
							.		'<div class="cbLanguageFinderResultKey panel-heading text-wrapall">' . htmlspecialchars( $key ) . '</div>'
							.		'<div class="cbLanguageFinderResultText panel-body text-wrap">' . htmlspecialchars( $text ) . '</div>'
							.	'</div>';
			}
		}

		if ( $return ) {
			$return			=	'<div class="cbMoreLess" data-cbmoreless-stepped="true" data-cbmoreless-height="400">'
							.		'<div class="cbMoreLessContent">'
							.			$return
							.		'</div>'
							.		'<div class="cbMoreLessOpen fade-edge hidden">'
							.			'<a href="javascript: void(0);" class="cbMoreLessButton">' . CBTxt::T( 'See More' ) . '</a>'
							.		'</div>'
							.	'</div>';

			return $return;
		}

		return CBTxt::T( 'No language key or string matches found.' );
	}
}