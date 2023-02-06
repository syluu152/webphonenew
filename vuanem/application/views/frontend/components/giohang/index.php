<div class="row content-cart">
	<div class="container">
		<?php
        $khachhang = $this->session->userdata('sessionKhachHang');
        if($this->session->userdata('cart') || $khachhang) {

            if ($khachhang && $this->session->userdata('cart'.$khachhang['id'])) {
                $cart = $this->session->userdata('cart'.$khachhang['id']);
                if (count($cart) > 0 ) {
                    foreach ($cart as $key => $value) {
                        $row = $this->Mproduct->product_detail_id($key);
                        if (!$row) {
                            unset($cart[$key]);
                        }
                    }
                    $this->session->set_userdata('cart'.$khachhang['id'],$cart);
                    if (count($cart) == 0 ) {
                        redirect('gio-hang');
                    }
                }
            }
            else if ($this->session->userdata('cart'))
            {
                $cart = $this->session->userdata('cart');
                if (count($cart) > 0 ) {
                    foreach ($cart as $key => $value) {
                        $row = $this->Mproduct->product_detail_id($key);
                        if (!$row) {
                            unset($cart[$key]);
                        }
                    }
                    $this->session->set_userdata('cart',$cart);
//
                }
                if (count($cart) == 0 ) {
                    redirect('gio-hang');
                }
            }
            else {
                $cart = [];
            }
        }
        else {
            $cart = [];
        }

			?>
        <?php if (count($cart) > 0): ?>
			<form action="" method="post" id="cartformpage">
				<div class="cart-index">
				<h2 class="title-page text-center">Chi tiết giỏ hàng</h2>
					<div class="tbody text-center">
						<div class="col-xs-12 col-12 col-sm-12 col-md-8 col-lg-8">

							<table class="table table-list-product">

								<thead>
									<tr style="background: #f3f3f3;">
										<th>Hình ảnh</th>
										<th>Tên sản phẩm</th>
										<th>Kích thước</th>
										<th class="text-center">Đơn giá</th>
										<th class="text-center">Số lượng</th>
										<th class="text-center">Thành tiền</th>
										<th class="text-center">Xóa</th>
									</tr>
								</thead>
                                <tbody>
                                <?php
                                foreach ($cart as $key => $value) :
                                    $row = $this->Mproduct->product_detail_id($key);
                                    ?>
                                <?php foreach ($value as $key_child => $child): ?>
                                    <tr>
                                        <td class="img-product-cart">
                                            <a href="<?php echo $row['alias'] ?>">
                                                <img src="public/images/products/<?php echo $row['avatar'] ?>" alt="<?php echo $row['name'] ?>">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo $row['alias'] ?>" class="pull-left"><?php echo $row['name'] ?></a>
                                        </td>
                                        <td style="color: black">
                                            <?= $key_child ?>
                                        </td>
                                        <td>
												<span class="amount">
													<?php
                                                    if($row['price_sale'] > 0){
                                                        echo (number_format($child['price'])).' VNĐ';
                                                    } else {
                                                        echo (number_format($child['price'])).' VNĐ';
                                                    }
                                                    ?>
												</span>
                                        </td>
                                        <td>
                                            <div class="quantity clearfix">
                                                <input name="quantity" id="<?php echo $row['id']?>" class="form-control" type="number" value="<?php echo $child['quantity'] ?>" min="1" max="1000" onchange="onChangeSL('<?php echo $row['id'] ?>','<?= $key_child ?>')">
                                            </div>
                                        </td>
                                        <td>
												<span class="amount">
													<?php
                                                    if($row['price_sale'] > 0){
                                                        echo (number_format($child['price']*$child['quantity'])).' VNĐ';
                                                    }else{
                                                        echo (number_format($child['price']*$child['quantity'])).' VNĐ';
                                                    }
                                                    ?>
												</span>
                                        </td>
                                        <td>
                                            <a class="remove" title="Xóa" onclick="onRemoveProduct('<?php echo $row['id']; ?>','<?php echo $key_child; ?>')"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                <?php endforeach; ?>
                                </tbody>
							</table>
							<button class="btn" onclick="window.location.href='san-pham'"> <a href="<?php echo base_url() ?>san-pham">Tiếp tục mua hàng</a></button>
						</div>
						<?php $total = 0; ?>
						<?php foreach ($cart as $key => $value) :
							$row = $this->Mproduct->product_detail_id($key);?>
							<?php
                            foreach ($value as $keychild=> $child):
                                    $sum = $child['price'] * $child['quantity'];
                                $total += $sum;
                            endforeach;
							?>
						<?php endforeach; ?>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="clearfix btn-submit" style="padding-left: 10px;margin-top: 20px;">
								<table class="table total-price" style="border: 1px solid #ececec;">
									<tbody>
										<tr style="background: #f4f4f4;">
											<td>Tổng tiền</td>
											<td><strong><?php echo (number_format($total)).' VNĐ'; ?></strong></td>
										</tr>
										<tr>
											<td colspan="2"><h5>Mua hàng trực tiếp tại cửa hàng giảm giá 5%</h5></td>
										</tr>
										<tr>
											<td colspan="2"><h5>Nếu đặt online Bạn hãy đồng ý với điều khoản sử dụng & hướng dẫn hoàn trả.</h5></td>
										</tr>
										 
										<tr>

											<td colspan="2">
												<button type="button" onclick="window.location.href='info-order'" class="btn-next-checkout">Đặt hàng</button>
											</td>
										</tr>
									</tbody>
								</table>

							</div>
						</div>
					</div>

				</div>

			</form>
		<?php endif;?>
        <?php   if (count($cart) <= 0 ): ?>
				<div class="cart-info">
					Chưa có sản phẩm nào trong giỏ hàng !
					<br>	
					<button class="btn" onclick="window.location.href='san-pham'"> Tiếp tục mua hàng</button>
				</div>


			<?php endif;?>
		</div>

	</div>
	<script>
		function onChangeSL(id,type){
			var sl = document.getElementById(id).value;
			var strurl="<?php echo base_url();?>"+'/sanpham/update';
			jQuery.ajax({
				url: strurl,
				type: 'POST',
				dataType: 'json',
				data: {id: id,type :type , sl:sl},
				success: function(data) {
					document.location.reload(true);
				}
			});
		}
		function onRemoveProduct(id,type) {
			var strurl="<?php echo base_url();?>"+'/sanpham/remove';
			jQuery.ajax({
				url: strurl,
				type: 'POST',
				dataType: 'json',
				data: {id: id,type : type},
				success: function(data) {
					document.location.reload(true);
					alert('Xóa sản phẩm thành công !!');
				}
			});
		}
	</script>