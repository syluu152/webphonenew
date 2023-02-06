<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Giohang extends CI_Controller
{
    protected $url;
    protected $config_mail;

    // Hàm khởi tạo và load các Model cần thiết
    function __construct()
    {

        parent::__construct();
        $this->load->model('frontend/Morder');
        $this->load->model('frontend/Mproduct');
        $this->load->model('frontend/Morderdetail');
        $this->load->model('frontend/Mcustomer');
        $this->load->model('frontend/Mcategory');
        $this->load->model('frontend/Mconfig');
        $this->load->model('frontend/Mdistrict');
        $this->load->model('frontend/Mprovince');
        $this->data['com'] = 'giohang';
        $this->url = base_url();
    }

    // Hàm index - hiển thị thông tin giỏ hàng
    public function index()
    {
        $this->data['title'] = 'Cellphones - Giỏ hàng của bạn';
        $this->data['view'] = 'index';
        $this->load->view('frontend/layout', $this->data);
    }
    // hàm check mail - kiểm tra email nhập vào đã là thành viên hay chưa
    // nếu có sẽ bắt đăng nhập - nếu chưa sẽ cho phép đặt hàng ẩn danh
    function check_mail()
    {
        // nhận email từ request
        $email = $this->input->post('email');
        if ($this->Mcustomer->customer_detail_email($email)) {
            $this->form_validation->set_message(__FUNCTION__, 'Email đã đã là thành viên, Vui lòng đăng nhập hoặc nhập Email khác !');
            return FALSE;
        }
        return TRUE;
    }

    // hàm thông tin đặt hàng
    public function info_order()
    {
        // load các thư viện cần thiết
        $this->load->library('session');
        $this->load->helper('string');
        $this->load->library('email');
        $this->load->library('form_validation');
        $d = getdate();
        $today = $d['year'] . "/" . $d['mon'] . "/" . $d['mday'] . " " . $d['hours'] . ":" . $d['minutes'] . ":" . $d['seconds'];
        if (!$this->session->userdata('sessionKhachHang')) {
            $this->form_validation->set_rules('email', 'Địa chỉ email', 'required|is_unique[db_customer.email]');
        }
        // check validate các trường từ front end post lên
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
        $this->form_validation->set_rules('name', 'Họ và tên', 'required|min_length[3]');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'required');
        $this->form_validation->set_rules('city', 'Tỉnh thành', 'required');
        $this->form_validation->set_rules('DistrictId', 'Quận huyện', 'required');
        $priceShip = $this->Mconfig->config_price_ship();
        // Kiểm tra validate đã đúng điều kiện hay chưa
        if ($this->form_validation->run() == TRUE) {
            //Tinh tien don hang
            $money = 0;
            // kiểm tra giỏ hàng đã tồn tại hay chưa
            $khachhang = $this->session->userdata('sessionKhachHang');
            if ($this->session->userdata('cart') || $khachhang) {
                if ($khachhang && $this->session->userdata('cart' . $khachhang['id'])) {
                    $data = $this->session->userdata('cart' . $khachhang['id']);
                    if (count($data) > 0 ) {
                        foreach ($data as $key => $value) {
                            $row = $this->Mproduct->product_detail_id($key);
                            if (!$row) {
                                unset($data[$key]);
                            }
                        }
                        $this->session->set_userdata('cart'.$khachhang['id'],$data);
                        if (count($data) == 0 ) {
                            redirect('/gio-hang', 'refresh');
                        }
                    }
                } else {
                    $data = $this->session->userdata('cart');
                    if (count($data) > 0 ) {
                        foreach ($data as $key => $value) {
                            $row = $this->Mproduct->product_detail_id($key);
                            if (!$row) {
                                unset($data[$key]);
                            }
                        }
                        $this->session->set_userdata('cart',$data);
                    }
                    if (count($data) == 0 ) {
                        redirect('/gio-hang', 'refresh');
                    }
                }

                // tính tổng tiền đơn hàng
                foreach ($data as $key => $value) {
                    $row = $this->Mproduct->product_detail_id($key);
                    foreach ($value as $child) {
                        $sum = $child['price'] * $child['quantity'];
                        $money += $sum;
                    }
                }
            }
            // random mã đơn hàng
            $orderCode = random_string('alnum', 8);

            $idCustomer = null;
            // kiểm tra người dùng đã đăng nhập
            if ($this->session->userdata('sessionKhachHang')) {
                // get thông tin khách hàng đã đăng nhập
                $emailtemp = $this->session->userdata('email');
                $info = $this->session->userdata('sessionKhachHang');
                $idCustomer = $info['id'];
            } else {
                // nếu chưa đăng nhập lấy email từ front end gửi lên
                $emailtemp = $_POST['email'];
            }
            // Nếu người dùng chưa đăng nhập sẽ lấy thông tin từ form gửi lên và thêm khách hàng vào database
            if (!$this->session->userdata('sessionKhachHang')) {
                // khởi tạo mảng thông tin người dùng
                $datacustomer = array(
                    'fullname' => $_POST['name'],
                    'phone' => $_POST['phone'],
                    'email' => $emailtemp,
                    'created' => $today,
                    'status' => 1,
                    'trash' => 1
                );
                // Thêm thông tin người dùng vào database
                $this->Mcustomer->customer_insert($datacustomer);
                // get thông tin người dùng bằng email
                $row = $this->Mcustomer->customer_detail_email($_POST['email']);
                // set thông tin người dùng vào session
                $this->session->set_userdata('info-customer', $row);
                // get thông tin người dùng từ session
                $info = $this->session->userdata('info-customer');
                // kiểm tra và set id người dùng vào session
                if ($info['id']) {
                    $idCustomer = $info['id'];
                    $this->session->set_userdata('id-info-customer', $idCustomer);
                }
            }
            //kt ma giam gia
            if ($this->session->userdata('coupon_price')) {
                $coupon = $this->session->userdata('coupon_price');
                $idcoupon = $this->session->userdata('id_coupon_price');
                $amount_number_used = $this->Mconfig->get_amount_number_used($idcoupon);
                $mycoupon = array(
                    'number_used' => $amount_number_used + 1,
                );
                $this->Mconfig->coupon_update($mycoupon, $idcoupon);
            } else {
                $coupon = 0;
            }
            // get thông tin tỉnh , huyện từ front end
            $provinceId = $_POST['city'];
            $districtId = $_POST['DistrictId'];
            $total_order = $money + $priceShip - $coupon;
            // khởi tạo mảng thông tin đơn hàng
            $mydata = array(
                'orderCode' => $orderCode,
                'customerid' => $idCustomer,
                'orderdate' => $today,
                'fullname' => $_POST['name'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'money' => $total_order,
                'price_ship' => $priceShip,
                'coupon' => $coupon,
                'province' => $provinceId,
                'district' => $districtId,
                'trash' => 3,
                'status' => 0,
            );
            // kiểm tra phương thức thanh toán
            // 1. thanh toán khi nhận hàng
            // 2. Thanh toán bằng ví vnpay
            // 3. thanh toán bằng MOMO
            if ($_POST['payment'] == "normal") {
                $mydata['delivery_type'] = 1;
            } elseif ($_POST['payment'] == "vnpay") {
                $mydata['delivery_type'] = 2;
            } else {
                $mydata['delivery_type'] = 3;
            }
            // Thêm thông tin đơn hàng vào database
            $this->Morder->order_insert($mydata);
            // lưu tt đơn hàng và xóa session coupon
            $this->session->unset_userdata('id_coupon_price');
            $this->session->unset_userdata('coupon_price');
            if ($this->session->userdata('data_checkout')) {
                $this->session->unset_userdata('data_checkout');
            }
            //Get đơn hàng vừa được thêm
            $order_detail = $this->Morder->order_detail_customerid($idCustomer);
            // get ID đơn hàng
            $orderid = $order_detail['id'];
            // kiểm tra session của đơn hàng
            if ($this->session->userdata('cart') || $khachhang) {
                if ($khachhang && $this->session->userdata('cart'.$khachhang['id'])) {
                    $val = $this->session->userdata('cart'.$khachhang['id']);
                } else {
                    $val = $this->session->userdata('cart');
                }
                // Thêm thông tin chi tiết của đơn hàng vào database
                foreach ($val as $key => $value) {
                    $row = $this->Mproduct->product_detail_id($key);
                    foreach ($value as $keychild => $child) {
                        $sum = $child['price'] * $child['quantity'];
                        $price = $child['price'];
                        $product_name = $row['name'];
                        $option = $keychild;
                        $data = array(
                            'orderid' => $orderid,
                            'productid' => $key,
                            'price' => $price,
                            'count' => $child['quantity'],
                            'option' => $option,
                            'trash' => 1,
                            'status' => 1,
                            'productname' => $product_name,
                        );
                        // gọi model thêm thông tin chi tiết đơn hàng
                        $this->Morderdetail->orderdetail_insert($data);
                    }


                }
            }
            // Kiểm tra phương thức thanh toán
            // Nếu là normal tiến hành trỏ đến địa chỉ thankyou (Đặt hàng thành công )
            if ($_POST['payment'] == "normal") {
                redirect('/thankyou', 'refresh');
            } // nếu là thanh toán vnpay sẽ gọi đến function checkout vnpay
            elseif ($_POST['payment'] == "vnpay") {
                $this->checkout_vnpay($orderCode, $total_order);
            } // nếu là thanh toán bằng momo sẽ gọi đến function checkout momo
            else {
                $this->checkout_momo($orderCode, $total_order, $_POST['payment']);
            }
        } else {
            // ngược lại nếu không phải mothod post sẽ render giao diện info-order
            $this->data['title'] = 'Cellphones - Thông tin đơn hàng';
            $this->data['view'] = 'info-order';
            $this->load->view('frontend/layout', $this->data);
        }
    }

    // function thanh toán qua ví VNPay

    public function checkout_vnpay($orderCode, $money)
    {
        // get defaul time
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // các thông tin liên kết ví VNPay
        $vnp_TmnCode = "ULASBPET"; //Website ID in VNPAY System
        $vnp_HashSecret = "YDOMRJGTIJXOLPHGXMAZJNTZDEMSLOQJ"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = $this->url . "info-order";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        $vnp_TxnRef = $orderCode; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "other";
        $vnp_Amount = $money * 100;
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef);
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }

    // Function  thanh toán qua ví momo
    public function checkout_momo($orderCode, $money, $type)
    {
        // các config cần thiết để thanh toán bằng momo
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $amount = $money;
        $orderId = $orderCode;
        // wait
        $redirectUrl = $this->url . "info-order";
        $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $extraData = "";

        $requestId = time() . "";
        if ($type == 'momo') {
            $requestType = "payWithATM";
            $orderInfo = "Thanh toán qua MoMo";
        } else {
            $requestType = "captureWallet";
            $orderInfo = "Thanh toán qua QR MoMo";
        }


        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        //Just a example, please check more in there
        if (!$jsonResult['payUrl']) {
            $this->session->set_userdata('error_momo','Momo hiện tại đang bảo trì vui lòng thử lại sau !');
            redirect('/info-order', 'refresh');
        }
        header('Location: ' . $jsonResult['payUrl']);
    }

    // function xác nhận thanh toán qua ví điện tử
    public function confirm_checkout()
    {
        // kiểm tra phương thức thanh toán có phải là VNPay không
        if (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] != '') {
            $statusCode = $_GET['vnp_ResponseCode'];
            $orderCode = $_GET['vnp_TxnRef'];
            $payment_type = 'vnpay';
            // kiểm tra đã thanh toán thành công
            if ($statusCode == '00') {
                // thanh toan thanh cong
//                $this->thankyou('Thanh toán qua VNPay');
                redirect('/thankyou?type=Thanh toán qua VNPay', 'refresh');

            } // nếu chưa thanh toán thành công
            else {
                // get thông tin order đã lưu
                $order = $this->Morder->order_detail_by_code($orderCode);
                if ($order) {
                    // Xóa thông tin đơn hàng trong database
                    $this->Morderdetail->orderdetail_delete($order['id']);
                    $this->Morder->orders_delete($orderCode);
                }
                redirect('/info-order', 'refresh');
            }
        }
        // Kiểm tra phương thức thanh toán có phải thanh toán qua Momo
        else if (isset($_GET['resultCode']) && $_GET['resultCode'] != '') {
            $statusCode = $_GET['resultCode'];
            $orderCode = $_GET['orderId'];
            // kiểm tra trạng thái nếu  = 0 thì là thanh toán thành công
            if ($statusCode == '0') {
                // thanh toan thanh cong sẽ chuyen den function thankyou
                redirect('/thankyou?type=Thanh toán qua Momo', 'refresh');
            } else {
                // thanh toán không thành công - tiền hành xóa thông tin đơn hàng trong database
                $order = $this->Morder->order_detail_by_code($orderCode);
                if ($order) {
                    $this->Morderdetail->orderdetail_delete($order['id']);
                    $this->Morder->orders_delete($orderCode);
                }
                redirect('/info-order', 'refresh');
            }
        }
    }

    // functiuon cảm ơn ( có tác dụng xóa session thông tin giỏ hàng và send mail )
    public function thankyou($type = '')
    {
        $this->load->library('session');
        $khachhang = $this->session->userdata('sessionKhachHang');
        if ($khachhang && $this->session->userdata('cart' . $khachhang['id'])) {
            $array_items = array('cart' . $khachhang['id'], 'cart');
        } else {
            $array_items = array('cart');
        }
        $this->session->unset_userdata($array_items);
        if ($this->session->userdata('info-customer') || $this->session->userdata('sessionKhachHang')) {
            if ($this->session->userdata('sessionKhachHang')) {
                $val = $this->session->userdata('sessionKhachHang');
            } else {
                $val = $this->session->userdata('info-customer');
            }
            // get order cuối cùng
            $list = $this->Morder->order_detail_customerid($val['id']);
            // update trạng thái của order
            $this->Morder->order_update(array('trash' => 1), $list['id']);
            $data = array(
                'order' => $list,
                'customer' => $val,
                'orderDetail' => $this->Morderdetail->orderdetail_order_join_product($list['id']),
                'province' => $this->Mprovince->province_name($list['province']),
                'district' => $this->Mdistrict->district_name($list['district']),
                'priceShip' => $this->Mconfig->config_price_ship(),
                'coupon' => $list['coupon'],
                'delivery_type' => $_GET['type']??'Thanh toán khi nhận hàng',
            );
            $this->config_mail = $this->Mconfig->get_config();
            $this->data['customer'] = $val;
            $this->data['get'] = $list;
            $this->load->library('email');
            $this->load->library('parser');
            $this->email->clear();
            // config thông tin send mail
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_timeout'] = '7';
            $config['smtp_user'] = $this->config_mail['mail_smtp'];
            $config['smtp_pass'] = $this->config_mail['mail_smtp_password'];
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = 'html';
            $config['validation'] = TRUE;
            if ($_SERVER['REQUEST_METHOD']  == 'GET') {
            $this->email->initialize($config);
            $this->email->from($this->config_mail['mail_noreply'], $this->config_mail['title']);
            $this->email->to($val['email']);
            $this->email->subject('Công ty CP Đầu tư Cellphones');
            $body = $this->load->view('frontend/modules/email', $data, TRUE);
            $this->email->message($body);
            $this->email->send();
            }
            $datax = array('email' => '');
            $idx = $this->session->userdata('id-info-customer');
            $this->Mcustomer->customer_update($datax, $idx);
            $this->session->unset_userdata('id-info-customer', 'money_check_coupon');
        }
        $this->data['title'] = 'Cellphones - Kết quả đơn hàng';
        $this->data['view'] = 'thankyou';
        $this->load->view('frontend/layout', $this->data);
    }

    // get quận huyện theo id tỉnh thành phố
    public function district()
    {
        $this->load->library('session');
        $id = $_POST['provinceid'];
        $list = $this->Mdistrict->district_provinceid($id);
//        var_dump($list);
        $html = "<option value =''>--- Chọn quận huyện ---</option>";
        foreach ($list as $row) {
            $html .= '<option value = ' . $row["id"] . '>' . $row["name"] . '</option>';
        }
        echo json_encode($html);
    }

    // kiểm tra mã giảm giá
    public function coupon()
    {
        $d = getdate();
        $today = $d['year'] . "-" . $d['mon'] . "-" . $d['mday'];
        $html = '';
        // kiểm tra đơn hàng đã áp dụng mã giảm giá chưa
        if ($this->session->userdata('coupon_price')) {
            $html .= '<p>Mỗi đơn hàng chỉ áp dụng 1 Mã giảm giá !!</p>';
        } else {
            // kiểm tra mã giảm giá
            if (empty($_POST['code'])) {
                $html .= '<p>Vui lòng nhập Mã giảm giá nếu có !!</p>';
            } else {
                // KIỂM TRA SỐ TIỀN TRONG GIỎ HÀNG
                $money = 0;
                $khachhang = $this->session->userdata('sessionKhachHang');

                if ($khachhang || $this->session->userdata('cart')) {
                    if ($khachhang && $this->session->userdata('cart' . $khachhang['id'])) {
                        $data = $this->session->userdata('cart' . $khachhang['id']);

                    } else {
                        $data = $this->session->userdata('cart');

                    }
                    foreach ($data as $key => $value) {
                        $row = $this->Mproduct->product_detail_id($key);
                        foreach ($value as $child) {
                            $sum = $child['price'] * $child['quantity'];
                            $money += $sum;
                        }
                    }
                }
                //
                // KIỂM TRA MÃ GIẢM GIÁ CÓ TỒN TẠI KO
                $coupon = $_POST['code'];
                // get thông tin mã giảm giá bằng code mã giảm giá
                $getcoupon = $this->Mconfig->get_config_coupon_discount($coupon);
                // nếu không tồn tại trả về thông báo mã giảm giá không tồn tại
                if (empty($getcoupon)) {
                    $html .= '<p>Mã giảm giá không tồn tại!</p>';
                }
                foreach ($getcoupon as $value) {
                    if ($value['code'] == $coupon) {
                        // Kiểm tra các điều kiện sử dụng mã giảm giá
                        if (strtotime($value['expiration_date']) <= strtotime($today)) {
                            $html .= '<p>Mã giảm giá ' . $value['code'] . ' đã hết hạn sử dụng từ ngày ' . $value['expiration_date'] . ' !</p>';
                        } else if ($value['limit_number'] - $value['number_used'] == 0) {
                            $html .= '<p>Mã giảm giá ' . $value['code'] . ' đã hết số lần nhập !</p>';
                        } else if ($value['payment_limit'] >= $money) {
                            $html .= '<p> Mã giảm giá này chỉ áp dụng cho đơn hàng từ ' . number_format($value['payment_limit']) . ' đ trở lên !</p>';
                        } else {
                            $html .= '<script>document.location.reload(true);</script> <p>Mã giảm giá ' . $value['code'] . ' đã được kích hoạt !</p>';
                            $this->session->set_userdata('coupon_price', $value['discount']);
                            $this->session->set_userdata('id_coupon_price', $value['id']);
                        }
                    }
                }
            }
        }
        // get thông tin đặt hàng
        $data_checkout = array(
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'provinceId' => $_POST['provinceId'] ?? '',
            'districtId' => $_POST['districtId'] ?? '',
            'address' => $_POST['address'] ?? '',
        );
        //lưu thông tin đặt hàng vào session
        $this->session->set_userdata('data_checkout', $data_checkout);
        echo json_encode($html);
    }

    // xóa mã giảm giá đã áp dụng vào đơn hàng
    public function removecoupon()
    {
        $html = '<script>document.location.reload(true);</script>';
        $this->session->unset_userdata('coupon_price');
        $this->session->unset_userdata('id_coupon_price');
        echo json_encode($html);
    }

    // function hỗ trợ thanh toán bằng momo
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}
