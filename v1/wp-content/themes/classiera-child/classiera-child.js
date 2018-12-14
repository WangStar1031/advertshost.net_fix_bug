jQuery('.post_adverts').click(function(){//Choose Your Advert Type
	jQuery('#smartwizard').show();//Show Wizard
	jQuery('.progress').show();//Show Progress Bar
	//console.log(jQuery(this).attr('id'));//Display ID in the console
	// var p= jQuery('#ads_cost').val();
	jQuery('.double_sec').hide();//Hide Adverts Types
	jQuery('.standard').hide();//Hide Adverts Types
	jQuery('.double_top').hide();//Hide Adverts Types
	jQuery('.standard_top').hide();//Hide Adverts Types
	var adsPrice = jQuery(this).attr('id');//Set Variable adsPrice
	console.log(adsPrice + 'advert price')
	var currentPrice = jQuery('#'+adsPrice+'-ads_cost_change-0').val();
	console.log(currentPrice + 'some price');
	jQuery('#ads_type_selected').val(adsPrice);
	jQuery('#ads_cost').val(currentPrice);
	jQuery('#'+adsPrice+'-ads_cost-0').show();
	jQuery('#section_type').hide();
	var uw_balance=jQuery('#uw_balance').val();
	console.log(uw_balance + 'balance')
	if(parseInt(uw_balance)>=parseInt(currentPrice)){
		var Header="Confirm Posting New Advert";
		var Message="Post new advert for "+currentPrice+" Credits.";
		var footer='<button class="post-submit btn btn-default" type="submit" name="op" value="Publish Ad">OK</button><button type="button" id="cancelBtn" class="btn btn-default" data-dismiss="modal">Cancel</button>';
		jQuery('#myModal .modal-title').text(Header);
		jQuery('#myModal .modal-body-info').text(Message);
		jQuery('#myModal .modal-footer').html(footer); //post-submit btn btn-primary sharp btn-md btn-style-one btn-block
	}
	else
	{
		var Header="Please Purchase more Credits";
		var Message="Unfortuantely your credit balance is too low to post this advert.Please purchase more credit and try again.";
		var footer='<a href="http://www.bwsproduction.com/advertshost/get-credits/" class="btn_getCredit">Get More Credits</a>';
		jQuery('#myModal .modal-title').html(Header);
		jQuery('#myModal .modal-body-info').html(Message);
		jQuery('#myModal .modal-footer').html(footer);
	}
	//jQuery('.sw-btn-next').click();
});
	

	setInterval(function(){
		jQuery('.sw-btn-next, .sw-btn-prev , .nav-item.clickable').click(function(){
			
			var url	= window.location.href;
			//console.log(url);
			var a=jQuery('#current-progress').css('width');
			var res = url.split("step-");
			var numItems = $('.clickable').length;
			// console.log(numItems);
			if(res[1]>=0)
			{
				var numsplit=100/(numItems-1);
				// console.log(numsplit);
				var count=(res[1]-1)*numsplit;
				setTimeout(function(){
					jQuery('#current-progress').css('width',count+'%');
				},500);
			}
			else
			{
				jQuery('#current-progress').css('width','0%');
			}
			
		});
	}, 1000);

jQuery('#ads_length').change(function(){
	var id = jQuery(this).val();
	console.log(id);
	var days_to_expire = jQuery('#ads_length option:selected').text();
	console.log(days_to_expire);
	days_to_expire = days_to_expire.split(" ");
	console.log(days_to_expire);
	jQuery('.ad_price_cost').hide();
	jQuery('#days_to_expire').val(days_to_expire[0]);
	var ads_type_selected=jQuery('#ads_type_selected').val();
	console.log(ads_type_selected);
	var vText = jQuery('#'+ads_type_selected+'-ads_cost_change-'+id).val();
	var totalPay = parseInt(vText);
	jQuery('#ads_cost').val(totalPay);
	jQuery('#'+ads_type_selected+'-ads_cost-'+id).show();
	var uw_balance=jQuery('#uw_balance').val();
	console.log(uw_balance);
	console.log(totalPay);
	if(parseInt(uw_balance) >= parseInt(totalPay)){
		var Header="Confirm Posting New Advert";
		var Message="Post new advert for "+totalPay+" Credits.";
		var footer='<button class="post-submit btn btn-default" type="submit" name="op" value="Publish Ad">OK</button><button type="button" id="cancelBtn" class="btn btn-default" data-dismiss="modal">Cancel</button>';
		jQuery('#myModal .modal-title').text(Header);
		jQuery('#myModal .modal-body-info').text(Message);
		jQuery('#myModal .modal-footer').html(footer); //post-submit btn btn-primary sharp btn-md btn-style-one btn-block
	}
	else
	{
		var Header="Please Purchase more Credits";
		var Message="Unfortuantely your credit balance is too low to post this advert.Please purchase more credit and try again.";
		var footer='<a href="http://www.bwsproduction.com/advertshost/get-credits/" class="btn_getCredit">Get More Credits</a>';
		jQuery('#myModal .modal-title').html(Header);
		jQuery('#myModal .modal-body-info').html(Message);
		jQuery('#myModal .modal-footer').html(footer);
	}
});



jQuery(window).keydown(function(event){
    if( (event.keyCode == 13) ) {
      event.preventDefault();
      return false;
    }
});
jQuery('form#primaryPostForm input').keyup(function() {

        var empty = false;
        jQuery('form#primaryPostForm input').each(function() {

            if (jQuery(this).val() == '') {
                empty = true;
            }
        });
        jQuery('form#primaryPostForm input[type="file"]').each(function() {
        	console.log(jQuery(this).val());
        	 if (jQuery(this).val() != '') {
                empty = false;
            }
        });
        jQuery('form#primaryPostForm select').each(function() {
        	console.log(jQuery(this).val());
            if (jQuery(this).val() == '') {
                empty = true;
            }
        });
        console.log(empty);
        if (empty) {
        	jQuery('#beforeupdatecheck').attr('disabled', 'disabled'); 
            
        } else {
            jQuery('#beforeupdatecheck').removeAttr('disabled'); 
        }
});
jQuery('form#primaryPostForm select').change(function() {

        var empty = false;
        jQuery('form#primaryPostForm input').each(function() {

            if (jQuery(this).val() == '') {
                empty = true;
            }
        });
        jQuery('form#primaryPostForm input[type="file"]').each(function() {
        	console.log(jQuery(this).val());
        	 if (jQuery(this).val() != '') {
                empty = false;
            }
        });
        jQuery('form#primaryPostForm select').each(function() {
        	console.log(jQuery(this).val());
            if (jQuery(this).val() == '') {
                empty = true;
            }
        });
        console.log(empty);
        if (empty) {
        	jQuery('#beforeupdatecheck').attr('disabled', 'disabled'); 
            
        } else {
            jQuery('#beforeupdatecheck').removeAttr('disabled'); 
        }
});

var modal = document.getElementById('myModalBump');
var span = document.getElementsByClassName("closeBump")[0];
function bump_ads(ajaxUrl,postID)
{
	console.log(postID);
	var adsType=jQuery('bump_ads_type-'+postID).val();
	var um_balance=jQuery('#uw_balance').val();
	jQuery('#bumpOkBtn').attr('data-id', postID);
	jQuery('#bumpOkBtn').attr('data-url', ajaxUrl);
	if(adsType=='standard_top' || adsType=='double_top')
	{
		if(um_balance>=10)
		{
			jQuery('#bumpCredit').html('10');
			jQuery('#bumpOkBtn').prop('disabled', false);
		}else{
			jQuery('#textbump').text('You Do not have enough credits in your wallet to bump the advert');
			jQuery('#bumpOkBtn').prop('disabled', true);
		}
	}else{
		if(um_balance>=5)
		{
			jQuery('#bumpCredit').html('5');
			jQuery('#bumpOkBtn').prop('disabled', false);

		}else{
			jQuery('#textbump').text('You Do not have enough credits in your wallet to bump the advert');
			jQuery('#bumpOkBtn').prop('disabled', true);
		}
	}
	modal.style.display = "inline-block";


}
jQuery('#cancelBtn').click(function(){
	  modal.style.display = "none";
	});
// span.onclick = function() {
//     modal.style.display = "none";
// }
jQuery('#bumpOkBtn').click(function(){
jQuery(this).prop('disabled', true);
var postID=jQuery('#bumpOkBtn').attr('data-id');
var ajaxUrl=jQuery('#bumpOkBtn').attr('data-url');
var adsType=jQuery('bump_ads_type-'+postID).val();
console.log(ajaxUrl);
 jQuery.ajax({
        type: 'POST',
        url: ajaxUrl,
        data: {
            'action'	:'bump_ads_post',
            'post_id'   :   postID,
            'adsPostType':adsType
        },
        success: function (responce) {
           location.reload();

        },
        error: function (errorThrown) {

        }
    });

});

function discount_ads(ajaxUrl, postIDs)
{
	var discount_per=jQuery('input[name=radiodiscount-'+postIDs+']:checked').val();
	console.log(discount_per);
	var post_ids=postIDs;
	jQuery.ajax({
        type: 'POST',
        url: ajaxUrl,
        data: {
            'action'	:'discount_ads_post',
            'post_id'   :   post_ids,
            'discount_code':discount_per
        },
        success: function (responce) {
        	console.log(responce);
           location.reload();

        },
        error: function (errorThrown) {

        }
    });
}