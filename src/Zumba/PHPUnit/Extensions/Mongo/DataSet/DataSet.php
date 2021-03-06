<?php

namespace Zumba\PHPUnit\Extensions\Mongo\DataSet;
use \Zumba\PHPUnit\Extensions\Mongo\Client\Connector;

class DataSet {

	/**
	 * Fixture data.
	 *
	 * [collection name] => [][data]
	 *
	 * @var array
	 */
	protected $fixture = array();

	/**
	 * Connection object.
	 *
	 * @var Zumba\PHPUnit\Extensions\Mongo\Client\Connector
	 */
	protected $connection;

	/**
	 * Constructor.
	 *
	 * @param Zumba\PHPUnit\Extensions\Mongo\Client\Connector
	 */
	public function __construct(Connector $connection) {
		$this->connection = $connection;
	}

	/**
	 * Sets up the fixture data.
	 *
	 * see $this->fixture
	 *
	 * @param array $data
	 * @return Zumba\PHPUnit\Extensions\Mongo\DataSet\DataSet
	 */
	public function setFixture(array $data) {
		$this->fixture = $data;
		return $this;
	}

	/**
	 * Drops all collections specified in the fixture keys.
	 *
	 * @return Zumba\PHPUnit\Extensions\Mongo\DataSet\DataSet
	 */
	public function dropAllCollections() {
		foreach (array_keys($this->fixture) as $collection) {
			$this->connection->collection($collection)->drop();
		}
		return $this;
	}

	/**
	 * Creates all collections with data from the fixture.
	 *
	 * @return Zumba\PHPUnit\Extensions\Mongo\DataSet\DataSet
	 */
	public function buildCollections() {
		foreach ($this->fixture as $collection => $data) {
			foreach ($data as $entry) {
				$this->connection->collection($collection)->insert($entry);
			}
		}
		return $this;
	}

}