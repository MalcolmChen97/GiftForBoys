$(document).ready(function() {
	main();
});

function ajaxquery( querytype, samplequery){
    
    $.ajax({
        url: 'ajaxresult.php',
        type: 'post',
        data: {'query': samplequery},
        success: function(data, status) {
            
            var resultarray=JSON.parse(data);//here is what can you use in javascript
            $( "#showData" ).append("<br>"+querytype+JSON.stringify(resultarray)+"<br>");
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}


function main(){
  $('button').on('click', function(event){
    if ($('#hello').hasClass('blue')){
		$('#hello').removeClass('blue');
		$('#hello').addClass('yellow');
	} else {
		$('#hello').removeClass('yellow');
		$('#hello').addClass('blue');
	}

  });
    
    
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
        $example_age_id = 7;//baby
        var $query_for_single_agetype = "SELECT giftinfo.id,giftinfo.name,giftinfo.url,giftinfo.image_name,giftinfo.price,giftinfo.popularity FROM (SELECT * FROM gift_hasatype WHERE gift_hasatype.aid="+$example_age_id+") as certaintype LEFT JOIN giftinfo on certaintype.gid=giftinfo.id";
        
        ajaxquery("giftByAge",$query_for_single_agetype);
    
        
        
        
        //next will be about type
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
        $example_type_id = 1;//tech
        var $query_for_single_gifttype = "SELECT giftinfo.id,giftinfo.name,giftinfo.url,giftinfo.image_name,giftinfo.price,giftinfo.popularity FROM (SELECT * FROM gift_hasgtype WHERE gift_hasgtype.typeid="+$example_type_id+") as certaintype LEFT JOIN giftinfo on certaintype.gid=giftinfo.id";
        ajaxquery("giftByTag",$query_for_single_gifttype);
    
        
        
        //next is about money, result array would be all gifts whose prices are below certatin number
        $example_bound = 100;
        var $query_for_price = "SELECT * FROM giftinfo where giftinfo.price<="+$example_bound;
        ajaxquery("giftByPrice",$query_for_price);
    
        
    });
    
      
    
    
}