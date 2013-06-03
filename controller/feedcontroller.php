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

use \OCA\AppFramework\Controller\Controller;
use \OCA\AppFramework\Core\API;
use \OCA\AppFramework\Http\Request;
use \OCA\AppFramework\Http\TextResponse;

use \OCA\News\BusinessLayer\ItemBusinessLayer;
use \OCA\News\Db\FeedType;

use \OCA\FeedCentral\Utility\RSS;

class FeedController extends Controller {

	private $itemBusinessLayer;
	private $rss;

	public function __construct(API $api, Request $request,
	                            ItemBusinessLayer $itemBusinessLayer,
	                            RSS $rss){
		parent::__construct($api, $request);
		$this->itemBusinessLayer = $itemBusinessLayer;
		$this->rss = $rss;
	}


	/**
	 * @IsAdminExemption
	 * @IsSubAdminExemption
	 * @IsLoggedInExemption
	 * @CSRFExemption
	 */
	public function starred() {
		$userId = $this->params('userId');

		$items = $this->itemBusinessLayer->findAll(
			0, FeedType::STARRED, 100, 0, true,	$userId
		);

		$title = 'ownCloud News Feed';
		$desc = 'starred items of ' . $userId;
		$req = $this->request;
		$https = isset($req->server['HTTPS']) ? 'https' : 'http';
		$link = $https . '://' .
			$req->server['SERVER_NAME'] .
			$req->server['REQUEST_URI'];

		$rss = $this->rss->generateRSS($items, $title, $desc, $link);

		return new TextResponse($rss, 'xml');
	}


}
