<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define('DB_NAME', 'cms_wp');

/** Username của database */
define('DB_USER', 'root');

/** Mật khẩu của database */
define('DB_PASSWORD', '');

/** Hostname của database */
define('DB_HOST', 'localhost');

/** Database charset sử dụng để tạo bảng database. */
define('DB_CHARSET', 'utf8mb4');

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'LE.z#)A(|e/j%iKMO4X*Ee3*+VMq^a/#nio,^{l~%teyLlM$BH)S3#l[:y-R;#~R');
define('SECURE_AUTH_KEY',  '(b>sVAju|gbTAKn|+)oG_hc*#7yCFps4kitqg$g*QV+NzK3YgEZh88H^Y[CQCkKk');
define('LOGGED_IN_KEY',    '$aK%Lau?W@Z`S&C!WmVC_5FcT)Ec2}5:r[:}:VL4/ZY2|7/ASf;A;Kg=,&-rv_ve');
define('NONCE_KEY',        '$8<7Om7 JlSdrdZ#S8l:9$<)ror]FjGh%)TpyOicnz.vK&%K960.F$Q`Ks`3CH{c');
define('AUTH_SALT',        '<??AUo=Z[Ea*g)Jp3CZ;3oQ}4sss:V[grb-a`z5?m^0/LE%G@$zg.Ppi_vs^`?nE');
define('SECURE_AUTH_SALT', 'AfVJ_<)H, ( _a>P(=F@7p 8VaeX;E_U0tVViEG4`?Jn }28IUw3:!at@Yc[]^]C');
define('LOGGED_IN_SALT',   ']zo1~Z:c))bEK5>fjKK=;ne}Zs85h:rap;?f{Q7IsdpG]hUCC%.dAE~!L=5IOIk4');
define('NONCE_SALT',       'G5!#}qEOH4jNznu5K){PZp[Ei-{+.C}]=4VQvzzyL Aq]6!$@wj nQWUGl+<A,;(');

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'wp_';

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', FALSE);
define('WP_MEMORY_LIMIT', '64M');
/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
