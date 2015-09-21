 <!-- Правый блок -->
    <div class="sidebar-block">

                <div class="sidebar-block--header">
            <div class="sidebar-block--header-text">
                
                                            
                                                    Подбор картриджей                   
            </div><!-- .sidebar-block--header-text -->
        </div><!-- .sidebar-block--header -->
                <div class="sidebar-block--content">
            <div class="sidebar-block--content-top"></div>
            <div class="sidebar-block--content-middle">
                <div class="sidebar-block--content-text">
<!-- Контент правого блока "Подбор картриджей" -->
<noindex>
<div class="sidebar-cartridge">

    <table class="sidebar-cartridge--info">
        <tr>
            <td class="sidebar-cartridge--icon">
                <a href="#" class="sidebar-cartridge--icon-link">
                	<img src="/images/longwinter/sidebar-cartridge/icon.jpg" width="64" height="64" alt="" class="sidebar-cartridge--icon-img" />
                </a>
            </td>
            <td class="sidebar-cartridge--text">
                Выберите производи-<br />
                теля и модель
            </td>
        </tr>
    </table>
        [[!getPrinters]]
    <div class="sidebar-cartridge--form">
    	<form class="sidebar-cartridge--form_js" action="/podbor-kartridzha">
        	<div class="sidebar-cartridge--field">
            	<select id="cartridge-brand-select" name="brand" class="sidebar-cartridge--field-select sidebar-cartridge--brand_js">
                    <option value="0">Выберите производителя</option>
                    	                   [[+brands]]
	                </select>
            </div>
            <div class="sidebar-cartridge--field">
            	            		<select id="" name="type" class="sidebar-cartridge--field-select sidebar-cartridge--type_js" >
                    	<option value="0">Выберите тип устройства</option>
                         [[+cats]]
                	</select>
                            </div>
            <div class="sidebar-cartridge--field">
            
            	            		<select id="" name="model" class="sidebar-cartridge--field-select sidebar-cartridge--model_js" >
                    	<option value="0">Выберите модель</option>
                         [[+products]]
                	</select>
                
            </div>
            <div class="sidebar-cartridge--button">
                


	    
    <!-- Кнопка type="submit" светло-серая -->
    <div class="form-submit2 form-submit2_js">
        
        <div class="form-submit2--inside">
            <div class="form-submit2--block">
            
                <div class="form-submit2--text">
                    Подобрать                </div>
                
                                <input
                    type="submit"
                    name="consum"
                                                                             value=""
                    class="form-submit2--input"
                />
                
            </div>
        </div>
        
    </div><!-- .form-submit2 -->
    <!-- Кнопка type="submit" светло-серая -->
            </div>
        </form>
    </div>
    
</div><!-- .sidebar-cartridge -->
</noindex>
<!-- / Контент правого блока "Подбор картриджей" -->                </div><!-- .sidebar-block--content-text -->
            </div><!-- .sidebar-block--content-middle -->
            <div class="sidebar-block--content-bottom"></div>
        </div><!-- .sidebar-block--content -->

    </div><!-- .sidebar-block -->
    <!-- / Правый блок -->
    

    <script type="text/javascript">
    
        
    $('#cartridge-brand-select').bind('change',function(){
        
       $.getJSON( "cartridge/index.php", function( data ) {

        console.log(data);
              var items = [];
              $.each( data, function( key, val ) {
                items.push( "<li id='" + key + "'>" + val + "</li>" );
              });
             
              $( "<ul/>", {
                "class": "my-new-list",
                html: items.join( "" )
              }).appendTo( "body" );
            });
    });

    </script>
        