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

namespace OCA\FeedCentral\Controller;

use \OCA\News\Db\FeedType;

use \OCA\FeedCentral\Utility\RSS;
use OCA\News\Http\TextResponse;
use OCA\News\Service\ItemService;
use \OCP\AppFramework\Controller;
use OCP\IRequest;

/**
 * Class FeedController
 *
 * @package OCA\FeedCentral\Controller
 */
class FeedController extends Controller {

	/** @var ItemService */
	private $itemService;
	/** @var RSS */
	private $rss;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param ItemService $itemService
	 * @param RSS $rss
	 */
	public function __construct($appName,
								IRequest $request,
								ItemService $itemService,
								RSS $rss){
		parent::__construct($appName, $request);
		$this->itemService = $itemService;
		$this->rss = $rss;
	}


	/**
	 * @param $userId
	 * @PublicPage
	 * @NoCSRFRequired
	 * @return TextResponse
	 */
	public function starred($userId) {
		$items = $this->itemService->findAll(0, FeedType::STARRED, 100, 0, true, false, $userId);

		$title = 'ownCloud News Feed';
		$desc = 'starred items of ' . $userId;

		$rss = $this->rss->generateRSS($items, $title, $desc, $this->getCurrentURL());

		return new TextResponse($rss, 'xml');
	}

	/**
	 * @param $userId
	 * @PublicPage
	 * @NoCSRFRequired
	 * @return TextResponse
	 */
	public function all($userId) {
		$items = $this->itemService->findAll(0, FeedType::SUBSCRIPTIONS, 100, 0, true, false, $userId);

		$title = 'ownCloud News Feed';
		$desc = 'all items of ' . $userId;

		$rss = $this->rss->generateRSS($items, $title, $desc, $this->getCurrentURL());

		return new TextResponse($rss, 'xml');
	}

	/**
	 * Get the current URL
	 * @return string
	 */
	private function getCurrentURL() {
		$protocol = stripos($this->request->server['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
		return $protocol . '://' . $this->request->server['SERVER_NAME'] .  $this->request->server['REQUEST_URI'];
	}
}
