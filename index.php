<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  </head>
  <body style="padding-top: 20px;">
  <div class="container">
    <div class="row marketing">
        <div class="col-lg-12">
            <h1><?php echo "Какие-то тапочки";?></h1>
            <hr />
        </div>
        <div class="col-lg-6">
            <img src="/image.jpg" class="img-responsive" />
        </div>
        <div class="col-lg-6">
            <div class="col-lg-6">
                <h3>Цена:</h3>
                <div class="col-lg-8"><h2 class="price">1900 руб</h2></div>
                <div class="col-lg-4 print-seal"></div>                
            </div>
            <div class="col-lg-6">
                <div class="col-lg-12" style="padding-top: 15px;padding-bottom: 10px;">
                    <button type="button" class="btn btn-success submit button-submit" style="float: right;" >Купить</button>
                </div>
                <div class="row">
                  <div class="col-xs-4">
                    <h4>Кол-во: </h4>
                  </div>
                  <div class="col-xs-4" >
                    <input type="number" class="form-control num" placeholder="Text input" value="1">
                  </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h3>Обязательные поля:</h3>
                <div class="col-lg-12" style="padding-bottom: 20px;">
                    <div class="col-lg-4">
                        <input type="text" class="form-control validation name" name="name" placeholder="Введите Имя">
                    </div>
                    <div class="col-lg-4">
                        <input type="tel" class="form-control validation tel" name="tel" placeholder="Введите Номер">
                    </div>
                    <div class="col-lg-4">
                        <input type="email" class="form-control validation email" name="email" placeholder="Введите email">
                    </div>
                </div>
                <div class="col-lg-12" style="padding-bottom: 20px;">
                    <div class="radio">
                      <label>
                        <input type="radio" class="optionsRadios" name="optionsRadios" id="optionsRadios1" value="0" checked>
                        Без скидки
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" class="optionsRadios" name="optionsRadios" id="optionsRadios2" value="1">
                        Промокод <div class="col-lg-9 promo input-work" style="float: right;"></div>
                      </label>
                    </div>
                    <div class="radio disabled">
                      <label>
                        <input type="radio" class="optionsRadios" name="optionsRadios" id="optionsRadios1" value="2">
                        Карта лояльности <div class="col-lg-9 card input-work" style="float: right;"></div>
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>

    $(document).ready (function()
    {
        var start_price = Number($('.price').text().replace(/\D+/g,""));
        var new_price = start_price;
        var valid_all = false;
        var seal_deal = false;
    	// блокируем кнопку отправки до того момента, пока все поля не будут проверены
    	$('.submit').prop('disabled', true);
    	
    	// elements содержит количество элементов для валидации
    	var elements = $('.validation').length;
                
        //работа с радио кнопками, добавление инпута
        $('.optionsRadios').click(function() {
            var radio = $(this).val();
            if(radio == 1){
                $('.create-input').remove();
                $('.promo').html('<input id="create-input" type="number" style="height: 25px;" class="form-control create-input">');
            }else{
                if(radio == 2){
                    $('.create-input').remove();
                                        
                    $('.card').html('<input id="create-input" type="number" style="height: 25px;" class="form-control create-input">');
                }else{
                    $('.create-input').remove();
                }
            }
        });
        //обработка инпута
        $(".input-work").change(function() {
            var data_up = 'dop_seal='+$(".create-input").val();
            $.ajax({
                url:     "./post.php", //url страницы (action_ajax_form.php)
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: data_up,
                success: function(response) { //Данные отправлены успешно
                	if(response == 1){
                	   if(seal_deal == false){
                    	   new_price = new_price - (new_price / 100) * 10;
                           var modificator_price =$('.num').val();
                           if(modificator_price >= 1){
                            $(".price").text(new_price*modificator_price+" руб");
                            
                           }else{
                            $(".price").text(new_price+" руб");
                           }
                           seal_deal = true;
                       }
                       $('.print-seal').html("<h3>-10%<h3>"); 
                	}else{
                	   $('.print-seal').html("");
                	   new_price = start_price;
                       var modificator_price =$('.num').val();
                       if(modificator_price >= 1){
                        $(".price").text(new_price*modificator_price+" руб");
                       }else{
                        $(".price").text(new_price+" руб");
                       }
                       seal_deal = false;
                	}                    
            	},
            	error: function(response) { // Данные не отправлены
                    alert('Все плохо');
            	}
         	});
        });
        
        //работа с количеством товара
    	$('.num').change(function() {
    	   var modificator_price =$('.num').val();
           if(modificator_price >= 1){
            $(".price").text(new_price*modificator_price+" руб");
           }else{
            $(".price").text(new_price+" руб");
           }
    	});
        
    	//работа с обязательными полями
    	$('.validation').change(function() {
    		var tel = $('.tel').val();
            if(tel !== ''){
                var valid_tel = /^\d[\d\(\)\ -]{9,14}\d$/;
                if(valid_tel.test(tel))
                    valid_all = true;
                else
                    valid_all = false;
            }else{
                valid_all = false;
            }
            
            var name = $('.name').val();
            if(name !== '' && valid_all != false){
                valid_all = true;
            }else{
                valid_all = false;
            }
            
            var email = $('.email').val();
            if(email !== '' && valid_all != false){
                var valid_email = /^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i;
                if(valid_email.test(email))
                    valid_all = true;
                else
                    valid_all = false;
            }else{
                valid_all = false;
            }
    
    		if (valid_all == true)
    		{
    			$('.submit').prop('disabled', false);
    		}else{
    		  $('.submit').prop('disabled', true);
    		}
    	});
        
        //работа с кнопкой
        $('.button-submit').click(function() {
            var price_end = Number($('.price').text().replace(/\D+/g,""));
            var name = $('.name').val();
            var email = $('.email').val();
            var tel = $('.tel').val();
            if(name != '' && email != '' && tel != ''){
                var data_up = 'name='+name+'&email='+email+'&tel='+tel+'&price='+price_end+'&seals='+$('.print-seal').text()+'&quantity='+$('.num').val();
                $.ajax({
                    url:     "./post.php", //url страницы (action_ajax_form.php)
                    type:     "POST", //метод отправки
                    dataType: "html", //формат данных
                    data: data_up,
                    success: function(response) { //Данные отправлены успешно
                    },
                	error: function(response) { // Данные не отправлены
                        alert('Все плохо');
                	}
                });
            }
            
        });
    });
    </script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </body>
</html>
