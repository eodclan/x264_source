	(function($){
	
		var TopMenu = (function() {
		
			function TopMenu(ele) {
				var self = this;
				this.ele = $(ele);
				this.sections = [];
				this.active = false;
				this.searchBox = null;
				this.ele.find('section').each(function(i,e){
					self.sections.push(new TopMenu.Section(e, self));
				});
				this.ele.click(function(e){
					self.click(e);
				});
				$('body, html').click(function(){
					self.clean();
				});
			}
			
			TopMenu.prototype = {
				click: function(e){
					e.stopPropagation();
				},
				clean: function(){
					this.active = false;
					this.sections.forEach(function(e,i){
						e.active = false;
					});
				}
			}
			
			return TopMenu;
			
		})();
		
		TopMenu.Section = (function(){
			
			function Section(ele, parent) {
				var self = this;
				this.ele = $(ele);
				this.parent = parent;
				this.items = [];
				this.ele.find('a').each(function(i,e){
					self.items.push(new TopMenu.Item(e, self));
				});
				this.ele.find('form').last().each(function(i,e){
					self.parent.searchBox = new TopMenu.SearchBox(e,self.parent);
				});
				this.ele.click(function(e){
					self.click(e);
				});
				this.ele.hover(function(e){
					if (self.parent.active && !self.active) {
						self.parent.clean();
						self.active = true;
					}
				}, function(e){
					// hover out
				});
			}
			
			Section.prototype = {

				set active(bool) {
					if (bool) {
						this.parent.active = true;
						this.ele.addClass('active');
					} else {
						this.parent.active = false;
						this.ele.removeClass('active');
						this.items.forEach(function(e,i){
							e.active = false;
						});
					}
				},
				
				get active() {
					return this.ele.hasClass('active');
				},

				click: function(e, passive){
					if (this.active) {
						if (e.target == this.ele.find('.title')[0])
							this.active = false;
					} else {
						this.parent.clean();
						this.active = !this.active;
					}
				}
			}
			
			return Section;
			
		})();
		
		TopMenu.Item = (function(){
			
			function Item(ele, parent){
				var self = this;
				this.ele = $(ele);
				this.parent = parent;
				this.panel = null;
				if (this.ele.next().hasClass('panel')) {
					this.panel = this.ele.next();
				}
				this.ele.hover(function(e){
					if (e.target === self.ele[0]) {
						self.parent.items.forEach(function(item){
							if (item.ele.parent()[0] === self.ele.parent()[0]) {
								item.active = false;
							}
						});
						self.active = true;
					}
				}, function(e){
					// hover out
				});
			}
			
			Item.prototype = {
				set active(bool) {
					if (bool) {
						this.ele.addClass('active');
						if (this.panel) {
							this.panel.show();
						}
					} else {
						this.ele.removeClass('active');
						if (this.panel) {
							this.panel.hide().find('a.active').removeClass('active');
							this.panel.find('.panel').hide();
						}
					}
				},
				
				get active() {
					return this.ele.hasClass('active');
				}
			};
			
			return Item;
			
		})();
		
		TopMenu.SearchBox = (function(){
			
			function SearchBox(ele, parent){
				var self = this;
				this.ele = $(ele);
				this.parent = parent;
				this.items = [];
				this.ele.find('input').keyup(function(e){
					self.keyup(e);
				});
			}
			
			SearchBox.prototype = {
				keyup: function(e){
					var self = this;
					var query = this.ele.find('input').val();
					this.ele.find('a').remove();
					if (query === '') return;
					this.parent.sections.forEach(function(section){
						section.items.forEach(function(item){
							var text = item.ele.text();
							if (text.toUpperCase().indexOf(query.toUpperCase()) != -1) {
								self.ele.append($('<a>').attr('href','javascript:void(0)').text(text));
								var newEle = self.ele.find('a').last();
								self.items.push(new TopMenu.Item(newEle, self));
								newEle.click(function(){
									item.ele.click();
								});
							}
						});
					});
				}
			};
			
			return SearchBox;
			
		})();
	
		$.fn.topMenu = function() {
			this.each(function(){
				new TopMenu(this);
			});
			return this;
		};
		
	})(jQuery);
	
	$('.ui-top-menu').topMenu();