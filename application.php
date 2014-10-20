<?php
/**
 * ownCloud - Feed Central app
 *
 * @author Lukas Reschke
 * @copyright 2014 Lukas Reschke <lukas@statuscode.ch>
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

use OCA\FeedCentral\Utility\RSS;
use \OCP\AppFramework\App;
use OC\AppFramework\Utility\SimpleContainer;
use \OCA\FeedCentral\Controller\FeedController;
use \OCA\News\AppInfo\Application as News;

/**
 * Class Application
 *
 * @package OCA\FeedCentral
 */
class Application extends App {

	/**
	 * @param array $urlParams
	 */
	public function __construct (array $urlParams=array()) {
		parent::__construct('feedcentral', $urlParams);

		$container = $this->getContainer();

		$container->registerService('NewsContainer', function() {
			return new News();
		});

		/**
		 * Controllers
		 */
		$container->registerService('FeedController', function(SimpleContainer $c) {
			return new FeedController(
				$c->query('AppName'),
				$c->query('Request'),
				$c->query('NewsContainer')->getContainer()['ItemService'],
				new RSS()
			);
		});


	}


}