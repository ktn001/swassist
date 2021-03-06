<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

try {
	require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
	include_file('core', 'authentification', 'php');

	if (!isConnect('admin')) {
		throw new Exception(__('401 - Accès non autorisé', __FILE__));
	}

	if (init('action') == 'importEqLogic') {

		$id = init("id");
		$swassist = swassist::byid($id);
		if (!is_object($swassist)) {
			throw new Exception(__("Equipement swassist introuvable : ",__FILE__) . $id);
		}
		if ($swassist->getEqType_name() != "swassist") {
			throw new Exception(__("Function appelée pour un eqLogic qui n'est pas de type swassist mais ",__FILE__) . $swassist->getEqType_name());
		}

		$eqLogicToImportId = init('eqLogicToImport');
		$cmdEtat = init('cmdEtat');
		$cmdOn = init('cmdOn');
		$cmdOff = init('cmdOff');
		$creerTentatives = init('CreerTentatives');
		$creerStatut = init('CreerStatut');
		$swassist->importEqLogic( $eqLogicToImportId, $cmdEtat, $cmdOn, $cmdOff, $creerTentatives, $creerStatut );

		ajax::success();
	}

	throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
	/*     * *********Catch exeption*************** */
} catch (Exception $e) {
	ajax::error(displayException($e), $e->getCode());
}
?>
