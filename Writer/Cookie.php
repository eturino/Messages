<?php
/**
 * depende de EtuDev_Cookie_Helper
 */
class EtuDev_Messages_Writer_Cookie implements EtuDev_Messages_Writer {

	protected $cookieName = 'app_messages';

	public function addMessage($type, $message) {
		$m      = array('level' => $type, 'msg' => base64_encode(json_encode($message)));
		$msgs   = $this->getMessages(false, false);
		$msgs[] = $m;
		EtuDev_Cookie_Helper::setCookieLive($this->cookieName, json_encode($msgs), 0, '/');
	}

	public function getMessages($destroyAfterRead = true, $decode = true) {
		$a = array();
		$m = @$_COOKIE[$this->cookieName] ? : '{}';
		if ($m) {
			try {
				if ($decode) {
					$aux = json_decode($m, true);

					foreach ($aux as $k => $v) {
						$v['msg'] = json_decode(base64_decode($v['msg']));
						$a[$k]    = $v;
					}
				} else {
					$a = json_decode($m, true);
				}
			} catch (Exception $ex) {
//				TODO the exception
				throw $ex;
			}
		}

		if ($destroyAfterRead) {
			EtuDev_Cookie_Helper::deleteCookie($this->cookieName, '/');
		}

		return $a ? : array();
	}

}