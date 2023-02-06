<section id="product-detail">
	<div class="container">
		<div class="products-wrap">
			<form action="" method="post" id="ProductDetailsForm">
				<?php if($row):?>
					<div class="breadcrumbs">
						<ul>
							<li class="home">
								<a href="trang-chu" title="Go to Home Page">Trang chủ</a>
								<i class="fa fa-angle-right"></i>
							</li>
							<li class="category3">
								<a href="<?php echo base_url() ?>/san-pham/<?php $link=$this->Mcategory->category_link($row['catid']); echo $link; ?>" title=""><?php $name=$this->Mcategory->category_name($row['catid']); echo $name; ?></a>
								<i class="fa fa-angle-right"></i>
							</li>
							<li class="product"><?php echo $row['name'] ?></li>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 listimg-desc-product">
						<?php $this->load->view('frontend/modules/jcarousel');?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="product-view-content">
							<div class="product-view-name">
								<h1><?php echo $row['name'] ?></h1>
							</div>
							<div class="product-view-price">
								<div class="pull-left">
									<span class="price-label">Giá bán:</span>
									<span class="price price-product"><?php echo number_format($row['price_sale'])?>₫</span>
								</div>
								<?php if($row['price_sale']>0 && $row['sale']>0): ?>
									<div class="product-view-price-old">
										<span class="price"><?php echo number_format($row['price']) ?>₫</span>
										<span class="sale-flag">-<?php echo $row['sale'] ?>%</span>
									</div>
								<?php endif; ?>
							</div>
							<div class="product-status">
								<p style=" float: left;margin-right: 10px;">Thương hiệu: <?php $name=$this->Mcategory->category_name($row['catid']); echo $name; ?></p>
								<p>| Tình trạng: <?php if($row['number'] - $row['number_buy']==0 || $row['status'] == 0) echo 'Hết hàng'; else echo 'Còn hàng' ?></p>
							</div>
							<div class="product-view-desc">
								<h4>Mô tả:</h4>
								<p><?php echo $row['sortDesc'] ?></p>
							</div>
                            <h4 class="mb-3">Kích thước:</h4>
                            <div class="option-product-list mb-4">
                                <?php $i = 0;
//                                var_dump(json_decode($row['option']));
                                foreach (json_decode($row['option']) as $key=>$item) {

                                    ?>
                                    <div class="option-item">
                                        <input <?= $i == 0?"checked":""?> id="option-item-<?=$key?>" type="radio" value="<?= $item->price?>" name="option-product">
                                        <label for="option-item-<?=$key?>"><?= $item->value?></label>
                                    </div>
                                <?php
                                    $i++;
                                } ?>
                                <input type="hidden" value="" name="product_type">
                            </div>
							<div class="actions-qty">
								<?php
								if( $row['number'] - $row['number_buy']==0 || $row['status'] == 0) {
									echo'<h2 style="color:red;">Ngừng kinh doanh</h2>';
								} else { ?>
								<div class="actions-qty__button">
									<button class="button btn-cart add_to_cart_detail detail-button" title="Mua ngay" type="button" aria-label="Mua ngay" class="fa fa-shopping-cart"  onclick="onAddCart('<?=$row["id"]?>','order')"> Mua ngay</button>
									<button style="width: 250px" class="button btn-cart add_to_cart_detail detail-button" title="Mua ngay" type="button" aria-label="Mua ngay" class="fa fa-shopping-cart" onclick="onAddCart('<?=$row["id"]?>')"> Thêm vào giỏ hàng</button>
								</div>
                                <?php
								}
								?>
							</div>
							<div class="fk-boxs" id="km-all" data-comt="False">
								<div id="km-detail">
									<p class="fk-tit">Khuyến mại đặc biệt (SL có hạn)</p>
									<div class="fk-main">
										<div class="fk-sales">
											</ul>
											<ul>
												<li>Tặng PMH 100,000đ (khi phiếu mua hàng trên 1.000,000 đ)</li>
											</ul>
											<ul>
												<li>MIỄN PHÍ GIAO HÀNG - Cho hóa đơn từ 500,000 đ <a href="#" target="_blank">Xem chi tiết</a>
												</li>
											</ul>
											<ul>
												<li>Mua từ 5 mặt hàng tổng giá trị 1.000.000đ sẽ được tặng mã giảm giá 50.000đ <br/> <a href="https://www.facebook.com/vochibao12345" target="_blank">Liên hệ</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div style="margin-top: 20px;">
								<b>ĐẶC TÍNH</b>
								<br>
								<span>Mềm mại, thoải mái, dễ vệ sinh</span>
							</div>
							<div style="margin-top: 20px;">
								<b>CHẤT LƯỢNG</b>
								<br>
								<span>Được làm từ 100% chất cao su tự nhiên</span>
							</div>
						</div>
					</div>
					<div class="product-v-desc col-md-10 col-12 col-xs-12">
						<h3>Đặc điểm nổi bật</h3>
						<?php echo $row['detail']?>
					</div>
					<div class="product-comment product-v-desc">
						<h3>Bình luận</h3>
						<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
							<div class="fb-comments" data-href="<?php echo base_url() ?><?php echo $row['alias'] ?>" data-numposts="5"></div>
						</div>
					</div>
					<div class="product-comment product-v-desc product">
						<h3>Sản phẩm liên quan</h3>
						<?php
						$list_spcungloai = $this->Mproduct->product_cungloai($row['catid'], $row['id'], 5);?>
						<?php 
						if(count($list_spcungloai)>0):?>
							<div class="product-container">
								<div class="owl-carousel-product owl-carousel owl-theme">
									<?php foreach ($list_spcungloai as $sp) :?>
										<div class="item">
											<div class="product-lt">
												<div class="lt-product-group-image">
													<a href="<?php echo $sp['alias'] ?>" title="<?php echo $sp['name'] ?>" >
														<img class="img-p"src="public/images/products/<?php echo $sp['avatar'] ?>" alt="">
													</a>

													<?php if($sp['sale'] > 0) :?>
														<div class="giam-percent">
															<span class="text-giam-percent">Giảm <?php echo $sp['sale'] ?>%</span>
														</div>
													<?php endif; ?>
												</div>

												<div class="lt-product-group-info">
													<a href="<?php echo $sp['alias'] ?>" title="<?php echo $sp['name'] ?>" style="text-align: left;">
														<h3><?php echo $sp['name'] ?></h3>
													</a>
													<div class="price-box">
														<?php if($sp['sale'] > 0) :?>

															<p class="old-price">
																<span class="price"><?php echo(number_format($sp['price'])); ?>₫</span>
															</p>
															<p class="special-price">
																<span class="price"><?php echo(number_format($sp['price_sale'])); ?>₫</span>
															</p>
															<?php else: ?>
																<p class="old-price">
																	<span class="price" style="color: #fff"><?php echo(number_format($sp['price'])); ?>₫</span>
																</p>
																<p class="special-price">
																	<span class="price"><?php echo(number_format($sp['price'])); ?>₫</span>
																</p>
															<?php endif;?>
														</div>
														<div class="clear"></div>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
									<?php else: ?>
										<h4>Chưa có sản phẩm cùng loại</h4>
									<?php endif; ?>
								</div>
							<?php endif; ?>	
						</form>

					</div>
				</div>
			</section>
			<script>
                function format_money(value ){
                    return new Intl.NumberFormat().format(value)+"₫";
                }
                $(document).ready(function (){
                    let price = $('input[name="option-product"]:checked').val();
                    $('input[name="product_type"]').val($('input[name="option-product"]:checked').siblings('label').text());
                    $('.price-product').text(format_money(price));
                });
                $('input[name="option-product"]').change(function(){
                    $('.price-product').text(format_money($(this).val()));
                    $('input[name="product_type"]').val($('input[name="option-product"]:checked').siblings('label').text());
                })
				function onAddCart(id, type = 'default'){
					var strurl="<?php echo base_url();?>"+'sanpham/addcart';
                    let data = {
                        id: id,
                    }
                    if (type != null) {
                        data.order = type;
                    }
                    if ($('input[name="option-product"]:checked').val()) {
                        data.price = $('input[name="option-product"]:checked').val();
                    }
                    if ($('input[name="product_type"]').val()!='')  data.type = $('input[name="product_type"]').val();
                    jQuery.ajax({
						url: strurl,
						type: 'POST',
						dataType: 'json',
						data: data,
						success: function(data) {
                            console.log(data);
                            if (data['order'] === 'order') {
                                document.location.href='info-order';
                            }else {
                                document.location.reload(true);
                                alert('Thêm sản phẩm vào giỏ hàng thành công !');
                            }

						}
					});
				}
			</script>
