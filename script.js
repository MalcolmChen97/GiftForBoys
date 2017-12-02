$(document).ready(function() {
	/********************
	AGE: FRONT END SCRIPT
	********************/
	var age = "";
	$('.age-btn').click(function(){
		//Set the age group
		age = parseInt(this.value);

		//Reset the colors of all the buttons
		$('#baby').removeClass('selected-btn');
		$('#child').removeClass('selected-btn');
		$('#teenager').removeClass('selected-btn');
		$('#adult').removeClass('selected-btn');
		$('#middleaged').removeClass('selected-btn');
		$('#senior').removeClass('selected-btn');

		//Update the selected button to be colored
		$(this).addClass('selected-btn');
		$(this).blur();
	});

	/********************
	TYPE: FRONT END SCRIPT
	********************/
	var types = new Set();
	$('.type-btn').click(function(){
		var type_int = parseInt(this.value);

		if (types.has(type_int)){
			// Type is already in set, remove it
			$(this).removeClass('selected-btn');
			types.delete(type_int);
		} else {
			// Type is not in set, add it
			$(this).addClass('selected-btn');
			types.add(type_int);
		}

		$(this).blur();
	});

	/*******************************
	BOUND (budget): FRONT END SCRIPT
	*******************************/
	var bound = 10;
	$('.bound-btn').click(function(){
		bound = parseInt(this.value);

		//Reset the colors of all the buttons
		$('#10').removeClass('selected-btn');
		$('#25').removeClass('selected-btn');
		$('#50').removeClass('selected-btn');
		$('#100').removeClass('selected-btn');
		$('#250').removeClass('selected-btn');
		$('#500').removeClass('selected-btn');

		//Update the selected button to be colored
		$(this).addClass('selected-btn');
		$(this).blur();
	});

	/***********************
	DISPLAY THE GIFT RESULTS
	***********************/
	$('.showresult').click(function(){

			//sending query
			//my example here

			//this query returns all gifts with certain age(you need to run this multiple times if there are more than one age type selected, just concat multiple result arrays)
			/*
					baby_id=7
					child_id=8
					teenager_id=9
					adult_id=10
					middle-aged_id=11
					senior_id=12
			*/
			$example_age_id = age;//baby
			var $query_for_single_agetype = "SELECT giftinfo.id,giftinfo.name,giftinfo.url,giftinfo.image_name,giftinfo.price,giftinfo.popularity FROM (SELECT * FROM gift_hasatype WHERE gift_hasatype.aid="+$example_age_id+") as certaintype LEFT JOIN giftinfo on certaintype.gid=giftinfo.id";

			ajaxquery(("age_id " + String(age) + ": "),$query_for_single_agetype);

			console.log("age_query: " + typeof $query_for_single_agetype);

			/*
					tech_id=1
					sport=2
					draw=3
					music=4
					video games =5
					toys=8
					clothing=9
					bag=11
					others=12
			*/
			types.forEach(function(value){
				$example_type_id = value;
				var $query_for_single_gifttype = "SELECT giftinfo.id,giftinfo.name,giftinfo.url,giftinfo.image_name,giftinfo.price,giftinfo.popularity FROM (SELECT * FROM gift_hasgtype WHERE gift_hasgtype.typeid="+$example_type_id+") as certaintype LEFT JOIN giftinfo on certaintype.gid=giftinfo.id";
				ajaxquery("giftByTag",$query_for_single_gifttype);
			});

			// $example_type_id = 1;//tech
			// var $query_for_single_gifttype = "SELECT giftinfo.id,giftinfo.name,giftinfo.url,giftinfo.image_name,giftinfo.price,giftinfo.popularity FROM (SELECT * FROM gift_hasgtype WHERE gift_hasgtype.typeid="+$example_type_id+") as certaintype LEFT JOIN giftinfo on certaintype.gid=giftinfo.id";
			// ajaxquery("giftByTag",$query_for_single_gifttype);

			//next is about money, result array would be all gifts whose prices are below certatin number
			$example_bound = bound;
			var $query_for_price = "SELECT * FROM giftinfo where giftinfo.price<="+$example_bound;
			ajaxquery("giftByPrice",$query_for_price);



	});
});

function ajaxquery( querytype, samplequery){

    $.ajax({
        url: 'ajaxresult.php',
        type: 'post',
        data: {'query': samplequery},
        success: function(data, status) {

            var resultarray=JSON.parse(data);//here is what can you use in javascript
            $( "#showData" ).append("<br>"+querytype+JSON.stringify(resultarray)+"<br>");

						//Display the result on the front end.
						/*
						Here is an example, displaying the first ojject in the query.
						Switch out 0 when you iterate through, and remember to replace the
						placeholder image with the actual image
						*/
						var gift_title = data[0][1];
						var gift_price = data[0][4];
						var gift_link = data[0][2];
						var gift_img = "http://via.placeholder.com/200x200"	//placeholder images for now since I don't have access
						displayGift(gift_title, gift_price, gift_link, gift_img);

        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}

function displayGift(title, price, link_url, img_url){
	//Displays the gift in a user-friendly format.
	var result = '<a href="' + link_url + '" target="_blank">\
									<div class="container-fluid listing">\
									<div class="row listing">\
										<div class="col-xs-4 text-center">\
											<img class="gift-image" src="' + img_url + '">\
										</div>\
										<div class="col-xs-8">\
											<a href="'+ link_url + '" target="_blank">' + title + '</a>\
											<br><br><br>\
											<h4>' + price + '</h4>\
										</div>\
									</div>\
								 </div>\
								</a>';
	$('#giftList').append(result);
}
