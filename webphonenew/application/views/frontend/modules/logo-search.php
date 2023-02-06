<section class="logo-search">
  <div class="container">
   <div class="header-logo">
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 logo">
        <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>public/images/logo-white.svg" alt="Logo Construction"></a>
      </div>
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 search">
      
      <form action="search" method="get" role="form">
        <div class="input-search">
          <input type="text" class="form-control" id="search_text" name="search" placeholder="Bạn đang tìm kiếm gì?">
          <button>
              <i class="fa fa-search"></i>
            </button>
          </div>
        </form>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 hidden-xs header-right">
       <!-- Cart -->
       <div class="header_cart">
        <a href="gio-hang" title="Giỏ hàng">
         <span class="cart-icon">
         <i class="fas fa-shopping-cart"></i>
        </span>
        <span class="box_text">
          <strong class="cart_header_count">Giỏ hàng <span  style="float: right">
                  (<?php
            $khachhang = $this->session->userdata('sessionKhachHang');
        if($this->session->userdata('cart') || $khachhang){

            if ($khachhang && $this->session->userdata('cart'.$khachhang['id'])) {
                $val =$this->session->userdata('cart'.$khachhang['id']);
            }
            else if ($this->session->userdata('cart'))
            {
                $val = $this->session->userdata('cart');
            } else {
                $val = [];
            }
            $count = 0;
                foreach ($val as $value):
                    $count+= count($value);
                endforeach;
            echo $count;
          }else{
            echo 0;
          }
          ?>)</span></strong>
          <span class="cart_price">
            <?php

            $khachhang = $this->session->userdata('sessionKhachHang');
            if($this->session->userdata('cart') || $khachhang):

                if ($khachhang && $this->session->userdata('cart'.$khachhang['id'])) {
                    $cart =$this->session->userdata('cart'.$khachhang['id']);
                }
                else if ($this->session->userdata('cart'))
                {
                    $cart = $this->session->userdata('cart');
                }
                else {
                    $cart = [];
                }

              $money=0;
              foreach ($cart as $key => $value) :
                $row = $this->Mproduct->product_detail_id($key);?>
                <?php
                  foreach ($value as $child):
                      $sum = $child['price'] * $child['quantity'];
                      $money += $sum;
                  endforeach;
                ?>
              <?php endforeach; ?>
              <?php echo number_format($money).' VNĐ';?>
              <?php else : ?>
                <p>0 VNĐ</p>
              <?php endif; ?>
            </span>
          </span>
        </a>
        <div class="cart_clone_box">
          <div class="cart_box_wrap hidden">
           <div class="cart_item original clearfix">
            <div class="cart_item_image">
            </div>
            <div class="cart_item_info">
             <p class="cart_item_title"><a href="" title=""></a></p>
             <span class="cart_item_quantity"></span>
             <span class="cart_item_price"></span>
             <span class="remove"></span>
           </div>
         </div>
       </div>
     </div>
   </div>
   <!-- End Cart -->
   <!-- Account -->
       <div style="margin-left: 30px" class="header_info">
          <a href="thong-tin-khach-hang" title="Tài khoản">
            <div class="info-icon">
            <i class="fas fa-user"></i>

            </div>
            <div class="box_text">
                <?php
                if($this->session->userdata('sessionKhachHang')) {
                    $name = $this->session->userdata('sessionKhachHang_name');
                    echo '<strong>' . $name . '</strong>';
                }
                else {
                    echo '<strong>Tài khoản</strong>';

                }
                ?>

            </div>
          </a>
        </div>
       </div>
</div>
</div>
</section>
<script>
  $(document).ready(function(){
   load_data();
   var strurl="<?php echo base_url();?>"+'/search/quick';
   function load_data(query) {
    $.ajax({
      url: strurl,
      method:"POST",
      data:{query:query},
      success:function(data){
        if(data){
          $('#result').html(data);
        }else{
          $('#result').html(data);
        }
      }
    })
  }
  $('#search_text').keyup(function(){
    var search = $(this).val();
    if(search != '')
    {
     load_data(search);
   }
   else
   {
     load_data();
   }
 });
});
</script>