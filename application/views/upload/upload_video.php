<!DOCTYPE HTML>
<html>
<head>
<title>Articles - Upload Video</title>
<link href="<?php echo base_url("public/plugins/bootstrap3/css/bootstrap.min.css");?>" media="all" type="text/css" rel="stylesheet">
<script src="https://code.jquery.com/jquery.js"></script>
<script src="<?php echo BASE_URL?>public/js/media.js"></script>	
</head>

<body>
	<div class="container">
		<div class="row" style="padding:20px 20px;">
			<div class="col-sm-12 col-md-12">
				<form role="form" method="post" action="/upload/upload_video/submit" id="url-form">
					<?php $error = $this->session->userdata('url_error');?>
					<?php if($error):?>
					<div class="form-group">
						<p style="color:red;"><?php echo $this->session->userdata('url_error');?></p>
					</div>
					<?php endif;?>
					<div class="form-group">
				    	<label for="video_url">Video Link</label>
				    	<input type="text" class="form-control" id="video_url" name="url" placeholder="Video Link">
				    	<br/>
				    	<p id="url-tip" class="text-danger hidden">The url can't be empty!</p>
				    	<p class="text-right"><button type="submit" class="btn btn-info">Submit</button></p>
				  	</div>
				</form>
			</div>
		</div>
		<div id="preview" class="text-center">
			<img src="<?php if(isset($preview)) echo $preview['hqthumb'];?>">
		</div>
		<?php if(isset($preview)){?>
		<div class="row" style="padding: 20px 20px;">
			<div class="col-sm-12 text-right" style="margin-top: 30px;">
			
                                <button type="button" id="finished-button" class="btn btn-danger" onclick="setMediaVideo('<?php echo $preview['id'];?>','<?php echo $fileName;?>','<?php echo htmlspecialchars($caption);?>','<?php echo $type;?>')" style="margin-top: -20px">Finished</button>
			</div>
		</div>
		<?php }?>
	</div>
</body>

<script language="Javascript">
  
	function setVideo(id,thumb)
	{
		var str = '<div id="preview_'+id+'" class="col-sm-4 col-md-4"><div class="preview"><span class="del-preview" onclick="delPreview(\''+id+'\')"></span><div class="thumb"><input type="hidden" name="type" value="2"><input type="hidden" value="'+id+'" name="resource"><img class="img-responsive" src="'+thumb+'"/></div></div></div>';
		$(window.parent.document).contents().find('#preview-section').append(str);
		$(window.parent.document).contents().find('#popWinClose').click();
	}

    function setImage(image)
    {
    	$(window.parent.document).contents().find('.upload-section').css({'background-color':'#FFF','background-image':'url(/public/uploads/'+image+')','background-repeat':'no-repeat','background-position':'center'})
    	$(window.parent.document).contents().find('#image_name').val(image);
    	str = '<img style="width:100%; height:auto;" src="/public/uploads/'+image+'"/>';
    	$(window.parent.document).contents().find('.alt-image').html(str);
    }

    function quickSetImg(id,img)
    {
    	str = '<img class="img-responsive" src="/public/uploads/'+img+'"/>';
    	$(window.parent.document).contents().find('#add-'+id).html(str);
    	$(window.parent.document).contents().find('#'+id).val(img);
    }

    $("#url-form").submit(function(){
		$('#url-tip').addClass('hidden');
		var url = $('#video_url').val();
		if(!url)
		{
			$('#url-tip').removeClass('hidden');
			return false;
		}
		return true;
    })
</script>
</html>