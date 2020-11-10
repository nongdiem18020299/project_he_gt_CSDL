<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Đăng Ký Thành Viên Mới</h2>
    </div>
    <!-- End Box Head -->
    <form method="post" action="register.php" enctype="multipart/form-data">
        <!-- Form -->
        <div class="form">
            <table>
                <tr>
                    <td>
                        <label>Họ Tên</label>
                        <input type="text" name="hoten" class="field size1" required maxlength="255" >
                    </td>
                    <td>
                        <label>Tên Đăng Nhập</label>
                        <input type="text" name="tendangnhap" class="field size1" required maxlength="100">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Ngày Sinh</label>
                        <input type="date" name="ngaysinh" class="field size1" required />
                    </td>
                    <td>
                        <label>Địa Chỉ</label>
                        <input type="text" name="diachi" class="field size1" required maxlength="255"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Email</label>
                        <input type="email" name="email" class="field size1" required maxlength="50" />
                    </td>
                    <td>
                        <label>Số Điện Thoại</label>
                        <input type="text" name="sodt" class="field size1" required maxlength="20" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Số CMND</label>
                        <input type="text" name="socmnd" class="field size1" required maxlength="15" />
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Hình CMND Mặt Trước</label>
                        <input type="file" name="imgcmndt" accept="image/png" class="field size1" required />
                    </td>
                    <td>
                        <label>Hình CMND Mặt Sau</label>
                        <input type="file" name="imgcmnds" accept="image/png" class="field size1" required />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Hình Đại Diện</label>
                        <input type="file" name="imgavatar" accept="image/png" class="field size1" required />
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Mật Khẩu Đăng Nhập</label>
                        <input type="password" name="pass" class="field size1" required />
                    </td>
                    <td>
                        <label>Nhập Lại Mật Khẩu Đăng Nhập</label>
                        <input type="password" name="repass" class="field size1" required />
                    </td>
                </tr>
            </table>
        </div>
        <!-- End Form -->
        <!-- Form Buttons -->
        <div class="buttons">
            <input type="submit" class="button" value="Đăng Ký" />
            <input type="reset" class="button" value="Điền lại" />
        </div>
        <!-- End Form Buttons -->
    </form>
</div>

<?php
define ("MAX_SIZE",100);
class dangkythanhvien extends Model {
    public function __construct(){
		 parent::__construct();
    }
    public function dangkythanhvien(){
        $username = addslashes(trim($_POST['username']));
                     $maquantri = "SC_TV".$username;
                     $fullname = addslashes(trim($_POST['fullname']));
                     $birthday = $_POST['birth'];
                     $address = addslashes(trim($_POST['address']));
                     $email = trim($_POST['email']);
                     $phone = addslashes(trim($_POST['phonenum']));
                     $socmnd = addslashes(trim($_POST['socmnd']));
                     $password = md5(addslashes(trim($_POST['password'])));
                    $name[0]=$_FILES['image']['name'][0];
                    $name[1]=$_FILES['image']['name'][1];
                    $name[2]=$_FILES['image']['name'][2];
                    //Lấy phần mở rộng của file
                    $type[0] = $_FILES['image']['type'][0];
                    $type[1] = $_FILES['image']['type'][1];
                    $type[2] = $_FILES['image']['type'][2];
                    for($i=0; $i<3; $i++){
                         if (($type[$i] !="image/png") )
                        {
                            print ' <h1>Đây không phải là file hình!</h1>';
                            return FALSE;
                        }
                    }
                    //Lấy dung lượng của file upload
                    $size[0]=$_FILES['image']['size'][0];
                    $size[1]=$_FILES['image']['size'][1];
                    $size[2]=$_FILES['image']['size'][2];
                    for($i=0; $i>3; $i++)
                    {
                        if ($size > MAX_SIZE*1024)
                        {
                            print '<h1>Vượt quá dung lượng cho phép!</h1>';
                            return FALSE;
                        }
                    }
                    // đặt tên mới cho file hình up lên
                    $newname[0]="$mathanhvien"."_avatar".".png";
                    $newname[1]="$mathanhvien"."_cmdnt".".png";
                    $newname[2]="$mathanhvien"."_cmnds".".png";                   
                    $avatar= "upload/user/avatar/".$newname[0];
                    $cmndt= "upload/user/cmnd/".$newname[1];
                    $cmnds= "upload/user/cmnd/".$newname[2];                   
                    move_uploaded_file($_FILES['image']['tmp_name'][0], $avatar);
                    move_uploaded_file($_FILES['image']['tmp_name'][1], $cmndt);
                    move_uploaded_file($_FILES['image']['tmp_name'][2], $cmnds);
                    if (!file_exists($avatar) || !file_exists($cmndt) || !file_exists($cmnds))
                        {
                            print  'Tải hình lên không thành công'.'<br>'.'Đăng ký không thành công';
                            return FALSE;
                        }
                    $sqltk = "INSERT INTO"
                            . " taikhoan(MATAIKHOAN, TENDANGNHAP, MATKHAU)"
                            . " VALUES('$mathanhvien', '$username', '$password')";
                    $sql = "INSERT INTO"
                            . " thanhvien(MATHANHVIEN, TENTHANHVIEN, NGAYSINH, DIACHI, EMAIL, SODIENTHOAI, SOCMND, HINHDAIDIEN, HINHCMNDT, HINHCMNDS, TINHTRANG)"
                            . " VALUES('$mathanhvien', '$fullname', '$birthday', '$address', '$email' ,'$phone', '$socmnd', '$avatar','$cmndt', '$cmnds',1)";
                     if ($this->exec($sql) == 1 && $this->exec($sqltk) == 1) {
                         return TRUE;
                    } else {
                        return FALSE;
                    }
        
    }
     public function account_exists($tendangnhap) {
            $kq= FALSE;
            try{
                $sql ="SELECT * FROM TAIKHOAN WHERE TENDANGNHAP='".$tendangnhap."'";
                if($this->numrows($sql)>0){
                $kq= TRUE;
            }
            } catch(Exception $ex){
                print_r($ex->getMessage());
            }
            return $kq;
        }
}
