<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Tool</title>
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<style>
input[type=checkbox], input[type=radio] {
    transform: scale(1.5);
}
</style>

</head>
<body style=" background: currentColor; ">
	<div class="container" style="margin-top:30px">
		<div class="row">


			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Keyword</div>
					<div class="panel-body">
						<div class="form-group">
							<input class="form-control" id="keyword" placeholder="Nhập từ khóa ..."></input>
						</div>
						<input class="form-control" id="_start" value="100" style="display:none">
						<input class="form-control" id="_page" value="1" style="display:none">
						<div class="form-group text-center">
							<input type="submit" id="search" class="btn btn-sm btn-primary" value="GET"></input>
						</div>
					</div>
				</div>
			</div>




			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Progress</div>
					<div class="panel-body">
						<div class="loading alert alert-primary">Chưa có hành động nào</div>
						<div class="result"></div>
						<div class="clearfix"></div>
						<div class="form-group text-center">
							<input class="btn-primary btn btn-sm" id="start" type="submit" style="display: none" value="Start"></input>
							<input class="btn-primary btn btn-sm" id="next" type="submit" style="display: none" value="Load thêm ảnh"></input>
						</div>
					</div>
				</div>
			</div>




		</div>
	</div>

	<div class="modal fade" id="modalPlayvideo">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Xem thử Video</h4>
				</div>
				<div class="modal-body" id="modal-body">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


	<script src="http://verlok.github.io/lazyload/src/lazyload.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8">
		
	var searchImage = function () {
		var keyword = $('#keyword').val();
		var start = $('#_start').val();
		var page = $('#_page').val();
		$('.loading').html('Đang tìm kiếm ...');
		$('#next').prop( "disabled", true );
		$('#search').prop( "disabled", true );
		$('#keyword').prop( "disabled", true );
		$.ajax({
			url: 'search-image.php',
			type: 'POST',
			data: {keyword: keyword, start: start, page: page},
		})
		.done(function(data) {
			$('#_start').val(parseInt(start) + 100);
			$('#_page').val(parseInt(page) + 1);
			$('#start').show();
			$('#next').show();
			$('.loading').html('Hoàn thành!');
			$('.result').append(data);
			$('#next').prop( "disabled", false );
			$('#search').prop( "disabled", false );
			$('#keyword').prop( "disabled", false );
			new LazyLoad();
		})
		.fail(function() {
			$('.loading').html('Lỗi!');
			$('#next').prop( "disabled", false );
			$('#search').prop( "disabled", false );
			$('#keyword').prop( "disabled", false );
		});
	}

	var generate = function () {
		$('.loading').html('Đang xử lý dữ liệu...');
		$('#start').prop('disabled', true);
		$.ajax({
			url: 'generate.php',
		})
		.done(function(data) {
			arrayListImage(data);
		})
		.fail(function() {
			$('#start').prop('disabled', false);
			alert('Fail... vui lòng thử lại');
		});
	}



	var arrayListImage = function (name) {
		
		var listarray = [];
		var list = $('body').find('[type="checkbox"]:checked');
		$.each(list, function (key, val) {
			$.ajax({
				url: 'save-image.php',
				type: 'POST',
				data: {name: name, file: $(val).val()}
			});			
		});
			submitImage(name);
		
	}


	var submitImage = function (name) {
		$.ajax({
			url: 'start.php',
			type: 'POST',
			data: {name: name},
		})
		.done(function(data) {
                        $('#start').prop('disabled', false);
			$('#modal-body').html('<video controls autoplay style="width:100%"><source src="'+data+'" type="video/mp4"></video>');
			$('#modalPlayvideo').modal('toggle');
		})
		.fail(function() {
			$('#start').prop('disabled', false);
			alert('Fail... vui lòng thử lại');
		});
	}


	$('#search').on('click', searchImage);
	$('#next').on('click', searchImage);
	$('#start').on('click', generate);
	






	</script>





</body>
</html>