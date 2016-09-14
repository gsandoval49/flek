app.constant("MAIL_ENDPOINT", "php/apis/mail/");
app.service("mailService", function($http, MAIL_ENDPOINT) {

	function getUrl() {
		return(MAIL_ENDPOINT);
	}

	function getUrlForMailSenderId(mailSenderId) {
		return(getUrl() + mailSenderId);
	}

	function getUrlForMailReceiverId(mailReceiverId) {
		return(getUrl() + MailReceiverId);
	}

	this.fetchMail = function() {
	 return($http.get(getUrl()));
	 };

	this.fetchMailByMailSenderId = function(mailSenderId) {
		return($http.get(getUrl() + "?mailSenderId=" + mailSenderId));
	};

	this.fetchMailByMailReceiverId = function(mailReceiverId) {
		return($http.get(getUrl() + "?mailReceiverId=" + mailReceiverId));
	};

	this.create = function(mailSenderId, mailReceiverId) {
		return($http.post(getUrlforId(mailSenderId, mailReceiverId)));
	};

	this.destroy = function(mailSenderId, mailReceiverId) {
		return($http.delete(getUrlforId(mailSenderId, mailReceiverId)));
	};

});