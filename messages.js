/**
 * client library
 * @constructor
 */
function MessagesController() {
	this.cookie_name = 'app_messages';
	this.reviewed = null;
	this.messages = {};
}


/**
 * returns the singleton MessagesController
 * @returns MessagesController
 */
MessagesController.getInstance = function () {
	if (MessagesController._inst) {
		return MessagesController._inst;
	}

	MessagesController._inst = new MessagesController();
	return MessagesController._inst;
};

/**
 *
 * @param {String} msgsString string with the messages codified in JSON, if empty it will use the cookie
 * @return MessagesController
 */
MessagesController.prototype.loadMessages = function (msgsString) {
	msgsString = msgsString || $.cookie(this.cookie_name);
	var messages = {};
	try {
		if (msgsString) {
			messages = $.parseJSON(msgsString);
		}
	} catch (anyex) {
//		alert(anyex);
	}

	this.messages = messages;
	return this;
};

/**
 *
 * @param type
 * @return {String}
 */
MessagesController.prototype.getClassByLevel = function (type) {
	var cl = 'message alert alert-block ';
	switch (type) {
		case 'error':
			cl += 'alert-error';
			break;
		case 'success':
			cl += 'alert-success';
			break;
		case 'notice':
		case 'info':
		case 'infoaction':
			cl += 'alert-error';
			break;
	}

	return cl;
};

MessagesController.prototype.createMsgPrint = function (msg) {
	var cl = this.getClassByLevel(msg.level);
	var str = decodeURIComponent(msg.msg);
	return '<div class="' + cl + '"><a class="close" data-dismiss="alert" href="#">×</a>' + str + '</div>';
};

MessagesController.prototype.createPrint = function () {
	var html = '';
	for (var x in this.messages) {
		if (this.messages.hasOwnProperty(x)) {
			html += this.createMsgPrint(this.messages[x]);
		}
	}
	return html;
};


MessagesController.prototype.render = function () {
	$('.messages').html(this.createPrint()).show();
};

/**
 * loads the messages from cookie if there are no msgs yet; after that it renders them if there are any
 * @return {*}
 */
MessagesController.prototype.run = function () {
	if (!this.messages.length) {
		this.loadMessages();
	}

	if (this.messages.length) {
		this.render();
	}

	return this;
};

MessagesController.prototype.deleteCookie = function () {
	$.cookie(this.cookie_name, null);
};
