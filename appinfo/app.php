<?php

/**
 * ownCloud - Feed Central app
 *
 * @author Bernhard Posselt
 * @copyright 2013 Bernhard Posselt <nukeawhale@gmail.com>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


namespace OCA\FeedCentral;

use \OCA\AppFramework\Core\API;


// dont break owncloud when the appframework is not enabled
if(\OCP\App::isEnabled('appframework') && \OCP\App::isEnabled('news')){

	$api = new API('feedcentral');

	// uncomment the next line to activate the admin interface
	//$api->registerAdmin('admin/settings');

	// uncomment this when you decide to add a configurable ui
	/*$api->addNavigationEntry(array(

		// the string under which your app will be referenced in owncloud
		'id' => $api->getAppName('feedcentral'),

		// sorting weight for the navigation. The higher the number, the higher
		// will it be listed in the navigation
		'order' => 10,

		// the route that will be shown on startup
		'href' => $api->linkToRoute('feedcentral_index'),

		// the icon that will be shown in the navigation
		// this file needs to exist in img/example.png
		'icon' => $api->imagePath('icon.svg'),

		// the title of your application. This will be used in the
		// navigation or on the settings page of your app
		'name' => $api->getTrans()->t('Feed Central')

	));*/

} else {
	$msg = 'Can not enable the app because the App Framework app or the News app is disabled';
	\OCP\Util::writeLog('feedcentral', $msg, \OCP\Util::ERROR);
}
