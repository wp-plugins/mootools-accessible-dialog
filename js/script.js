window.addEvent('domready', function()
{
	var $j = jQuery.noConflict();
	
	if($j('#dialogTrigger').length>0)
    {
		var dialogCme = new DialogCME(
		{
			'alert':false,
			'closeButton':true,
			'title':$j('#twitter_screen_name').text()+' recent tweets',
			'content': '<div class="twitter_update_list"><ul>'+$j('#twitter_update_list').html()+'</ul></div>',
			'submit':
			{
				'exists':false,
				'value':'Submit',
				'fn': function(e)
				{
					console.log(this);
					this.hide();
				}
			},		
			'cancel':
			{
				'exists':false,
				'value':'Cancel',
				'fn': function(e)
				{
					this.hide();
				}
			}
		});
				
		$('dialogTrigger').addEvent('click', function(e)
		{
			e = new Event(e).stop();			
			dialogCme.show();
		}
		.bind(this));
	}
});
