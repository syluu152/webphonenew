<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo base_url(); ?>"></base>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ?></title>
  <link rel="icon" type="image/x-icon" href="public/images/iconu.png">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="public/css/bootstrap.min.css">
  <!-- Font Awesome -->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
    <script src="public/js/fontawesome5.min.js"  referrerpolicy="no-referrer"></script>
    <link href="public/css/fontawesome5.min.css" rel="stylesheet">

    <!-- Ionicons -->
  <link rel="stylesheet" href="public/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="public/css/AdminLTE.css">
  <link rel="stylesheet" href="public/css/ionicons.min.css">
  <meta property="fb:app_id" content="659513967881060">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="public/css/_all-skins.min.css">

  
   <script src="public/js/loader.js"></script>
   <script src="public/ckeditor/ckeditor.js"></script>
   <style>
    .content-header h1, th, label{
      color: #333;
    }
    label{font-weight: 600 !important;}
    .maudo{color: red}
    .mauxanh18{color: green;}
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <!-- Vung Header -->
    <?php $this->load->view('backend/modules/header'); ?>


    <!-- ./Vung Header -->
    <?php $this->load->view('backend/modules/menu'); ?>
    <?php 
    if(isset($com, $view))
    {
      $this->load->view('backend/components/'.$com.'/'.$view);
    }

    ?>

  </div><!-- ./wrapper -->
  <!-- jQuery 2.2.3 -->
  <script src="public/js/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="public/js/bootstrap.js"></script>
  <!-- AdminLTE App -->
  <script src="public/js/app.min.js"></script>
<script>
    $(document).ready(function (){
        checkOption();
    })
   $('.add-option-product').click(function (){
       let count_option = $('.option-product-list').children().length+1;
       const item = `<div data-option="`+count_option+`" class="row option-product-item">
                            <div class="col-md-5">
                                        <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chiều dài (cm)</label>
                                            <input type="number" required name="option-dai-product-`+count_option+`" class="form-control" min="10" max="999">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chiều rộng (cm)</label>
                                            <input type="number" required name="option-rong-product-`+count_option+`" class="form-control" min="10" max="999">
                                        </div>

                                    </div>
                                    </div>
                                    </div>
                            <div class="col-md-5">
                                        <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chiều cao (cm)</label>
                                            <input type="number" required name="option-cao-product-`+count_option+`" class="form-control" min="10" max="999">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Giá bán (VNĐ)</label>
                                            <input type="number" required name="option-gia-product-`+count_option+`" class="form-control" min="0">
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <a class="btn btn-warning remove-option" data-option="`+count_option+`">Xóa</a>
                                        </div>
                                    </div>
                                </div>`;
       $('.option-product-list').append(item);
       checkOption();
   });
   $('body').on('click','.remove-option',function (){
        $(this).parents('.option-product-item').remove();
       checkOption();
   });
   $('body').on('change','.option-product-item input',function (){
       let array = [];
       $('.option-product-item').each(function (){
           var location = $(this).data('option');
           let a = $('input[name="option-dai-product-'+location+'"]').val();
           let b = $('input[name="option-rong-product-'+location+'"]').val();
           let c = $('input[name="option-cao-product-'+location+'"]').val();
           let d = $('input[name="option-gia-product-'+location+'"]').val();
           let ops = {
                   "value": a+"X"+b+"X"+c,
                   "price" : d,
               }
           array.push(ops);
           $('input[name="option-product"').val(JSON.stringify(array));
       });
   });
   function getValueOption(){
       let array = [];
       $('.option-product-item').each(function (){
           var location = $(this).data('option');
           let a = $('input[name="option-dai-product-'+location+'"]').val();
           let b = $('input[name="option-rong-product-'+location+'"]').val();
           let c = $('input[name="option-cao-product-'+location+'"]').val();
           let d = $('input[name="option-gia-product-'+location+'"]').val();
           let ops = {
               "value": a+"X"+b+"X"+c,
               "price" : d,
           }
           array.push(ops);
           $('input[name="option-product"').val(JSON.stringify(array));
       });
   }
   function checkOption(){
       if ($('.option-product-item').length ==1) {
           $('.remove-option').hide();
       } else {
           $('.remove-option').show();
       }
       getValueOption();
   }
</script>
</body>
</html>
