<?php
/**
 * File containing the ToolbarHorizontal class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki skin Chameleon.
 * The Chameleon skin is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup   Skins
 */

namespace skins\chameleon\components;

use Linker;

/**
 * ToolbarHorizontal class
 *
 * A horizontal toolbar containing standard sidebar items (toolbox, language links).
 *
 * The toolbar is an unordered list in a nav element: <nav role="navigation" id="p-tb" >
 *
 * @ingroup Skins
 */
class ToolbarHorizontal extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$skinTemplate = $this->getSkinTemplate();

		$ret = $this->indent() . '<!-- ' . htmlspecialchars( $skinTemplate->getMsg( 'toolbox' )->text() ) . '-->' .
			   $this->indent() . '<nav class="navbar navbar-default p-tb" id="p-tb" ' . Linker::tooltip( 'p-tb' ) . ' >' .
			   $this->indent( 1 ) . '<ul class="nav navbar-nav small">';

		// insert toolbox items
		// TODO: Do we need to care of dropdown menus here? E.g. RSS feeds? See SkinTemplateToolboxEnd.php:1485
		$this->indent( 1 );
		foreach ( $skinTemplate->getToolbox() as $key => $tbitem ) {
			$ret .= $this->indent() . $skinTemplate->makeListItem( $key, $tbitem );
		}

		ob_start();
		// We pass an extra 'true' at the end so extensions using BaseTemplateToolbox
		// can abort and avoid outputting double toolbox links
		wfRunHooks( 'SkinTemplateToolboxEnd', array( &$skinTemplate, true ) );
		$ret .= $this->indent() . ob_get_contents();
		ob_end_clean();

		// insert language links
		if ( $skinTemplate->data[ 'language_urls' ] ) {

			$ret .= $this->indent() . '<li class="dropdown dropup p-lang" id="p-lang" ' . Linker::tooltip( 'p-lang' ) . ' >' .
					$this->indent( 1 ) . '<a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">' .
					htmlspecialchars( $skinTemplate->getMsg( 'otherlanguages' )->text() ) . ' <b class="caret"></b>' . '</a>' .
					$this->indent() . '<ul class="dropdown-menu" >';

			$this->indent( 1 );
			foreach ( $skinTemplate->data[ 'language_urls' ] as $key => $langlink ) {
				$ret .= $this->indent() . $skinTemplate->makeListItem( $key, $langlink, array( 'link-class' => 'small' ) );
			}

			$ret .= $this->indent( -1 ) . '</ul>' .
					$this->indent( -1 ) . '</li>';
		}

		$ret .= $this->indent( -1 ) . '</ul>' .
				$this->indent( -1 ) . '</nav>' . "\n";

		return $ret;
	}
}
