<?php
/**
 * @copyright 2016 Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace OC\Files\SimpleFS;

use OCP\Files\Folder;
use OCP\Files\Node;
use OCP\Files\SimpleFS\ISimpleRoot;

class SimpleRoot implements ISimpleRoot  {

	/** @var Folder */
	protected $folder;

	/**
	 * Root constructor.
	 *
	 * @param Folder $folder
	 */
	public function __construct(Folder $folder) {
		$this->folder = $folder;
	}

	/**
	 * @inheritdoc
	 */
	public function getFolder($name) {
		$node = $this->folder->get($name);

		/** @var Folder $node */
		return new SimpleFolder($node);
	}

	/**
	 * @inheritdoc
	 */
	public function newFolder($name) {
		$folder = $this->folder->newFolder($name);

		return new SimpleFolder($folder);
	}

	public function getDirectoryListing() {
		$listing = $this->folder->getDirectoryListing();

		$fileListing = array_map(function(Node $file) {
			return new SimpleFolder($file);
		}, $listing);

		return $fileListing;
	}
}
