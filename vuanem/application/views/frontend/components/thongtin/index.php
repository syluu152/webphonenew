<section id="content">
	<div class="container account">
        <aside class="col-right sidebar col-md-3 col-xs-12">
            <div class="block block-account">
                <div class="general__title">
                    <h2 class="title-page"><span>Thông tin tài khoản</span></h2>
                </div>
                <div class="block-content">
                    <p>Tài khoản: <strong><?php echo $info['username'] ?></strong></p>
                    <p>Họ và tên: <strong><?php echo $info['fullname'] ?></strong></p>
                    <p>Email: <strong><?php echo $info['email'] ?></strong></p>
                    <p>Số điện thoại: <strong><?php echo $info['phone'] ?></strong></p>
                </div>
                <button class="btn btn-warning"><a href="reset_password">Đổi mật khẩu</a></button>
            </div>
        </aside>
        <div class="col-main col-md-9 col-sm-12">
            <div class="my-account ">

                <?php if($this->Minfocustomer->order_listorder_customerid_not($info['id']) != null)
                { ?>
                    <div class="general__title">
                        <h2  class="title-page"><span>Danh sách đơn hàng chưa duyệt</span></h2>
                    </div>
                    <table class="table-order table" style="padding-right: 10px; width: 100%;">
                        <thead>
                            <tr>
                                <th >Đơn hàng</th>
                                <th >Ngày</th>
                                <th>
                                    Giá trị đơn hàng 
                                </th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody style="">
                            <?php $order = $this->Minfocustomer->order_listorder_customerid_not($info['id']);
                            foreach ($order as $value):?>
                                <tr>
                                    <td style="padding:5px 10px;">#<?php echo $value['orderCode'] ?></td>
                                    <td style="padding:5px 10px;"><?php echo $value['orderdate'] ?></td>
                                    <td style="text-align: center; padding:5px 10px;"><span class="price-2"><?php echo number_format($value['money']) ?> VNĐ</span></td>
                                    <td style="padding:5px 10px; text-align: center;">
                                       <?php
                                       switch ($value['status']) {
                                        case '0':
                                        echo 'Đang đợi duyệt';
                                        break;
                                    }
                                    $id = $value['id'];
                                    ?>
                                </td>
                                <td>
                                    <div  style="display: flex;align-items: center;justify-content: space-around;">
                                    <a style="color: #0f9ed8;" href="account/orders/<?php echo $value['id'] ?>">Xem chi tiết</a>
                                    <a style="color: red;" href="thongtin/update/<?php echo $value['id'];?>" onclick="return confirm('Xác nhận hủy đơn hàng này ?')">Hủy đơn hàng</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
            
            <div class="general__title">
                <h2  class="title-page"><span>Danh sách đơn hàng</span></h2>
            </div>
            <div class="">
                <table class="table-order table" style="padding-right: 10px; width: 100%;">
                    <thead style="border: 1px solid silver;">
                        <tr>
                            <th>Đơn hàng</th>
                            <th>Ngày</th>
                            <th>
                                Giá trị đơn hàng 
                            </th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody style=";">
                        <?php $order = $this->Minfocustomer->order_listorder_customerid($info['id']);
                        foreach ($order as $value):?>
                            <tr>
                                <td >#<?php echo $value['orderCode'] ?></td>
                                <td><?php echo $value['orderdate'] ?></td>
                                <td><span class="price-2"><?php echo number_format($value['money']) ?> VNĐ</span></td>
                                <td>
                                   <?php
                                   switch ($value['status']) {
                                    case '0':
                                    echo 'Đang đợi duyệt';
                                    break;
                                    case '1':
                                    echo 'Đang giao hàng';
                                    break;
                                    case '2':
                                    echo 'Đã giao';
                                    break;
                                    case '3':
                                    echo 'Khách hàng đã hủy';
                                    break;
                                    case '4':
                                    echo 'Nhân viên đã hủy';
                                    break;
                                }
                                $id = $value['id'];
                                ?>
                            </td>
                            <td>
                                <span> <a style="color: #0f9ed8;" href="account/orders/<?php echo $value['id'] ?>">Xem chi tiết</a></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>
</div>
</section>
