//loads blog feeds through Google API
				
	function drawBlogs(){
		var container = document.getElementById("blogs");
		var feeds = ['http://dpplplaintalk.blogspot.com/feeds/posts/default','http://positivelyestreet.blogspot.com/feeds/posts/default','http://kidding-around.blogspot.com/feeds/posts/default','http://feed43.com/5583164584461834.xml'];
		
		for (i = 0; i < feeds.length; i ++){
				var feed = new google.feeds.Feed(feeds[i]);
				feed.setNumEntries(1);
				feed.load(function(result){
					if (!result.error){
						//console.log(result.feed.title);
						for (var i = 0; i < result.feed.entries.length; i++){
							var entry = result.feed.entries[i];
							
							var div = document.createElement("div");
							div.setAttribute('class', 'entry');
							
							var feedtitle = document.createElement("div");
							feedtitle.setAttribute('class', 'feed-title');
							feedtitle.appendChild(document.createTextNode(result.feed.title));
							
							div.appendChild(feedtitle);
							
							var title = document.createElement("div");
							title.setAttribute('class', 'entry-title');
							
							var link = document.createElement("a");
							link.setAttribute('href', entry.link);
							link.appendChild(document.createTextNode(entry.title));
							
							title.appendChild(link);
							
							var content = document.createElement("div");
							content.setAttribute('class', 'entry-content');
							content.innerHTML = entry.content;
							
							div.appendChild(title);
							div.appendChild(content);
							container.appendChild(div);
						}
					}
					else{
						container.appendChild(document.createTextNode("No entries were returned. Sorry."));
					}
				});
			}
	}