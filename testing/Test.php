<?php


use PHPUnit\Framework\TestCase;

class Test extends TestCase {

	public function testSum() : int {
		$this ->assertSame(11, $this->testSum(), "This is the expacted value");

		return $this;
	}

}
