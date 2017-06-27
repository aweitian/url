<?php
class UrlTest extends PHPUnit_Framework_TestCase {
	public function testPre() {

		$url = new \Tian\Url('http://www.baidu.com/p1/p2/m1/m2/c/a/i1/i2/?a=b');
		$url->setPath('/p/q/hk');
		$url->setQuery('c', 'gg');
		$url->setQuery('page', 1);
		$url->setQuery('h', 1);
		$this->assertEquals('http://www.baidu.com/p/q/hk?a=b&c=gg&page=1&h=1', $url->toString(false));
		$this->assertEquals('/p/q/hk?a=b&c=gg&page=1&h=1', $url->toString(true));
	}
}

