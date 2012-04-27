<?php

class EtuDev_Messages_Manager {

	/**
	 * @var EtuDev_Messages_Manager
	 */
	static protected $instance;

	static public function getInstance() {
		if (!static::$instance) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	public function __construct() {
		$this->writer = new EtuDev_Messages_Writer_Cookie();
	}

	/**
	 * @var EtuDev_Messages_Writer
	 */
	protected $writer;

	/**
	 * @param string      $type error|success|notice
	 * @param string      $msg
	 *
	 * @return bool|null
	 */
	public function addMessage($type, $msg) {
		$this->getWriter()->addMessage($type, $msg);
	}

	function getMessages($delete_messages = true) {
		return $this->getWriter()->getMessages($delete_messages);
	}


	/**
	 * @param EtuDev_Messages_Writer $writer
	 *
	 * @return EtuDev_Messages_Manager
	 */
	public function setWriter(EtuDev_Messages_Writer $writer) {
		$this->writer = $writer;
		return $this;
	}

	/**
	 * @return EtuDev_Messages_Writer
	 */
	public function getWriter() {
		return $this->writer;
	}

}