jQuery plugin to customize the default select list

Mobile support (with jQuery Mobile)

Without jQuery Mobile dragging is disabled and user can only tap on the slider path.

###DEMO: http://demos.marioiliev.com/jquery-slider/

#	Plugin initialize
	Option 1: Add "data-slider-box" to a <div>
	Option 2: Call $(selector).createSlide(); to a <div> tag

#	Plugin parameters
###width
	Type: Number
	Define the slider width in px.
	Default - false (Slider takes the width of its container)
	$(selector).createSlide({ width: 250 });

###output
	Type: selector ('.class' or '#id')
	Defines where the slider value will appear.
	Default - false (Value is placed inside the sliders dragger button)
	$(selector).createSlide({ output: '.myclass' }); OR $(selector).createSlide({ output: '#myid' });
	
###firstvalue
	Type: Number/String (10 or 'Slide me')
	Defines the initial value before user slides the dragger.
	Default - false (First value will appear as 0)
	$(selector).createSlide({ firstvalue: 'Slide me' });
	
###maxvalue
	Type: Number
	Defines the maximum value (from 0 to 187 etc.)
	Default - false (maximum value is 100)
	$(selector).createSlide({ maxvalue: 187 });
	
###interval
	Type: Number
	Defines the value interval. Example: when set to 5 the slider will output values like this "5, 10, 15 etc."
	The maximum value should be devisable by the interval number otherwise this property wont take action.
	Default - false (no interva: value is visualized as 1,2,3 etc.)
	$(selector).createSlide({ interval: 5 });
	
###progress
	Type: Boolean
	Additional element is added to visualize the path which the dragger has travelled.
	Default - false
	$(selector).createSlide({ progress: true });
	
###destroy
	Type: Boolean
	By destroying the plugin you will remove the sliders HTML and javascript events.
	Default: false
	$(selector).createSlide({ destroy: true });
	
#	Plugin Styling
	* The wrapping slider <div> gets class "container" and "_1" as being the number of sliders on the page.
	* Inside of it there is the dragger button <div> with class "dragger"
	* When the dragger <div> is clicked it gets class "dragging"
	* If 'progress' parameter is called the container <div> gets one more <div> with class "progress"

###### 	The plugin doesn't apply visual styling.
###### 	You can use this basic CSS to get started with your customization:

	/* Plugin CSS */
	.container {
		height: 5px;
		margin: 30px auto;
		background-color: #DADADA;
	}
	.dragger {
		width: 40px;
		height: 40px;
		color: #FFF;
		font-weight: 600;
		line-height: 40px;
		background-color: #FFA11B;
		border-radius: 25px;
	}
	.dragging {
		background-color: #FFC168;
		box-shadow: inset 0px 0px 20px #E47E00;
	}
	.progress {
		width: 0px;
		background-color: #FF952C;
	}
