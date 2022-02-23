<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <style>
        .slidecontainer {
            width: 100%;
            /* Width of the outside container */
        }

        /* The slider itself */
        .slider {
            -webkit-appearance: none;
            /* Override default CSS styles */
            appearance: none;
            width: 100%;
            /* Full-width */
            height: 25px;
            /* Specified height */
            background: #d3d3d3;
            /* Grey background */
            outline: none;
            /* Remove outline */
            opacity: 0.7;
            /* Set transparency (for mouse-over effects on hover) */
            -webkit-transition: .2s;
            /* 0.2 seconds transition on hover */
            transition: opacity .2s;
        }

        /* Mouse-over effects */
        .slider:hover {
            opacity: 1;
            /* Fully shown on mouse-over */
        }

        /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            /* Override default look */
            appearance: none;
            width: 25px;
            /* Set a specific slider handle width */
            height: 25px;
            /* Slider handle height */
            background: #497206;
            /* Green background */
            cursor: pointer;
            /* Cursor on hover */
            border-radius:50%;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            /* Set a specific slider handle width */
            height: 25px;
            /* Slider handle height */
            background: #04AA6D;
            /* Green background */
            cursor: pointer;
            /* Cursor on hover */
        }
        #userEmails{
            width:100%;
            height:5vh;
            border:1px solid gray;
            text-align:center;
        }
    label{
        font-weight:600;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
        // $(".slider").click(alert('hello'));
        // var slider = document.getElementById("myRange");
        // var output = document.getElementById("demo");
        // output.innerHTML = slider.value; // Display the default slider value
        // $("#domain_authority").on('drag',function(){
        //     alert("helo");
        // });
        // // Update the current slider value (each time you drag the slider handle)
        // slider.oninput = function() {
        //     output.innerHTML = this.value;
        // }

    </script>

    <div class="p-5">
    <div class="card p-5">
        <div class="card-body">
        <div class="row">
        <div class="col-md-12">
        <label>Categories</label><br>
        <input type="text" name="categories" class="mb-2" style="width:100%">
        </div>
        </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="slidecontainer">
                        <label for="" class="text-bold">Domain Authority</label>
                        <input type="range" min="1" max="100" value="50" class="slider" id="domain_authority">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="slidecontainer">
                        <label for="" class="text-bold">Domain Raiting</label>
                        <input type="range" min="1" max="100" value="50" class="slider" id="domain_ratings">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="slidecontainer">
                        <label for="" class="text-bold">Citation flow</label>

                        <input type="range" min="1" max="100" value="50" class="slider" id="citation_flow">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="slidecontainer">
                        <label for="" class="text-bold">Trust flow</label>
                        <input type="range" min="1" max="100" value="50" class="slider" id="trust_flow">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="slidecontainer">
                            <label for="" class="text-bold">Traffic (Ahrefs)</label>
                            <input type="range" min="1" max="100" value="50" class="slider" id="traffic_ahref">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="slidecontainer">
                            <label for="" class="text-bold">Traffic (SEMrush)</label>
                            <input type="range" min="1" max="100" value="50" class="slider" id="traffic_sem">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="slidecontainer">
                            <label for="" class="text-bold">Webmaster's Price</label>
                            <input type="range" min="1" max="100" value="50" class="slider" id="webmaster_price">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="slidecontainer">
                            <label for="" class="text-bold">Webmaster's Price for Casino Post</label>
                            <input type="range" min="1" max="100" value="50" class="slider" id="webmaster_casino">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="slidecontainer">
                            <label for="" class="text-bold">Build With Blogs Price</label>
                            <input type="range" min="1" max="100" value="50" class="slider" id="blog_price">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="slidecontainer">
                            <label for="" class="text-bold">Build With Blogs Price for Casino Post</label>
                            <input type="range" min="1" max="100" value="50" class="slider" id="casino_price">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="slidecontainer">
                            <label for="" class="text-bold">Referring Domains (Ahrefs)</label>
                            <input type="range" min="1" max="100" value="50" class="slider" id="referring_domain">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <label for="cars">Choose a car:</label><br>
                <select name="cars" id="userEmails">
                    <option value="--Select Email--"><span class="text-center">--Select Email--</span></option>
                    <option value="saab">Static@gmail.com</option>
                </select>
                </div>
                <div class="col-md-4">
                  <label for="cars">Date Of the last Update:</label><br>
                   <div class="input-group">
						<input type="date" class="form-control" name="lstart">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-ellipsis-h"></i></span>
						</div>
						<input type="date" class="form-control datepicker hasDatepicker" name="lend">
					</div>
                </div>
                <div class="col-md-4">
                <label for="cars">Date Of Add:</label><br>
                   <div class="input-group">
						<input type="date" class="form-control" name="lstart">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-ellipsis-h"></i></span>
						</div>
						<input type="date" class="form-control datepicker hasDatepicker" name="lend">
					</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <h6 class="mt-2">Sponcer Tag</h6>
                <label class="ml-2">Yes</label>
                <input type="radio" >
                <label class="ml-2">No</label>
                <input type="radio">
                </div>
                <div class="col-md-4">
                    <div class="d-flex" style="margin-top:3.5vh;">
                        <div class="custom-control custom-radio mr-2">
                            <input type="radio" class="custom-control-input" id="dofollow" name="dofollow" value="Dofollow">
                            <label class="custom-control-label" for="dofollow">Dofollow</label>
                        </div>
                        <div class="custom-control custom-radio mx-2">
                            <input type="radio" class="custom-control-input" id="nofollow" name="dofollow" value="Nofollow">
                            <label class="custom-control-label" for="nofollow">Nofollow</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="margin-top:3.5vh;">
						<div class="form-group text-center">
							<button class="btn btn-primary" type="button" id="advancesearchfilter">Filter</button>
							<button class="btn btn-danger ml-2" type="button" id="advancesearchfilter_reset" onclick="window.location.reload();">Reset</button>
						</div>
				</div>
            </div>
        </div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
