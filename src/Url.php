<?php

/**
 * @author:awei.tian
 * @date:2013-12-17
 * @functions:对QUERY部分数组化操作
 * 其它部分直接设置获取
 * scheme - e.g. http
 * host 
 * port
 * user
 * pass
 * path
 * query - after the question mark ?
 * fragment - after the hashmark #
 */
namespace Tian;

class Url {
	private $part;
	// true为返回相对，false绝对
	private $retMode = true;
	private $queryArr = array ();
	private $scheme = NULL;
	private $host = NULL;
	private $port = NULL;
	private $user = NULL;
	private $pass = NULL;
	private $path = NULL;
	private $query = NULL;
	private $fragment = NULL;
	
	/**
	 *
	 * @param string $url        	
	 */
	public function __construct($url) {
		$this->part = array (
				"scheme",
				"host",
				"port",
				"user",
				"pass",
				"path",
				"query",
				"fragment" 
		);
		$urlArr = parse_url ( $url );
		if ($urlArr === false) {
			return;
		}
		foreach ( $this->part as $p ) {
			if (isset ( $urlArr [$p] )) {
				if ($p == "query") {
					parse_str ( $urlArr ["query"], $this->queryArr );
				}
				$this->{$p} = $urlArr [$p];
			}
		}
	}
	/**
	 * true返回相对URL
	 *
	 * @param bool $v        	
	 * @return \Tian\Url
	 */
	public function setReturnMode($v) {
		$this->retMode = ! ! $v;
		return $this;
	}
	/**
	 *
	 * @param string $v        	
	 * @return \Tian\Url
	 */
	public function setScheme($v) {
		$this->scheme = $v;
		return $this;
	}
	/**
	 *
	 * @param string $v        	
	 * @return \Tian\Url
	 */
	public function setHost($v) {
		$this->host = $v;
		return $this;
	}
	/**
	 *
	 * @param string $v        	
	 * @return \Tian\Url
	 */
	public function setUser($v) {
		$this->user = $v;
		return $this;
	}
	/**
	 *
	 * @param string $v        	
	 * @return \Tian\Url
	 */
	public function setPass($v) {
		$this->pass = $v;
		return $this;
	}
	/**
	 *
	 * @param string $v        	
	 * @return \Tian\Url
	 */
	public function setPath($v) {
		$this->path = $v;
		return $this;
	}
	/**
	 *
	 * @param string $v        	
	 * @return \Tian\Url
	 */
	public function setFragment($v) {
		$this->fragment = $v;
		return $this;
	}
	/**
	 *
	 * @param string $key        	
	 * @param mixed $val        	
	 * @return \Tian\Url
	 */
	public function setQuery($key, $val) {
		$this->queryArr [$key] = $val;
		$this->query = http_build_query ( $this->queryArr );
		return $this;
	}
	/**
	 *
	 * @return string
	 */
	public function getScheme() {
		return $this->scheme;
	}
	/**
	 *
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}
	/**
	 *
	 * @return string
	 */
	public function getUser() {
		return $this->user;
	}
	/**
	 *
	 * @return string
	 */
	public function getPass() {
		return $this->pass;
	}
	/**
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}
	/**
	 *
	 * @return string
	 */
	public function getFragment() {
		return $this->fragment;
	}
	/**
	 * 不存在返回NULL
	 *
	 * @param string $key        	
	 * @return string | NULL
	 *        
	 */
	public function getQuery($key) {
		if (isset ( $this->queryArr [$key] ))
			return $this->queryArr [$key];
		return null;
	}
	/**
	 *
	 * @param string $key        	
	 * @return \Tian\Url
	 */
	public function removeQuery($key) {
		parse_str ( $key, $this->queryArr );
		if (array_key_exists ( $key, $this->queryArr ))
			unset ( $this->queryArr [$key] );
		$this->query = http_build_query ( $this->queryArr );
		return $this;
	}
	/**
	 *
	 * @return string
	 */
	public function __toString() {
		$url = "";
		if (false === $this->retMode) {
			if (! is_null ( $this->host )) {
				if (! is_null ( $this->scheme )) {
					$url .= $this->scheme . ":";
				}
				$url .= "//";
				if (! is_null ( $this->user )) {
					$url .= $this->user;
					if (! is_null ( $this->pass )) {
						$url .= ":" . $this->pass;
					}
					$url .= "@";
				}
				$url .= $this->host;
				if (! is_null ( $this->port )) {
					$url .= ":" . $this->port;
				}
			}
		}
		if (! is_null ( $this->path )) {
			$url .= $this->path;
		}
		if (! is_null ( $this->query )) {
			$url .= "?" . $this->query;
		}
		if (! is_null ( $this->fragment )) {
			$url .= "#" . $this->fragment;
		}
		return $url;
	}
	/**
	 * 以STRING返回
	 * true返回相对URL
	 *
	 * @return string
	 */
	public function toString($returnMod = null) {
		if (is_bool ( $returnMod )) {
			$this->setReturnMode ( $returnMod );
		}
		return $this . "";
	}
}