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


namespace OCA\FeedCentral\Utility;

class RSS {


	public function generateRSS(array $items, $title, $description, $link) {

		$document = new \DOMDocument('1.0', 'UTF-8');
		$document->formatOutput = true;

		$rss = $document->createElement("rss");
		$rss->setAttribute('version', '2.0');
		$document->appendChild($rss);

		$channel = $rss->appendChild($document->createElement("channel"));

		$linkElement = $document->createElement('link');
		$linkElement->appendChild($document->createTextNode($link));
		$channel->appendChild($linkElement);

		$descriptionElement = $document->createElement('description');
		$descriptionElement->appendChild($document->createTextNode($description));
		$channel->appendChild($descriptionElement);

		$titleElement = $document->createElement('title');
		$titleElement->appendChild($document->createTextNode($title));
		$channel->appendChild($titleElement);

		$this->createItems($document, $channel, $items);

		return $document->saveXML();
	}


	private function createItems($document, $channel, $items) {
		foreach ($items as $item) {
			$itemElement = $document->createElement('item');

			$titleElement = $document->createElement('title');
			$titleElement->appendChild($document->createTextNode($item->getTitle()));
			$itemElement->appendChild($titleElement);

			$descriptionElement = $document->createElement('description');
			$descriptionElement->appendChild($document->createTextNode($item->getBody()));
			$itemElement->appendChild($descriptionElement);

			$linkElement = $document->createElement('link');
			$linkElement->appendChild($document->createTextNode($item->getUrl()));
			$itemElement->appendChild($linkElement);

			$guidElement = $document->createElement('guid');
			$guidElement->appendChild($document->createTextNode($item->getGuid()));
			$itemElement->appendChild($guidElement);

			$formatedDate = date('r', $item->getPubDate());
			$pubDateElement = $document->createElement('pubDate');
			$pubDateElement->appendChild($document->createTextNode($formatedDate));
			$itemElement->appendChild($pubDateElement);

			$channel->appendChild($itemElement);
		}
	}

}
