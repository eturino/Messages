<?php
/**
 * depende de EtuDev_Cookie_Helper
 *
 */
class EtuDev_Messages_Writer_Cookie implements EtuDev_Messages_Writer {

	protected $cookieName = 'app_messages';

	public function addMessage($type, $message) {
		$m      = array('level' => $type, 'msg' => $message);
		$msgs   = $this->getMessages(false);
		$msgs[] = $m;
		EtuDev_Cookie_Helper::setCookieLive($this->cookieName, json_encode($msgs), 0, '/');
	}

	public function getMessages($destroyAfterRead = true) {
		$a = array();
		$m = @$_COOKIE[$this->cookieName] = '';
		if ($m) {
			try {
				$a = json_decode($m);
			} catch (Exception $ex) {
				//TODO the exception
			}
		}

		if ($destroyAfterRead) {
			EtuDev_Cookie_Helper::deleteCookie($this->cookieName, '/');
		}

		return $a;
	}

}