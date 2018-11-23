<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $meta['title'] ?></title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<style type="text/css">
	body { padding: 0; margin: 50px 0; font-family: Verdana, Arial, Tahoma; font-size: 15px; color: #333 }
	.yesno { text-align: center; padding-top: 20px }
	.yesno a { color: #fff; text-decoration: none; padding: 10px 15px; margin-right: 5px; display: inline-block; background: #444; border: 1px solid #000; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; -khtml-border-radius: 5px }
</style>

</head>
<body>
<table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
	<tbody>
    	<tr>
        	<td style="line-height: 24px; border-bottom: 1px solid #c0c0c0; padding-bottom: 15px" align="center">Nếu anh/chị từ chối nhận email, vui lòng nhấn vào nút "Từ chối nhận email" bên dưới. Email của anh/chị sẽ đưa ra khỏi danh sách nhận email <br /><?php echo $email ?></td>
        </tr>
        <tr>
        	<td class="yesno"><a href="<?php echo $unsub_url ?>">Từ chối nhận email</a><a href="<?php echo $skip ?>">Bỏ qua</a></td>
        </tr>
    </tbody>
</table>
</body>
</html>