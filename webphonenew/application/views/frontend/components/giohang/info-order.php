<?php echo form_open('info-order'); ?>
<?php
$khachhang = $this->session->userdata('sessionKhachHang');
$user = $this->session->userdata('sessionKhachHang');
if ((!$this->session->userdata('cart') && !$khachhang) ||(!$this->session->userdata('cart') && !$this->session->userdata('cart'.$khachhang['id'])) ) {
    redirect('gio-hang');
} else {
    $user = $this->session->userdata('sessionKhachHang');
}
?>
<?php

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


        }
    }
    else {
        $cart = [];
    }
}
else {
    $cart = [];
}
if (count($cart) <= 0) {
    redirect('gio-hang');
}


if (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] != '') {
    redirect('/confirm-checkout' . '?' . $_SERVER['QUERY_STRING']);
}
if (isset($_GET['resultCode']) && $_GET['resultCode'] != '') {
    redirect('/confirm-checkout' . '?' . $_SERVER['QUERY_STRING']);
}
?>
<section id="checkout-cart">
    <div class="container">
        <div class="col-md-12">
            <div class="wrapper overflow-hidden">
                <form action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" name='info-order'
                      novalidate>
                    <?php
                    if (!$this->session->userdata('sessionKhachHang')) {
                        echo ' <div style="font-size: 16px; padding-top: 10px; color: #868686;">
                     B???n c?? t??i kho???n? 
                     <a href="dang-nhap" style="color:#0d94b0 ">???n v??o ????y ????? ????ng nh???p</a>
                     </div>';
                    }
                    ?>
                    <div class="checkout-content">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-login-checkout" style="margin-bottom: 20px">

                            <p class="text-center" style="margin: 5px 0;color: #f00e26">?????a ch??? giao h??ng c???a qu??
                                kh??ch</p>
                            <div class="wrap-info"
                                 style="width: 100%; min-height: 1px; overflow: hidden; padding: 10px;">
                                <table class="table table-info-checkout tinfo" style="width: 97%;">
                                    <tbody>
                                    <tr>
                                        <!--                                    <td class="width30 text-left td-right-order"></td>-->
                                        <td colspan="2">
                                            <div class="form-inline">
                                                <label>Kh??ch h??ng: <span class="require_symbol">* </span></label>
                                                <input type="text" class="form-control" placeholder="H??? v?? t??n"
                                                       name="name"
                                                       value="<?php echo $user['fullname'] ?? ($_POST['name'] ?? "") ?>" <?php if ($this->session->userdata('sessionKhachHang')) echo 'readonly' ?>>
                                                <div class="error"><?php echo form_error('name') ?></div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="form-inline">
                                                <label>Email: <span class="require_symbol">* </span></label>
                                                <input type="text" class="form-control"
                                                       name="<?php if ($this->session->userdata('sessionKhachHang') ?? false) echo 'tv'; else echo 'email' ?>"
                                                       value="<?php echo $user['email'] ?? ($_POST['email'] ?? "") ?>"
                                                       placeholder="Email" <?php if ($this->session->userdata('sessionKhachHang')) echo 'readonly' ?>>
                                                <div class="error"><?php echo form_error('email') ?></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <div class="form-inline">
                                                <label for="">S??? ??i???n tho???i: <span
                                                            class="require_symbol">* </span></label>
                                                <input type="text" class="form-control" placeholder="S??? ??i???n tho???i"
                                                       name="phone"
                                                       value="<?php echo $user['phone'] ?? ($_POST['phone'] ?? "") ?>" <?php if ($this->session->userdata('sessionKhachHang')) echo 'readonly' ?>>
                                                <div class="error"><?php echo form_error('phone') ?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="form-inline">
                                                <label for="">T???nh/Th??nh ph???: <span
                                                            class="require_symbol">* </span></label>
                                                <select name="city" id="province" onchange="renderDistrict()"
                                                        class="form-control next-select">
                                                    <option value="">--- Ch???n t???nh th??nh ---</option>
                                                    <?php $list = $this->Mprovince->province_all();
                                                    foreach ($list as $row):?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="error"><?php echo form_error('city') ?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="form-inline">
                                                <label for="">Qu???n/Huy???n: <span class="require_symbol">* </span></label>
                                                <select name="DistrictId" id="district"
                                                        class="form-control next-select">
                                                    <option value="">--- Ch???n qu???n huy???n ---</option>
                                                </select>
                                                <div class="error"><?php echo form_error('DistrictId') ?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="form-inline">
                                                <label for="">?????a ch??? giao h??ng: <span class="require_symbol">* </span></label>
                                                <textarea name="address" placeholder="?????a ch??? giao h??ng:"
                                                          class="form-control" rows="4" ="" style=
                                                "height: auto !important
                                                ;"
                                                ><?php echo $user['address'] ?? ($_POST['address'] ?? "") ?></textarea>
                                                <div class="error"><?php echo form_error('address') ?></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <div class="form-inline">
                                                <label for="">M?? gi???m gi?? (n???u c??):</label>
                                                <input id="coupon" style="border-radius: 5px; border-color: #0f9ed8;"
                                                       type="text" class="form-control" placeholder="M?? gi???m gi??"
                                                       name="coupon">

                                                <div class="error" style="margin: 0" id="result_coupon"></div>
                                                <a class="check-coupon mt-3" title="m?? gi???m gi??"
                                                   onclick="checkCoupon()">S??? d???ng</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="form-inline">
                                                <label for="">Ch???n ph????ng th???c thanh to??n:</label>
                                                <div class="box-payment-item">
                                                    <input id="tienmat"
                                                           style="border-radius: 5px; border-color: #0f9ed8;"
                                                           type="radio" checked value="normal" class="" name="payment">
                                                    <label for="tienmat"><img style="margin-right: 8px;"
                                                                              src="public/images/icon-money.svg"><span
                                                                class="ml-1">Thanh to??n ti???n m???t</span></label>
                                                </div>
                                                <div class="box-payment-item">
                                                    <input id="vietnampay"
                                                           style="border-radius: 5px; border-color: #0f9ed8;"
                                                           type="radio" value="vnpay" class="" name="payment">
                                                    <label for="vietnampay"><img style="max-width: 32px"
                                                                                 src="public/images/icon-vnpay.png"><span
                                                                class="ml-1">Thanh to??n b???ng v?? VNPAY</span></label>
                                                </div>
                                                <div class="box-payment-item">
                                                    <input id="momomo"
                                                           style="border-radius: 5px; border-color: #0f9ed8;"
                                                           type="radio" value="momo" class="" name="payment">
                                                    <label for="momomo"><img src="public/images/icon-momo.svg"><span
                                                                class="ml-1">Thanh to??n b???ng v?? MoMo</span></label>
                                                </div>
                                                <div class="box-payment-item">
                                                    <input id="momomoqr"
                                                           style="border-radius: 5px; border-color: #0f9ed8;"
                                                           type="radio" value="qr-momo" class="" name="payment">
                                                    <label for="momomoqr"><img src="public/images/icon-momo.svg"><span
                                                                class="ml-1">Thanh to??n b???ng QR MoMo</span></label>
                                                </div>
                                                <div style="height: 20px"></div>
                                                <?php
                                                if ($this->session->userdata('error_momo')) {
                                                ?>
                                                    <span class="text-danger"><?=$this->session->userdata('error_momo')?></span>
                                                <?php
                                                    $this->session->unset_userdata('error_momo');
                                                }
                                                ?>
                                            </div>

                                        </td>
                                        <td colspan="1">
                                            <!--                                        <a class="check-coupon" title="m?? gi???m gi??" onclick="checkCoupon()">S??? d???ng</a>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">
                                            <div class="btn-checkout frame-100-1 overflow-hidden border-pri"
                                                 style="float: left;">
                                                <button type="submit" style="width: 300px"
                                                        class="bg-pri border-pri col-fff button-order" name="dathang">
                                                    ?????t h??ng
                                                </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 products-detail">
                        <div class="no-margin-table col-login-checkout" style="width: 100%;">
                            <p class="text-center" style="margin: 5px 0;color: #f00e26">Th??ng tin ????n h??ng</p>
                            <table class="table table-info-order" style="color: #333">
                                <thead>
                                <tr>
                                    <th style="text-align: left">S???n ph???m</th>
                                    <th>K??ch th?????c</th>
                                    <th>S??? l?????ng</th>
                                    <th>Gi??</th>
                                    <th>T???ng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($this->session->userdata('cart') || $khachhang ):
                                    if ($khachhang && $this->session->userdata('cart'.$khachhang['id'])) {
                                        $data = $this->session->userdata('cart'.$khachhang['id']);

                                    }
                                    else {
                                        $data = $this->session->userdata('cart');
                                    }
                                    $money = 0;
                                    foreach ($data as $key => $value) :
                                        $row = $this->Mproduct->product_detail_id($key);
                                        foreach ($value as $keychild => $child):

                                            ?>

                                            <tr>
                                                <td class="left"><?php echo $row['name']; ?></td>
                                                <td><?php echo $keychild ?></td>
                                                <td class="text-center"><?php echo $child['quantity'] ?></td>
                                                <td>
                                                    <?php
                                                    echo number_format($child['price']) . ' VN??';
                                                    ?>
                                                </td>
                                                <td style="text-align: right">
                                                    <?php
                                                    $total = 0;
                                                    $total = $child['price'] * $child['quantity'];
                                                    $money += $total;
                                                    echo number_format($total) . ' VN??';
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    endforeach; ?>
                                <?php endif; ?>
                                <td>
                                    <tr>
                                        <td class="left" colspan="3">T???ng c???ng :</td>
                                        <td class="right" colspan="2"
                                            style="text-align: right;"><?php echo number_format($money) ?> VN??
                                        </td>
                                    </tr>
                                </td>
                                <tr>
                                    <td class="left" colspan="4">
                                        <p style="font-size: 12px;">(Ph?? giao h??ng)</p>
                                    </td>
                                    <td style="float: right;"><?php echo number_format($this->Mconfig->config_price_ship()) . ' VN??'; ?> </td>
                                </tr>

                                <?php
                                if ($this->session->userdata('coupon_price')) {
                                    $price_coupon_money = $this->session->userdata('coupon_price');
                                    $price_coupon = number_format($this->session->userdata('coupon_price'));
                                    echo '
                            <td class="left" colspan="4">Voucher gi???m gi??: </td>
                            <td>
                            <p style="float:right;"> -' . $price_coupon . ' VN??</p> 
                            <td class="left" style="cursor: pointer;"><a onclick="removeCoupon()"><i class="fas fa-times"></i></a></td>
                            </td>
                            ';

                                }
                                ?>
                                <tr style="background: #f4f4f4">
                                    <td class="left" colspan="4">
                                        <p style="font-size: 15px; color: red;">Th??nh ti???n</p>
                                        <span style="font-weight: 100; font-style: italic;">(T???ng s??? ti???n thanh to??n)</span>
                                    </td>


                                    <td class="text-right" style="text-align: right">
                                        <p style="font-size: 15px; color: red;">
                                            <?php if (isset($price_coupon_money)) {
                                                $money_pay = ($money + $this->Mconfig->config_price_ship()) - $price_coupon_money;
                                            } else {
                                                $money_pay = $money + $this->Mconfig->config_price_ship();
                                            }
                                            echo number_format($money_pay) . ' VN??'; ?>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        <?php
        if ($this->session->userdata('data_checkout') ) {
        $data = $this->session->userdata('data_checkout');
        ?>
        $("input[name='name']").val('<?=$data['name']?>');
        $("input[name='email']").val('<?=$data['email']?>');
        $("input[name='phone']").val('<?=$data['phone']?>');
        $("select[name='city']").val('<?=$data['provinceId']?>').change();
        $("textarea[name='address']").val('<?=$data['address']?>');
        setTimeout(() => {
            $("select[name='DistrictId']").val('<?=$data['districtId']?>').change();
        }, 1000);
        <?php } ?>
    });

    function renderDistrict() {
        var provinceid = $("#province").val();
        var strurl = "<?php echo base_url();?>" + 'giohang/district';
        jQuery.ajax({
            url: strurl,
            type: 'POST',
            dataType: 'json',
            data: {'provinceid': provinceid},
            success: function (data) {
                $('#district').html(data);
            }
        });
    };

    function checkCoupon() {
        var code = $("input[name='coupon']").val();
        var name = $("input[name='name']").val();
        var email = $("input[name='email']").val();
        var phone = $("input[name='phone']").val();
        var provinceId = $("select[name='city']").val();
        var districtId = $("select[name='DistrictId']").val();
        var address = $("textarea[name='address']").val();
        var strurl = "<?php echo base_url();?>" + 'giohang/coupon';
        jQuery.ajax({
            url : strurl,
            type : 'POST',
            dataType : 'json',
            data : {
                code : code,
                name : name,
                email : email,
                phone : phone,
                provinceId : provinceId,
                districtId : districtId,
                address : address,
            },
            success: function (data) {
                $('#result_coupon').html(data);
            }
        });
    }

    function removeCoupon() {
        var strurl = "<?php echo base_url();?>" + '/giohang/removecoupon';
        jQuery.ajax({
            url: strurl,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                $('#result_coupon').html(data);
                document.location.reload(true);
            }
        });
    }
</script>

<!-- error: (error) => {
                     console.log(JSON.stringify(error));
   } -->