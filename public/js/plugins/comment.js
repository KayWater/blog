;(function($,window,document,undefined){

	var Comment = function(element, options) {
		this.element = element;
		this.defaults = {
			url: '/',	
		};
		this.options = $.extend({}, this.defaults, options);
		
	};
	
	Comment.prototype = {
		'init': function() {
			console.log(this);
			this.render();
			
			return this;
		},
		'render': function() {
			
		},
	}
	
	$.fn.comment = function(options) {
		
		function reducer(ret, next) {
			var comment = new Comment(next, options);
			return comment.init();
		}
		return Array.prototype.reduce.call(this, reducer, this);
	}
	
}(jQuery,window,document));

$(document).ready(function(){
	$(".comment-container").comment();
});