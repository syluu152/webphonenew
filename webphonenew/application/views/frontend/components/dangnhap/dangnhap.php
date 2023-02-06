<?php echo form_open('dang-nhap'); ?>
<div class="bg-grey-new">
<div class="container">
	<div class="products-wrap">
		<div class="container wrap-login">
			<div class="col-md-3 col-sm-3 hidden-xs"></div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div id="login">
					<div class="acctitle acctitlec new-title">Đăng nhập</div>
					<div class="acc_content clearfix" style="display: block;">
						<form accept-charset="UTF-8" action="" id="customer_login" method="post">
							<div class="col_full">
								<label for="login-form-username">Tài khoản:<span class="require_symbol">* </span></label>
								<input type="text" id="login-form-username" name="username" value="<?=$_POST['username']??''?>" class="form-control">
								<div class="error" id="password_error"><?php echo form_error('username')?></div>
							</div>
							<div class="col_full">
								<label for="login-form-password">Mật khẩu:<span class="require_symbol">* </span></label>
								<input type="password" id="login-form-password" name="password" value="" class="form-control">
								<div class="error" id="password_error"><?php echo form_error('password')?></div>	
							</div>
							<?php  if(isset($error)):?>
								<div class="row">
									<?php echo "<p  style='color:red;margin-left: 20px;'>$error</p>"; ?>
								</div>
							<?php  endif;?>

                            <?php  if($this->session->userdata('error_login')):?>
                                <div class="row">
                                    <p  style='color:red;margin-left: 20px;'><?php echo $this->session->userdata('error_login') ?></p>
                                </div>
                            <?php  endif;
                            $this->session->unset_userdata('error_login')
                            ?>
<!--                            $this->session->set_unserdata('error_login',-->
							<div class="wrap-button">
								<button class="button button-3d button-black bg-button-blue nomargin pull-left" id="login-form-submit" name="login-form-submit" type="submit" value="login">Đăng nhập</button>
								<div class="button-bottom">
									<a href="quen-mat-khau" class="fright">Quên mật khẩu?</a>
									<a href="<?php echo base_url() ?>dang-ky" class="fright">Người dùng mới? Đăng ký tài khoản</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 hidden-xs"></div>
		</div>
	</div>
</div>
</div>