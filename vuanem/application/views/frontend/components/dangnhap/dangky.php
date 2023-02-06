<?php echo form_open('dang-ky'); ?>
<div class="bg-grey-new">
<section id="product-detail">
	<div class="container wrap-login">
		<div class="col-md-3 col-sm-3 hidden-xs"></div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="">
				<div class="accordion accordion-lg divcenter nobottommargin clearfix" style="">
					<div id="register">
						<div class="acctitle acctitlec new-title">Đăng ký</div>
						<?php 
						if(isset($success))
							echo '<h4 style="color:green;">'.$success.'</h4>';
						?>
						<div class="acc_content clearfix" style="display: block;">
							<form accept-charset="UTF-8" action="" id="customer_register" method="post">
								
								<input name="FormType" type="hidden" value="customer_register">
								<input name="utf8" type="hidden" value="true"> 
								<div class="col_full">
									<label for="first_name">Tên đăng nhập:<span class="require_symbol">*</span></label>
									<input type="text" id="first_name" name="username" value="<?=$_POST['username']??''?>" class="form-control" placeholder="Tên đăng nhập">
									<div class="error" id="username_error"><?php echo form_error('username')?></div>
								</div> 
								<div class="col_full">
									<label for="register-form-password">Mật khẩu:<span class="require_symbol">*</span></label>
									<input type="password" id="register-form-password" name="password" placeholder="Mật khẩu" class="form-control">
									<div class="error" id="password_error"><?php echo form_error('password')?></div>
								</div>

								<div class="col_full">
									<label for="register-form-repassword">Nhập lại mật khẩu:<span class="require_symbol">* </span></label>
									<input type="password" id="register-form-repassword" name="re_password" value="" class="form-control" placeholder="Nhập lại mật khẩu">
									<div class="error" id="re_password_error"><?php echo form_error('re_password')?></div>
								</div>
								<div class="col_full">
									<label for="first_name">Họ tên:<span class="require_symbol">*</span></label>
									<input type="text" id="first_name" name="name" placeholder="Họ tên" value="<?=$_POST['name']??''?>" class="form-control">
									<div class="error" id="name_error"><?php echo form_error('name')?></div>
								</div>              
								<div class="col_full">
									<label for="register-form-email">Email:<span class="require_symbol">*</span></label>
									<input type="text" id="register-form-email" name="email" class="form-control" value="<?=$_POST['email']??''?>" placeholder="Nhập email">
									<div class="error" id="email_error"><?php echo form_error('email')?></div>
								</div>
								<div class="col_full">
									<label for="first_name">Số điện thoại:<span class="require_symbol">*</span></label>
									<input type="text" id="first_name" name="phone" placeholder="Số điện thoại" value="<?=$_POST['phone']??''?>" class="form-control">
									<div class="error" id="name_error"><?php echo form_error('phone')?></div>
								</div>
								<div class="wrap-button">
									<button class="button button-3d button-black nomargin" id="register-form-submit" name="register-form-submit" type="submit" style="margin-bottom: 20px">Đăng ký</button>
                                    <div class="button-bottom">
										<a href="<?php echo base_url()?>dang-nhap" style="">Đã có tài khoản - đăng nhập</a>
                                    </div>
                                </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-3 hidden-xs"></div>
	</div>
</section>
</div>